<?php

namespace App\Filament\Clusters\Menu\Resources;

use App\Filament\Clusters\Menu;
use App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;
use App\Models\MenuProduct;
use App\Models\MenuCategory;
use App\Helpers\Money;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;

class MenuProductResource extends Resource
{
    protected static ?string $model = MenuProduct::class;

    protected static ?string $cluster = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $recordTitleAttribute = 'name';

    //region Label methods
    public static function getNavigationLabel(): string
    {
        return __("product.navigation.products");
    }

    public static function getModelLabel(): string
    {
        return __("product.product");
    }

    public static function getPluralModelLabel(): string
    {
        return __("product.model");
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
    //endregion

    //region Form methods
    public static function form(Form $form): Form
    {
        return $form->schema(self::getFormFields());
    }

    /**
     * Get form fields for the product
     * @return array
     */
    public static function getFormFields(): array
    {
        return [
            Forms\Components\Section::make(__('product.sections.basic_info.title'))
                ->description(__('product.sections.basic_info.description'))
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('product.fields.name'))
                        ->placeholder(__('product.fields.name_placeholder'))
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->columnSpan(2),

                    Forms\Components\Select::make('category_id')
                        ->label(__('product.fields.category_id'))
                        ->options(MenuCategory::all()->pluck('name', 'id'))
                        ->required()
                        ->native(false)
                        ->preload()
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->collapsible(),

            Forms\Components\Section::make(__('product.sections.details.title'))
                ->description(__('product.sections.details.description'))
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label(__('product.fields.description'))
                        ->placeholder(__('product.fields.description_placeholder'))
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('ingredients')
                        ->label(__('product.fields.ingredients'))
                        ->placeholder(__('product.fields.ingredients_placeholder'))
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('image_path')
                        ->label(__('product.fields.image_url'))
                        ->image()
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1920')
                        ->imageResizeTargetHeight('1080')
                        ->maxSize(5120) // 5MB max
                        ->columnSpanFull(),
                ])
                ->collapsible(),

            Forms\Components\Section::make(__('product.sections.pricing.title'))
                ->description(__('product.sections.pricing.description'))
                ->schema([
                    Forms\Components\TextInput::make('base_price')
                        ->label(__('product.fields.base_price'))
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0.01)
                        ->step(0.01)
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
                ->columns(3)
                ->collapsible(),

            Forms\Components\Section::make(__('product.sections.customizations.title'))
                ->description(__('product.sections.customizations.description'))
                ->schema([
                    Forms\Components\Repeater::make('customizations')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('product.customizations.type_name'))
                                ->placeholder(__('product.customizations.type_name_placeholder'))
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->columnSpan(2),

                            Forms\Components\Toggle::make('required')
                                ->label(__('product.customizations.is_required'))
                                ->helperText(__('product.customizations.is_required_help'))
                                ->default(false)
                                ->columnSpan(1),
                        ])
                        ->columns(3)
                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? 'Nuevo tipo')
                        ->addActionLabel(__('product.customizations.add_type'))
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->cloneable()
                        ->columnSpanFull()
                        ->defaultItems(0)
                        // ->emptyStateIcon('heroicon-o-shopping-bag')
                        // ->emptyStateHeading(__('product.customizations.no_customizations'))
                        // ->emptyStateDescription(__('product.customizations.customizations_help'))
                        ,
                ])
                ->collapsible()
                ->collapsed()
                ->columnSpanFull(),
        ];
    }
    //endregion

    //region Table methods
    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters(self::getTableFilters())
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    /**
     * Get table columns for the products list
     * @return array
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('image_path')
                ->label('')
                ->circular()
                ->size(50)
                ->disk('public')
                ->getStateUsing(function (MenuProduct $record): ?string {
                    if (!$record->image_path) {
                        return null;
                    }
                    
                    if (!str_starts_with($record->image_path, '/')) {
                        return $record->image_path;
                    }

                    $filename = basename($record->image_path);
                    $relativePath = 'products/' . $filename;

                    if (file_exists(storage_path('app/public/' . $relativePath))) {
                        return $relativePath;
                    }

                    return null;
                })
                ->defaultImageUrl(asset('images/b-coffee.jpg')),

            Tables\Columns\TextColumn::make('name')
                ->label(__('product.fields.name'))
                ->searchable()
                ->sortable()
                ->weight('medium'),

            Tables\Columns\TextColumn::make('category.name')
                ->label(__('product.fields.category_id'))
                ->sortable()
                ->badge()
                ->color('primary'),

            Tables\Columns\TextColumn::make('base_price')
                ->label(__('product.fields.base_price'))
                ->sortable()
                ->getStateUsing(fn(MenuProduct $record): string => Money::format($record->base_price)),

            Tables\Columns\TextColumn::make('estimated_time_min')
                ->label(__('product.fields.estimated_time_min'))
                ->sortable()
                ->suffix(' min')
                ->color('gray'),

            Tables\Columns\TextColumn::make('customizations_count')
                ->label('Personalizaciones')
                ->counts('customizations')
                ->badge()
                ->color(fn(int $state): string => match (true) {
                    $state === 0 => 'gray',
                    $state <= 2 => 'warning',
                    default => 'success',
                })
                ->sortable(),

            Tables\Columns\IconColumn::make('is_available')
                ->label(__('product.fields.is_available'))
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('product.fields.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get table filters
     * @return array
     */
    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('category_id')
                ->label(__('product.fields.category_id'))
                ->options(MenuCategory::all()->pluck('name', 'id'))
                ->multiple()
                ->preload(),

            Tables\Filters\TernaryFilter::make('is_available')
                ->label(__('product.fields.is_available'))
                ->trueLabel('Solo disponibles')
                ->falseLabel('Solo no disponibles')
                ->native(false),

            Tables\Filters\TernaryFilter::make('has_customizations')
                ->label('Tiene Personalizaciones')
                ->placeholder('Todos los productos')
                ->trueLabel('Con personalizaciones')
                ->falseLabel('Sin personalizaciones')
                ->queries(
                    true: fn(Builder $query) => $query->has('customizations'),
                    false: fn(Builder $query) => $query->doesntHave('customizations'),
                )
                ->native(false),
        ];
    }
    //endregion

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuProducts::route('/'),
            'manage' => Pages\ManageMenuProducts::route('/manage'),
            'create' => Pages\CreateMenuProduct::route('/create'),
            'edit' => Pages\EditMenuProduct::route('/{record}/edit'),
            'view' => Pages\ViewMenuProduct::route('/{record}'),
        ];
    }
}