<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use App\Models\MenuProduct;
use App\Models\MenuCategory;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;

class ManageMenuProducts extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static string $resource = MenuProductResource::class;

    protected static string $view = 'filament.clusters.menu.resources.menu-product-resource.pages.manage-menu-products';

    protected ?string $heading = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getTitle(): string
    {
        return __('product.manage_products');
    }

    public function getHeading(): string
    {
        return __('product.manage_products');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Actualizar')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(fn() => $this->redirect(static::getUrl())),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('product_management')
                    ->tabs([
                        Tab::make(__('product.tabs.register'))
                            ->icon('heroicon-o-plus-circle')
                            ->schema([
                                Section::make(__('product.register_products'))
                                    ->description('Complete la información del producto y sus personalizaciones')
                                    ->schema(MenuProductResource::getFormFields())
                                    ->columnSpanFull(),
                            ])
                            ->columns(1),

                        Tab::make(__('product.tabs.list'))
                            ->icon('heroicon-o-table-cells')
                            ->schema([
                                Section::make(__('product.products_list'))
                                    ->description('Visualiza y gestiona todos los productos registrados')
                                    ->schema([
                                        Placeholder::make('products_table_placeholder')
                                            ->content(new HtmlString('
                                                <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                                                    <div class="fi-table">
                                                        <div class="p-6">
                                                            <div class="grid gap-y-4">
                                                                <div class="flex items-center justify-between">
                                                                    <h3 class="text-lg font-semibold text-gray-950 dark:text-white">
                                                                        Lista de Productos
                                                                    </h3>
                                                                    <div class="flex items-center gap-x-4">
                                                                        <div class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 fi-color-primary">
                                                                            <span class="grid">
                                                                                <span>Total: ' . MenuProduct::count() . '</span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 py-1 fi-color-success bg-success-50 text-success-600 ring-success-600/10">
                                                                            <span class="grid">
                                                                                <span>Disponibles: ' . MenuProduct::where('is_available', true)->count() . '</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                                                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tabla de productos</p>
                                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use el tab "Lista de Productos" estándar en la sub-navegación para gestionar productos existentes</p>
                                                                    <div class="mt-6">
                                                                        <a href="' . MenuProductResource::getUrl('index') . '" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                                                                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                            </svg>
                                                                            Ver Lista Completa
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            '))
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->activeTab(1)
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return MenuProductResource::table($table);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        // Validate the data
        $this->validate();

        try {
            if (isset($data['image_path']) && $data['image_path']) {
                // Si image_path es una ruta relativa (desde FileUpload), crear URL
                if (!str_starts_with($data['image_path'], '/')) {
                    $data['image_url'] = asset('storage/' . $data['image_path']);
                }
            }

            // Extract customizations data
            $customizationsData = $data['customizations'] ?? [];
            unset($data['customizations']);

            // Create the product
            $product = MenuProduct::create($data);

            // Create customizations if any
            if (!empty($customizationsData)) {
                foreach ($customizationsData as $customizationData) {
                    $product->customizations()->create([
                        'name' => $customizationData['name'],
                        'required' => $customizationData['required'] ?? false,
                    ]);
                }
            }

            // Show success notification
            $customizationsCount = count($customizationsData);
            $message = 'El producto "' . $product->name . '" ha sido registrado exitosamente.';
            if ($customizationsCount > 0) {
                $message .= " Se crearon {$customizationsCount} tipos de personalización.";
            }

            Notification::make()
                ->title(__('product.notifications.created'))
                ->body($message)
                ->success()
                ->duration(5000)
                ->send();

            // Reset the form
            $this->form->fill();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al crear el producto')
                ->body('Ocurrió un error inesperado: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label(__('product.actions.create'))
                ->color('primary')
                ->size('lg')
                ->icon('heroicon-o-check')
                ->action('create'),

            Action::make('createAnother')
                ->label(__('product.actions.save_and_create_another'))
                ->color('gray')
                ->size('lg')
                ->icon('heroicon-o-plus')
                ->action(function () {
                    $this->create();
                    // Form is already reset in create() method
                }),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'totalProducts' => MenuProduct::count(),
            'availableProducts' => MenuProduct::where('is_available', true)->count(),
            'categoriesCount' => MenuCategory::count(),
        ];
    }
}