<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use App\Models\MenuProduct;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListMenuProducts extends ListRecords
{
    protected static string $resource = MenuProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    return $this->downloadFilteredProductsPdf();
                })
                ->tooltip('Descargar reporte de productos'),

            // Acción existente de crear
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Nuevo Producto'),
        ];
    }

    /**
     * Descarga un PDF con los productos filtrados
     */
    protected function downloadFilteredProductsPdf(): StreamedResponse
    {
        // Obtener los datos filtrados de la tabla actual
        $query = $this->getFilteredTableQueryForPdf();
        $products = $query->with(['category'])->get();

        // Obtener información de filtros aplicados
        $appliedFilters = $this->getAppliedFiltersInfo();

        // Generar el PDF
        $pdf = Pdf::loadView('pdf.products-report', [
            'products' => $products,
            'appliedFilters' => $appliedFilters,
            'totalProducts' => $products->count(),
            'generatedAt' => now()->format('d/m/Y H:i:s'),
            'generatedBy' => auth()->user()->name ?? 'Sistema',
        ]);

        // Configurar el PDF
        $pdf->setPaper('A4', 'portrait');

        // Generar nombre del archivo
        $filename = 'reporte-productos-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    protected function getFilteredTableQueryForPdf(): Builder
    {
        // Obtener la query filtrada usando el método padre
        $query = parent::getFilteredTableQuery();

        // Aplicar tab activo
        $activeTab = $this->activeTab ?? 'all';
        switch ($activeTab) {
            case 'available':
                $query->where('is_available', true);
                break;
            case 'unavailable':
                $query->where('is_available', false);
                break;
            case 'recent':
                $query->where('created_at', '>=', now()->subWeek());
                break;
        }

        return $query;
    }

    /**
     * Obtiene información sobre los filtros aplicados
     */
    protected function getAppliedFiltersInfo(): array
    {
        $filtersInfo = [];

        // Información del tab activo
        $activeTab = $this->activeTab ?? 'all';
        $tabNames = [
            'all' => 'Todos los productos',
            'available' => 'Solo productos disponibles',
            'unavailable' => 'Solo productos no disponibles',
            'recent' => 'Productos recientes (última semana)',
        ];
        $filtersInfo['tab'] = $tabNames[$activeTab] ?? 'Todos los productos';
        
        $activeFilters = [];

        try {
            $tableFilters = $this->getTable()->getFilters();

            foreach ($tableFilters as $filterName => $filter) {
                if ($filter->isActive()) {
                    $state = $filter->getState();

                    switch ($filterName) {
                        case 'category':
                            if (!empty($state['value'])) {
                                $category = \App\Models\MenuCategory::find($state['value']);
                                $activeFilters[] = "Categoría: " . ($category?->name ?? 'Desconocida');
                            }
                            break;

                        case 'is_available':
                            if ($state['value'] === true) {
                                $activeFilters[] = "Solo productos disponibles";
                            } elseif ($state['value'] === false) {
                                $activeFilters[] = "Solo productos no disponibles";
                            }
                            break;

                        case 'price_range':
                            $range = [];
                            if (!empty($state['price_from'])) {
                                $range[] = "desde $" . number_format($state['price_from'], 2);
                            }
                            if (!empty($state['price_to'])) {
                                $range[] = "hasta $" . number_format($state['price_to'], 2);
                            }
                            if (!empty($range)) {
                                $activeFilters[] = "Rango de precio: " . implode(' ', $range);
                            }
                            break;
                    }
                }
            }
        } catch (\Exception $e) {            
            $activeFilters[] = "Sin filtros aplicados";
        }

        // Búsqueda global
        try {
            $search = $this->getTable()->getSearch();
            if ($search) {
                $activeFilters[] = "Búsqueda: '{$search}'";
            }
        } catch (\Exception $e) {
            // Ignorar errores de búsqueda
        }

        $filtersInfo['filters'] = $activeFilters;

        return $filtersInfo;
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos')
                ->icon('heroicon-o-squares-2x2')
                ->badge(MenuProduct::count()),

            'available' => Tab::make('Disponibles')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', true))
                ->badge(MenuProduct::where('is_available', true)->count())
                ->badgeColor('success'),

            'unavailable' => Tab::make('No Disponibles')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', false))
                ->badge(MenuProduct::where('is_available', false)->count())
                ->badgeColor('danger'),

            'recent' => Tab::make('Recientes')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subWeek()))
                ->badge(MenuProduct::where('created_at', '>=', now()->subWeek())->count())
                ->badgeColor('info'),
        ];
    }
}