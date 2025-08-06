<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Inventory;
use App\Models\Ingredient;
use App\Models\MenuProduct;
use App\Models\CustomizationOption;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListInventory extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [            
            
            Actions\Action::make('inventory_report')
                ->label(__('inventory.actions.report'))
                ->icon('heroicon-o-document-chart-bar')
                ->color('success')
                ->action(function () {
                    return $this->downloadInventoryReport();
                })
                ->tooltip(__('inventory.tooltips.report')),

            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label(__('inventory.actions.create')),
            
            Actions\Action::make('check_all_inventory')
                ->label(__('inventory.actions.check_all'))
                ->icon('heroicon-o-clipboard-document-check')
                ->color('info')
                ->action(function () {
                    $this->checkInventoryStatus();
                })
                ->tooltip(__('inventory.tooltips.check_all')),

            // Acción para importar datos (a consideracion)
            // Actions\Action::make('import_inventory')
            //     ->label(__('inventory.actions.import'))
            //     ->icon('heroicon-o-arrow-up-tray')
            //     ->color('warning')
            //     ->form([
            //         \Filament\Forms\Components\FileUpload::make('file')
            //             ->label(__('inventory.fields.import_file'))
            //             ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
            //             ->required(),
            //     ])
            //     ->action(function (array $data) {
            //         // Lógica de importación aquí
            //         $this->notify('success', __('inventory.notifications.imported'));
            //     }),            
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('inventory.tabs.all'))
                ->badge(Inventory::count())
                ->icon('heroicon-o-cube'),

            'low_stock' => Tab::make(__('inventory.tabs.low_stock'))
                ->modifyQueryUsing(fn(Builder $query) => $query->lowStock())
                ->badge(Inventory::lowStock()->count())
                ->badgeColor('warning')
                ->icon('heroicon-o-exclamation-triangle'),

            'out_of_stock' => Tab::make(__('inventory.tabs.out_of_stock'))
                ->modifyQueryUsing(fn(Builder $query) => $query->outOfStock())
                ->badge(Inventory::outOfStock()->count())
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle'),

            'critical' => Tab::make(__('inventory.tabs.critical'))
                ->modifyQueryUsing(fn(Builder $query) => $query->criticalStock())
                ->badge(Inventory::criticalStock()->count())
                ->badgeColor('danger')
                ->icon('heroicon-o-fire'),

            'excess' => Tab::make(__('inventory.tabs.excess'))
                ->modifyQueryUsing(fn(Builder $query) => $query->excessStock())
                ->badge(Inventory::excessStock()->count())
                ->badgeColor('info')
                ->icon('heroicon-o-arrow-up'),
        ];
    }

    /**
     * Verifica el estado general del inventario
     */
    protected function checkInventoryStatus(): void
    {
        $stats = Inventory::getGlobalStats();

        $criticalItems = Inventory::criticalStock()->with('stockable')->get();
        $outOfStockItems = Inventory::outOfStock()->with('stockable')->get();

        // Construir mensaje de estado
        $statusMessage = [];

        if ($stats['out_of_stock'] > 0) {
            $statusMessage[] = "{$stats['out_of_stock']} artículos agotados";
        }

        if ($stats['critical_stock'] > 0) {
            $statusMessage[] = "{$stats['critical_stock']} en stock crítico";
        }

        if ($stats['low_stock'] > 0) {
            $statusMessage[] = "{$stats['low_stock']} con stock bajo";
        }

        if (empty($statusMessage)) {
            $this->notify(
                'success',
                __('inventory.notifications.status_good'),
                __('inventory.messages.all_items_ok', ['total' => $stats['total_items']])
            );
        } else {
            $message = implode(', ', $statusMessage);
            $this->notify(
                'warning',
                __('inventory.notifications.attention_required'),
                $message
            );
        }
    }

    /**
     * Descarga reporte completo de inventario
     */
    protected function downloadInventoryReport(): StreamedResponse
    {
        $query = $this->getFilteredTableQuery();
        $inventoryItems = $query->with(['stockable'])->get();
        $stats = Inventory::getGlobalStats();

        $appliedFilters = $this->getAppliedFiltersInfo();

        $pdf = Pdf::loadView('pdf.inventory-report', [
            'inventoryItems' => $inventoryItems,
            'stats' => $stats,
            'appliedFilters' => $appliedFilters,
            'totalItems' => $inventoryItems->count(),
            'generatedAt' => now()->format('d/m/Y H:i:s'),
            'generatedBy' => auth()->user()->name ?? 'Sistema',
        ]);

        $pdf->setPaper('A4', 'landscape'); // Landscape para más columnas

        $filename = 'reporte-inventario-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function getFilteredTableQuery(): Builder
    {
        $query = parent::getFilteredTableQuery();
        $activeTab = $this->activeTab ?? 'all';

        return match ($activeTab) {
            'ingredients' => $query->byStockableType(Ingredient::class),
            'products' => $query->byStockableType(MenuProduct::class),
            'customizations' => $query->byStockableType(CustomizationOption::class),
            'low_stock' => $query->lowStock(),
            'out_of_stock' => $query->outOfStock(),
            'critical' => $query->criticalStock(),
            'excess' => $query->excessStock(),
            default => $query,
        };
    }

    protected function getAppliedFiltersInfo(): array
    {
        $activeTab = $this->activeTab ?? 'all';

        return [
            'tab' => match ($activeTab) {
                'all' => __('inventory.tabs.all'),
                'ingredients' => __('inventory.tabs.ingredients'),
                'products' => __('inventory.tabs.products'),
                'customizations' => __('inventory.tabs.customizations'),
                'low_stock' => __('inventory.tabs.low_stock'),
                'out_of_stock' => __('inventory.tabs.out_of_stock'),
                'critical' => __('inventory.tabs.critical'),
                'excess' => __('inventory.tabs.excess'),
                default => __('inventory.tabs.custom'),
            },
        ];
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