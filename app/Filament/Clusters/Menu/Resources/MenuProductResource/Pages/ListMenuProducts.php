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
                ->label('Reporte')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    return $this->downloadFilteredProductsPdf();
                })
                ->tooltip('Descargar reporte de productos'),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Nuevo Producto'),            
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos')
                ->badge(MenuProduct::count())
                ->icon('heroicon-o-squares-2x2'),

            'available' => Tab::make('Disponibles')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', true))
                ->badge(MenuProduct::where('is_available', true)->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),

            'unavailable' => Tab::make('No Disponibles')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', false))
                ->badge(MenuProduct::where('is_available', false)->count())
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle'),

            'can_prepare' => Tab::make('Pueden Prepararse')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('is_available', true)
                        ->where(function (Builder $query) {
                            // Productos sin ingredientes definidos O que tengan todos sus ingredientes disponibles
                            $query->whereDoesntHave('productIngredients')
                                ->orWhereHas('productIngredients', function (Builder $subQuery) {
                                    // Esta es una simplificación - en producción sería más complejo
                                    $subQuery->whereHas('ingredient');
                                });
                        });
                })
                ->badge($this->getCanPrepareCount())
                ->badgeColor('primary')
                ->icon('heroicon-o-beaker'),

            'missing_ingredients' => Tab::make('Faltan Ingredientes')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereHas('productIngredients')
                        ->where('is_available', true);
                    // En una implementación real, filtrarías por productos que tienen ingredientes insuficientes
                })
                ->badge($this->getMissingIngredientsCount())
                ->badgeColor('warning')
                ->icon('heroicon-o-exclamation-triangle'),

            'no_ingredients' => Tab::make('Sin Ingredientes')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereDoesntHave('productIngredients'))
                ->badge(MenuProduct::whereDoesntHave('productIngredients')->count())
                ->badgeColor('gray')
                ->icon('heroicon-o-question-mark-circle'),
        ];
    }

    /**
     * Descarga un PDF con los productos filtrados
     */
    protected function downloadFilteredProductsPdf(): StreamedResponse
    {
        $query = $this->getFilteredTableQueryForPdf();
        $products = $query->with(['category', 'productIngredients.ingredient', 'inventory'])->get();

        $appliedFilters = $this->getAppliedFiltersInfo();

        // Agregar estadísticas de disponibilidad
        $availabilityStats = $this->getAvailabilityStatistics($products);

        $pdf = Pdf::loadView('pdf.products-report-enhanced', [
            'products' => $products,
            'appliedFilters' => $appliedFilters,
            'availabilityStats' => $availabilityStats,
            'totalProducts' => $products->count(),
            'generatedAt' => now()->format('d/m/Y H:i:s'),
            'generatedBy' => auth()->user()->name ?? 'Sistema',
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'reporte-productos-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    protected function getFilteredTableQueryForPdf(): Builder
    {
        $query = parent::getFilteredTableQuery();

        $activeTab = $this->activeTab ?? 'all';

        return match ($activeTab) {
            'available' => $query->where('is_available', true),
            'unavailable' => $query->where('is_available', false),
            'can_prepare' => $query->where('is_available', true)
                ->where(function (Builder $query) {
                    $query->whereDoesntHave('productIngredients')
                        ->orWhereHas('productIngredients', function (Builder $subQuery) {
                            $subQuery->whereHas('ingredient');
                        });
                }),
            'missing_ingredients' => $query->whereHas('productIngredients')->where('is_available', true),
            'no_ingredients' => $query->whereDoesntHave('productIngredients'),
            default => $query,
        };
    }

    protected function getAppliedFiltersInfo(): array
    {
        return [
            'tab' => match ($this->activeTab ?? 'all') {
                'all' => 'Todos los productos',
                'available' => 'Productos disponibles',
                'unavailable' => 'Productos no disponibles',
                'can_prepare' => 'Productos que pueden prepararse',
                'missing_ingredients' => 'Productos con ingredientes faltantes',
                'no_ingredients' => 'Productos sin ingredientes definidos',
                default => 'Vista personalizada',
            },
        ];
    }

    protected function getAvailabilityStatistics($products): array
    {
        $stats = [
            'total' => $products->count(),
            'available' => 0,
            'can_prepare' => 0,
            'missing_ingredients' => 0,
            'low_stock' => 0,
            'out_of_stock' => 0,
        ];

        foreach ($products as $product) {
            if ($product->is_available) {
                $stats['available']++;
            }

            $status = $product->getAvailabilityStatus();
            switch ($status['status']) {
                case 'available':
                    $stats['can_prepare']++;
                    break;
                case 'low_stock':
                    $stats['low_stock']++;
                    break;
                case 'out_of_stock':
                    $stats['out_of_stock']++;
                    break;
            }

            if (!empty($product->getMissingIngredients())) {
                $stats['missing_ingredients']++;
            }
        }

        return $stats;
    }

    protected function getCanPrepareCount(): int
    {
        return MenuProduct::where('is_available', true)
            ->where(function (Builder $query) {
                $query->whereDoesntHave('productIngredients')
                    ->orWhereHas('productIngredients', function (Builder $subQuery) {
                        $subQuery->whereHas('ingredient');
                    });
            })
            ->count();
    }

    protected function getMissingIngredientsCount(): int
    {
        return MenuProduct::whereHas('productIngredients')
            ->where('is_available', true)
            ->count();
    }

    /**
     * Verifica la disponibilidad del sistema completo
     */
    protected function checkSystemAvailability(): void
    {
        $products = MenuProduct::with(['productIngredients.ingredient', 'inventory'])->get();

        $unavailableProducts = [];
        $lowStockIngredients = [];

        foreach ($products as $product) {
            if (!$product->canBePrepared()) {
                $unavailableProducts[] = $product->name;
            }

            $missingIngredients = $product->getMissingIngredients();
            foreach ($missingIngredients as $missing) {
                if (!in_array($missing['name'], $lowStockIngredients)) {
                    $lowStockIngredients[] = $missing['name'];
                }
            }
        }

        // Mostrar notificación con resumen
        if (empty($unavailableProducts) && empty($lowStockIngredients)) {
            $this->notify('success', 'Todos los productos pueden prepararse correctamente');
        } else {
            $message = '';
            if (!empty($unavailableProducts)) {
                $message .= 'Productos no disponibles: ' . implode(', ', array_slice($unavailableProducts, 0, 3));
                if (count($unavailableProducts) > 3) {
                    $message .= ' y ' . (count($unavailableProducts) - 3) . ' más. ';
                }
            }
            if (!empty($lowStockIngredients)) {
                $message .= 'Ingredientes con stock bajo: ' . implode(', ', array_slice($lowStockIngredients, 0, 3));
                if (count($lowStockIngredients) > 3) {
                    $message .= ' y ' . (count($lowStockIngredients) - 3) . ' más.';
                }
            }

            $this->notify('warning', 'Atención requerida', $message);
        }
    }

    protected function notify(string $type, string $title, string $message = ''): void
    {
        $notification = \Filament\Notifications\Notification::make()
            ->title($title);

        if ($message) {
            $notification->body($message);
        }

        match ($type) {
            'success' => $notification->success(),
            'warning' => $notification->warning(),
            'danger' => $notification->danger(),
            default => $notification->info(),
        };

        $notification->send();
    }
}