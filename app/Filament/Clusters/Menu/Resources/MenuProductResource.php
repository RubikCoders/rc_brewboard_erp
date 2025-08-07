<?php

namespace App\Filament\Clusters\Menu\Resources;

use App\Filament\Clusters\Menu;
use App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;
use App\Models\Ingredient;
use App\Models\MenuProduct;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class MenuProductResource extends Resource
{
    protected static ?string $model = MenuProduct::class;

    protected static ?string $cluster = Menu::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    // protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 300;

    public static function getModelLabel(): string
    {
        return __('product.product');
    }

    public static function getPluralModelLabel(): string
    {
        return __('product.model');
    }

    public static function getNavigationLabel(): string
    {
        return __('product.navigation.products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('product.sections.basic_info.title'))
                    ->description(__('product.sections.basic_info.description'))
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('product.fields.name'))
                                    ->placeholder(__('product.fields.name_placeholder'))
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Forms\Components\Select::make('category_id')
                                    ->label(__('product.fields.category_id'))
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('category.fields.name'))
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('description')
                                            ->label(__('category.fields.description'))
                                            ->maxLength(500),
                                    ])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->columnSpan(2),

                Forms\Components\Section::make(__('product.sections.details.title'))
                    ->description(__('product.sections.details.description'))
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label(__('product.fields.description'))
                            ->placeholder(__('product.fields.description_placeholder'))
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('ingredients')
                            ->label(__('product.fields.ingredients'))
                            ->placeholder(__('product.fields.ingredients_placeholder'))
                            ->hint('Este campo es para mostrar ingredientes al cliente. El control de inventario se maneja por separado.')
                            ->hintColor('primary')
                            ->maxLength(500)
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image_url')
                            ->label(__('product.fields.image_url'))
                            ->image()
                            ->directory('products')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                Forms\Components\Section::make(__('product.sections.pricing.title'))
                    ->description(__('product.sections.pricing.description'))
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('base_price')
                                    ->label(__('product.fields.base_price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('estimated_time_min')
                                    ->label(__('product.fields.estimated_time_min'))
                                    ->required()
                                    ->numeric()
                                    ->suffix('min')
                                    ->minValue(1)
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('is_available')
                                    ->label(__('product.fields.is_available'))
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                    ])
                    ->columnSpan(2),

                // Sección de ingredientes del producto
                Forms\Components\Section::make('Ingredientes del Producto')
                    ->description('Define los ingredientes base necesarios para preparar este producto')
                    ->schema([
                        Forms\Components\Repeater::make('productIngredients')
                            ->relationship()
                            ->label("Ingredientes")
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Select::make('ingredient_type')
                                            ->label('Tipo de Ingrediente')
                                            ->options([
                                                Ingredient::class => 'Materia Prima',
                                                MenuProduct::class => 'Producto Compuesto',
                                            ])
                                            ->required()
                                            ->reactive()
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('ingredient_id')
                                            ->label('Ingrediente')
                                            ->options(function (callable $get) {
                                                $type = $get('ingredient_type');
                                                if ($type === Ingredient::class) {
                                                    return Ingredient::active()->pluck('name', 'id')->toArray();
                                                } elseif ($type === MenuProduct::class) {
                                                    return MenuProduct::available()->pluck('name', 'id')->toArray();
                                                }
                                                return [];
                                            })
                                            ->searchable()
                                            ->required()
                                            ->reactive()
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('quantity_needed')
                                            ->label('Cantidad')
                                            ->required()
                                            ->numeric()
                                            ->step(0.01)
                                            ->minValue(0.01)
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('unit')
                                            ->label('Unidad')
                                            ->placeholder('ml, g, shots, etc.')
                                            ->required()
                                            ->columnSpan(1),
                                    ]),

                                Forms\Components\Textarea::make('notes')
                                    ->label('Notas')
                                    ->placeholder('Instrucciones especiales...')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->addActionLabel('Agregar Ingrediente')
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),

                // Sección de personalizaciones (existente, mantener como está)
                Forms\Components\Section::make(__('product.sections.customizations.title'))
                    ->description(__('product.sections.customizations.description'))
                    ->schema([
                        Forms\Components\Repeater::make('customizations')
                            ->relationship()
                            ->label("Personalizaciones")
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('product.fields.customization_name'))
                                            ->placeholder(__('product.fields.customization_name_placeholder'))
                                            ->required()
                                            ->columnSpan(1),

                                        Forms\Components\Toggle::make('required')
                                            ->label(__('product.fields.customization_required'))
                                            ->default(false)
                                            ->columnSpan(1),
                                    ]),

                                Forms\Components\Repeater::make('options')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('product.fields.option_name'))
                                                    ->placeholder(__('product.fields.option_name_placeholder'))
                                                    ->required()
                                                    ->columnSpan(1),

                                                Forms\Components\TextInput::make('extra_price')
                                                    ->label(__('product.fields.option_extra_price'))
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->step(0.01)
                                                    ->minValue(0)
                                                    ->default(0)
                                                    ->columnSpan(1),
                                            ])
                                    ])
                                    ->addActionLabel('Agregar Opción')
                                    ->collapsible()
                                    ->cloneable()
                                    ->columnSpanFull()
                                    ->defaultItems(1)
                                    ->minItems(1)
                                    ->maxItems(20)
                            ])
                            ->addActionLabel(__('product.customizations.add_type'))
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Imagen')
                    ->circular()
                    ->getStateUsing(function ($record): ?string {
                        if ($record->image_url && str_contains($record->image_url, '/storage/products/')) {
                            $filename = basename($record->image_url);

                            if (file_exists(storage_path('app/public/products/' . $filename))) {
                                return asset('storage/products/' . $filename);
                            }
                        }

                        if ($record->image_path) {
                            if (!str_starts_with($record->image_path, '/')) {
                                if (file_exists(storage_path('app/public/' . $record->image_path))) {
                                    return asset('storage/' . $record->image_path);
                                }
                            } else {
                                $filename = basename($record->image_path);

                                if (file_exists(storage_path('app/public/products/' . $filename))) {
                                    return asset('storage/products/' . $filename);
                                }
                            }
                        }

                        return null;
                    })
                    ->defaultImageUrl('/images/placeholder-product.jpg'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('product.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('product.fields.category_id'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('base_price')
                    ->label(__('product.fields.base_price'))
                    ->prefix('$')
                    ->money('MXN')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estimated_time_min')
                    ->label(__('product.fields.estimated_time_min'))
                    ->numeric(0)
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_available')
                    ->label(__('product.fields.is_available'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label(__('product.fields.category_id')),

                Tables\Filters\TernaryFilter::make('is_available')
                    ->label(__('product.fields.is_available')),

                // Nuevos filtros
                Tables\Filters\Filter::make('can_be_prepared')
                    ->label('Pueden prepararse')
                    ->query(fn(Builder $query) => $query->where(function ($query) {
                        $query->whereDoesntHave('productIngredients')
                            ->orWhereHas('productIngredients', function ($query) {
                                // Esto sería más complejo, simplificamos por ahora
                                $query->whereHas('ingredient');
                            });
                    })),

                Tables\Filters\Filter::make('missing_ingredients')
                    ->label('Faltan ingredientes')
                    ->query(fn(Builder $query) => $query->whereHas('productIngredients')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('toggle_availability')
                        ->label('Deshabilitar producto')
                        ->icon(fn(MenuProduct $record) => $record->is_available ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                        ->color(fn(MenuProduct $record) => $record->is_available ? 'info' : 'success')
                        ->action(function (MenuProduct $record) {
                            $record->update(['is_available' => !$record->is_available]);
                        })
                        ->requiresConfirmation()
                        ->modalHeading(
                            fn(MenuProduct $record) =>
                            $record->is_available ? 'Deshabilitar producto' : 'Habilitar producto'
                        )
                        ->modalDescription(
                            fn(MenuProduct $record) =>
                            $record->is_available
                                ? 'El producto no estará disponible para ordenar'
                                : 'El producto estará disponible para ordenar'
                        ),
                    Tables\Actions\DeleteAction::make()
                        ->tooltip('Eliminar Producto')
                        ->requiresConfirmation()
                        ->hiddenLabel(),
                ])
                    ->label('')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->tooltip('Más acciones'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // Nueva acción masiva
                    Tables\Actions\BulkAction::make('toggle_availability')
                        ->label('Cambiar Disponibilidad')
                        ->icon('heroicon-o-eye')
                        ->form([
                            Forms\Components\Select::make('availability')
                                ->label('Establecer como')
                                ->options([
                                    true => 'Disponible',
                                    false => 'No disponible',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each(function (MenuProduct $record) use ($data) {
                                $record->update(['is_available' => $data['availability']]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([5, 10, 25, 50])
            ->defaultPaginationPageOption(5)
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->extremePaginationLinks();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('product.view.sections.main_info.title'))
                    ->description(__('product.view.sections.main_info.description'))
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\ImageEntry::make('image_url')
                                    ->label(__('product.fields.image_url'))
                                    ->height(200)
                                    ->width(200)
                                    ->defaultImageUrl('/images/placeholder-product.png')
                                    ->columnSpan(1),

                                Infolists\Components\Grid::make(1)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label(__('product.fields.name'))
                                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                            ->weight(FontWeight::Bold),

                                        Infolists\Components\TextEntry::make('category.name')
                                            ->label(__('product.view.labels.category'))
                                            ->badge(),

                                        Infolists\Components\TextEntry::make('description')
                                            ->label(__('product.fields.description'))
                                            ->placeholder('Sin descripción'),
                                    ])
                                    ->columnSpan(2),
                            ]),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('base_price')
                                    ->label(__('product.view.labels.base_price'))
                                    ->money('MXN')
                                    ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->color('success'),

                                Infolists\Components\TextEntry::make('estimated_time_min')
                                    ->label(__('product.view.labels.preparation_time'))
                                    ->suffix(' minutos')
                                    ->icon('heroicon-o-clock'),

                                Infolists\Components\IconEntry::make('is_available')
                                    ->label(__('product.view.labels.status'))
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ])
                    ])
                    ->columnSpan(2),

                // Nueva sección de disponibilidad de inventario
                Infolists\Components\Section::make('Estado de Disponibilidad')
                    ->description('Información del inventario y disponibilidad actual')
                    ->schema([
                        Infolists\Components\ViewEntry::make('availability_details')
                            ->view('filament.infolists.entries.product-availability-details')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                // Nueva sección de ingredientes
                Infolists\Components\Section::make('Ingredientes Requeridos')
                    ->description('Materias primas y productos necesarios para la preparación')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('productIngredients')
                            ->schema([
                                Infolists\Components\Grid::make(4)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('ingredient.name')
                                            ->label('Ingrediente')
                                            ->weight(FontWeight::Medium),

                                        Infolists\Components\TextEntry::make('quantity_needed')
                                            ->label('Cantidad')
                                            ->suffix(fn($record) => ' ' . $record->unit),

                                        Infolists\Components\TextEntry::make('ingredient_type')
                                            ->label('Tipo')
                                            ->formatStateUsing(
                                                fn(string $state) =>
                                                $state === Ingredient::class ? 'Materia Prima' : 'Producto'
                                            )
                                            ->badge()
                                            ->color(
                                                fn(string $state) =>
                                                $state === Ingredient::class ? 'primary' : 'warning'
                                            ),

                                        Infolists\Components\ViewEntry::make('stock_status')
                                            ->label('Stock')
                                            ->view('filament.infolists.entries.ingredient-stock-status'),
                                    ]),

                                Infolists\Components\TextEntry::make('notes')
                                    ->label('Notas')
                                    ->placeholder('Sin notas especiales')
                                    ->columnSpanFull(),
                            ])
                            ->placeholder('No se han definido ingredientes para este producto')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),

                // Sección de personalizaciones (existente, mantener)
                Infolists\Components\Section::make(__('product.view.sections.customizations.title'))
                    ->description(__('product.view.sections.customizations.description'))
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('customizations')
                            ->schema([
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->label(__('product.view.labels.customization_type'))
                                            ->weight(FontWeight::Bold)
                                            ->icon('heroicon-o-cog-6-tooth'),

                                        Infolists\Components\IconEntry::make('required')
                                            ->label(__('product.view.labels.is_required'))
                                            ->boolean()
                                            ->trueIcon('heroicon-o-exclamation-triangle')
                                            ->falseIcon('heroicon-o-check')
                                            ->trueColor('warning')
                                            ->falseColor('success'),
                                    ]),

                                Infolists\Components\RepeatableEntry::make('options')
                                    ->label('Opciones Disponibles')
                                    ->schema([
                                        Infolists\Components\Grid::make(3)
                                            ->schema([
                                                Infolists\Components\TextEntry::make('name')
                                                    ->label('Opción')
                                                    ->weight(FontWeight::Medium),

                                                Infolists\Components\TextEntry::make('extra_price')
                                                    ->label('Precio Adicional')
                                                    ->money('MXN')
                                                    ->color('success'),

                                                Infolists\Components\ViewEntry::make('availability')
                                                    ->label('Disponibilidad')
                                                    ->view('filament.infolists.entries.customization-availability'),
                                            ])
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->placeholder('No se han configurado tipos de personalización para este producto')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),

                // Sección de información del sistema (existente)
                Infolists\Components\Section::make(__('product.view.sections.system_info.title'))
                    ->description(__('product.view.sections.system_info.description'))
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label(__('product.view.labels.creation_date'))
                                    ->dateTime(),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label(__('product.view.labels.last_update'))
                                    ->dateTime(),
                            ])
                    ])
                    ->columnSpan(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuProducts::route('/'),
            'create' => Pages\CreateMenuProduct::route('/create'),
            'view' => Pages\ViewMenuProduct::route('/{record}'),
            'edit' => Pages\EditMenuProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'customizations.options', 'productIngredients.ingredient', 'inventory']);
    }
}
