<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Models\Ingredient;
use App\Models\MenuProduct;
use App\Models\CustomizationOption;
use App\Models\ProductCustomization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Gestión de Inventario';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('inventory.item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('inventory.model');
    }

    public static function getNavigationLabel(): string
    {
        return __('inventory.navigation.inventory');
    }

    public static function getNavigationBadge(): ?string
    {
        $criticalCount = Inventory::criticalStock()->count();
        return $criticalCount > 0 ? (string) $criticalCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $criticalCount = Inventory::criticalStock()->count();
        return $criticalCount > 0 ? 'danger' : null;
    }

    public static function form(Form $form): Form
    {
        return $form            
            ->schema([
                Forms\Components\Section::make(__('inventory.sections.item_info.title'))
                    ->description(__('inventory.sections.item_info.description'))
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Select::make('item_type')
                                    ->label(__('inventory.fields.item_type'))
                                    ->options([
                                        'ingredient' => __('inventory.options.ingredient'),
                                        'customization_option' => __('inventory.options.customization_option'),
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->rules(['required'])
                                    ->live()
                                    ->afterStateUpdated(fn(callable $set) => [
                                        $set('name', null),
                                        $set('unit', null),
                                        $set('category', null),
                                        $set('description', null),
                                        $set('customization_id', null),
                                        $set('extra_price', null),
                                    ])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->columnSpan(2),

                Forms\Components\Section::make(__('inventory.options.ingredient'))
                    ->description('Información de la materia prima')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('inventory.fields.ingredient_name'))
                                    ->placeholder('ej: Café soluble, Leche entera, Agua')
                                    ->rules(['required', 'string', 'max:255'])
                                    ->live(onBlur: true)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('unit')
                                    ->label(__('inventory.fields.ingredient_unit'))
                                    ->rules(['required', 'string', 'max:50'])
                                    ->placeholder(__('inventory.placeholders.ingredient_unit_placeholder'))
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('category')
                                    ->label(__('inventory.fields.ingredient_category'))
                                    ->rules(['nullable', 'string', 'max:100'])
                                    ->placeholder(__('inventory.placeholders.ingredient_category_placeholder'))
                                    ->columnSpan(1),

                                Forms\Components\Textarea::make('description')
                                    ->label(__('inventory.fields.ingredient_description'))
                                    ->rules(['nullable', 'string', 'max:500'])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->visible(fn(Forms\Get $get): bool => $get('item_type') === 'ingredient')
                    ->columnSpan(2),

                Forms\Components\Section::make(__('inventory.options.customization_option'))
                    ->description('Información de la opción de personalización')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('customization_id')
                                    ->label(__('inventory.fields.customization_parent'))
                                    ->options(ProductCustomization::pluck('name', 'id'))
                                    ->rules(['required', 'integer', 'exists:product_customizations,id'])
                                    ->searchable()
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('name')
                                    ->label(__('inventory.fields.customization_option_name'))
                                    ->rules(['required', 'string', 'max:255'])
                                    ->placeholder(__('inventory.placeholders.customization_option_placeholder'))
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('extra_price')
                                    ->label(__('inventory.fields.extra_price'))
                                    ->rules(['nullable', 'numeric', 'min:0'])
                                    ->step(0.01)
                                    ->prefix('$')
                            ])
                    ])
                    ->visible(fn(Forms\Get $get): bool => $get('item_type') === 'customization_option')
                    ->columnSpan(2),
                Forms\Components\Section::make(__('inventory.sections.stock_levels.title'))
                    ->description(__('inventory.sections.stock_levels.description'))
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('stock')
                                    ->label(__('inventory.fields.stock'))
                                    ->rules(['required', 'integer', 'min:0'])
                                    ->suffix(__('inventory.fields.units'))
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('min_stock')
                                    ->label(__('inventory.fields.min_stock'))
                                    ->rules(['required', 'integer', 'min:0'])
                                    ->suffix(__('inventory.fields.units'))
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('max_stock')
                                    ->label(__('inventory.fields.max_stock'))
                                    ->rules(['required', 'integer', 'min:0'])
                                    ->suffix(__('inventory.fields.units'))
                                    ->columnSpan(1),
                            ])
                    ])
                    ->columnSpan(2),
            ])
            ->columns(2)
            ->extraAttributes(['novalidate' => true]);;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('inventory.fields.id'))
                    ->prefix('#INV-')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('stockable_type')
                    ->label(__('inventory.fields.type'))
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        Ingredient::class => __('inventory.options.ingredient'),
                        MenuProduct::class => __('inventory.options.menu_product'),
                        CustomizationOption::class => __('inventory.options.customization_option'),
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        Ingredient::class => 'primary',
                        MenuProduct::class => 'success',
                        CustomizationOption::class => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('stockable.name')
                    ->label(__('inventory.fields.item_name'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->formatStateUsing(function ($record) {
                        if ($record->stockable_type === CustomizationOption::class) {
                            $option = $record->stockable;
                            return $option->customization->name . ' - ' . $option->name;
                        }
                        return $record->stockable?->name ?? __('inventory.unknown_item');
                    }),

                Tables\Columns\TextColumn::make('stock')
                    ->label(__('inventory.fields.current_stock'))
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->color(function (Inventory $record) {
                        return match ($record->getStockStatus()) {
                            'out_of_stock' => 'danger',
                            'critical' => 'danger',
                            'low' => 'warning',
                            'excess' => 'info',
                            'normal' => 'success',
                            default => 'gray',
                        };
                    }),

                Tables\Columns\ViewColumn::make('stock_status')
                    ->label(__('inventory.fields.status'))
                    ->view('filament.tables.columns.inventory-status')
                    ->sortable(false),

                Tables\Columns\TextColumn::make('min_stock')
                    ->label(__('inventory.fields.min_stock'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('max_stock')
                    ->label(__('inventory.fields.max_stock'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('stock_percentage')
                    ->label(__('inventory.fields.percentage'))
                    ->formatStateUsing(fn(Inventory $record) => round($record->getStockPercentage(), 1) . '%')
                    ->sortable(false)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('inventory.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stockable_type')
                    ->label(__('inventory.fields.type'))
                    ->options([
                        Ingredient::class => __('inventory.options.ingredient'),
                        MenuProduct::class => __('inventory.options.menu_product'),
                        CustomizationOption::class => __('inventory.options.customization_option'),
                    ])
                    ->native(false),

                Tables\Filters\Filter::make('low_stock')
                    ->label(__('inventory.filters.low_stock'))
                    ->query(fn(Builder $query) => $query->lowStock()),

                Tables\Filters\Filter::make('out_of_stock')
                    ->label(__('inventory.filters.out_of_stock'))
                    ->query(fn(Builder $query) => $query->outOfStock()),

                Tables\Filters\Filter::make('critical_stock')
                    ->label(__('inventory.filters.critical_stock'))
                    ->query(fn(Builder $query) => $query->criticalStock()),

                Tables\Filters\Filter::make('excess_stock')
                    ->label(__('inventory.filters.excess_stock'))
                    ->query(fn(Builder $query) => $query->excessStock()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('bulk_adjust')
                        ->label(__('inventory.actions.bulk_adjust'))
                        ->icon('heroicon-o-calculator')
                        ->color('primary')
                        ->form([
                            Forms\Components\Select::make('action_type')
                                ->label(__('inventory.fields.action_type'))
                                ->options([
                                    'add' => __('inventory.actions.add_stock'),
                                    'remove' => __('inventory.actions.remove_stock'),
                                ])
                                ->required(),

                            Forms\Components\TextInput::make('quantity')
                                ->label(__('inventory.fields.quantity'))
                                ->required()
                                ->numeric()
                                ->minValue(1),

                            Forms\Components\Textarea::make('reason')
                                ->label(__('inventory.fields.reason'))
                                ->placeholder(__('inventory.placeholders.bulk_reason'))
                                ->maxLength(255),
                        ])
                        ->action(function ($records, array $data) {
                            $quantity = (int) $data['quantity'];

                            $records->each(function (Inventory $record) use ($data, $quantity) {
                                match ($data['action_type']) {
                                    'add' => $record->add($quantity),
                                    'remove' => $record->consume($quantity),
                                };
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->paginated([8, 16, 24, 32])
            ->defaultPaginationPageOption(8)
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->extremePaginationLinks();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Sección principal de información del artículo
                Infolists\Components\Section::make(__('inventory.view.sections.item_details.title'))
                    ->description(__('inventory.view.sections.item_details.description'))
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('stockable.name')
                                    ->label(__('inventory.fields.item_name'))
                                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->formatStateUsing(function ($record) {
                                        if ($record->stockable_type === CustomizationOption::class) {
                                            $option = $record->stockable;
                                            return $option->customization->name . ' - ' . $option->name;
                                        }
                                        return $record->stockable?->name ?? __('inventory.unknown_item');
                                    })
                                    ->icon(fn($record) => match ($record->stockable_type) {
                                        Ingredient::class => 'heroicon-o-check-circle',
                                        CustomizationOption::class => 'heroicon-o-cog-6-check-circle',
                                        default => 'heroicon-o-cube'
                                    }),

                                Infolists\Components\TextEntry::make('stockable_type')
                                    ->label(__('inventory.fields.type'))
                                    ->formatStateUsing(fn(string $state) => match ($state) {
                                        Ingredient::class => __('inventory.options.ingredient'),
                                        MenuProduct::class => __('inventory.options.menu_product'),
                                        CustomizationOption::class => __('inventory.options.customization_option'),
                                        default => $state,
                                    })
                                    ->badge()
                                    ->color(fn(string $state) => match ($state) {
                                        Ingredient::class => 'primary',
                                        MenuProduct::class => 'success',
                                        CustomizationOption::class => 'warning',
                                        default => 'gray',
                                    }),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Última Actualización')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-o-clock')
                                    ->color('gray'),
                            ]),
                    ])
                    ->columnSpan(2),

                // Sección de estado actual mejorada
                Infolists\Components\Section::make(__('inventory.view.sections.stock_info.title'))
                    ->description(__('inventory.view.sections.stock_info.description'))
                    ->schema([
                        // Grid principal con métricas
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('stock')
                                    ->label(__('inventory.fields.current_stock'))
                                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->suffix(' unidades')
                                    ->color(function ($record) {
                                        return match ($record->getStockStatus()) {
                                            'out_of_stock', 'critical' => 'danger',
                                            'low' => 'warning',
                                            'excess' => 'info',
                                            'normal' => 'success',
                                            default => 'gray',
                                        };
                                    })
                                    ->icon(function ($record) {
                                        return match ($record->getStockStatus()) {
                                            'out_of_stock' => 'heroicon-o-x-circle',
                                            'critical' => 'heroicon-o-exclamation-triangle',
                                            'low' => 'heroicon-o-exclamation-circle',
                                            'excess' => 'heroicon-o-arrow-trending-up',
                                            'normal' => 'heroicon-o-check-circle',
                                            default => 'heroicon-o-cube',
                                        };
                                    }),

                                Infolists\Components\TextEntry::make('min_stock')
                                    ->label(__('inventory.fields.min_stock'))
                                    ->suffix(' unidades')
                                    ->color('gray')
                                    ->icon('heroicon-o-arrow-down-circle'),

                                Infolists\Components\TextEntry::make('max_stock')
                                    ->label(__('inventory.fields.max_stock'))
                                    ->suffix(' unidades')
                                    ->color('gray')
                                    ->icon('heroicon-o-arrow-up-circle'),
                            ]),                        
                    ])
                    ->columnSpan(2),                

                // Sección de información del sistema
                Infolists\Components\Section::make(__('inventory.view.sections.system_info.title'))
                    ->description(__('inventory.view.sections.system_info.description'))
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label(__('inventory.fields.created_at'))
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-o-plus-circle')
                                    ->color('success'),

                                Infolists\Components\TextEntry::make('id')
                                    ->label(__('inventory.fields.id'))
                                    ->prefix('INV-')
                                    ->copyable()
                                    ->icon('heroicon-o-hashtag')
                                    ->color('gray'),
                            ]),
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventory::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['stockable']);
    }
}