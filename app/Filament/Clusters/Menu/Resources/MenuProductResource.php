<?php

namespace App\Filament\Clusters\Menu\Resources;

use App\Filament\Clusters\Menu;
use App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;
use App\Models\MenuProduct;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Pages\SubNavigationPosition;
use App\Helpers\Money;

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
            Section::make(__('product.sections.basic_info.title'))
                ->description(__('product.sections.basic_info.description'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('product.fields.name'))
                        ->placeholder(__('product.fields.name_placeholder'))
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->columnSpan(2),

                    Select::make('category_id')
                        ->label(__('product.fields.category_id'))
                        ->options(MenuCategory::all()->pluck('name', 'id'))
                        ->required()
                        ->native(false)
                        ->preload()
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->collapsible(),

            Section::make(__('product.sections.details.title'))
                ->description(__('product.sections.details.description'))
                ->schema([
                    Textarea::make('description')
                        ->label(__('product.fields.description'))
                        ->placeholder(__('product.fields.description_placeholder'))
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('ingredients')
                        ->label(__('product.fields.ingredients'))
                        ->placeholder(__('product.fields.ingredients_placeholder'))
                        ->rows(2)
                        ->columnSpanFull(),

                    FileUpload::make('image_path')
                        ->label(__('product.fields.image_url'))
                        ->image()
                        ->directory('products')
                        ->visibility('public')
                        ->imageEditor()
                        ->columnSpanFull(),
                ])
                ->collapsible(),

            Section::make(__('product.sections.pricing.title'))
                ->description(__('product.sections.pricing.description'))
                ->schema([
                    TextInput::make('base_price')
                        ->label(__('product.fields.base_price'))
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0.01)
                        ->step(0.01)
                        ->columnSpan(1),

                    TextInput::make('estimated_time_min')
                        ->label(__('product.fields.estimated_time_min'))
                        ->required()
                        ->numeric()
                        ->suffix('min')
                        ->minValue(1)
                        ->columnSpan(1),

                    Toggle::make('is_available')
                        ->label(__('product.fields.is_available'))
                        ->default(true)
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->collapsible(),
        ];
    }
    //endregion

    //region Table methods
    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters([
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
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
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
            ImageColumn::make('image_path')
                ->label('')
                ->circular()
                ->size(50)
                ->checkFileExistence(false),

            TextColumn::make('name')
                ->label(__('product.fields.name'))
                ->searchable()
                ->sortable()
                ->weight('medium'),

            TextColumn::make('category.name')
                ->label(__('product.fields.category_id'))
                ->sortable()
                ->badge()
                ->color('primary'),

            TextColumn::make('base_price')
                ->label(__('product.fields.base_price'))
                ->sortable()
                ->getStateUsing(fn(MenuProduct $record): string => Money::format($record->base_price)),

            TextColumn::make('estimated_time_min')
                ->label(__('product.fields.estimated_time_min'))
                ->sortable()
                ->suffix(' min')
                ->color('gray'),

            IconColumn::make('is_available')
                ->label(__('product.fields.is_available'))
                ->boolean()
                ->sortable(),

            TextColumn::make('created_at')
                ->label(__('product.fields.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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