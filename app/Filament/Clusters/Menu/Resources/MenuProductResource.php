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
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;

class MenuProductResource extends Resource
{
    protected static ?string $model = MenuProduct::class;

    protected static ?string $cluster = Menu::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    
    public static function getNavigationLabel(): string
    {
        return __("────୨ৎ────");
    }

    public static function getModelLabel(): string
    {
        return __("product.product");
    }

    public static function getPluralModelLabel(): string
    {
        return __("product.model");
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
                        ->hiddenLabel()
                        ->relationship()
                        ->schema([                            
                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label(__('product.customizations.type_name'))
                                        ->placeholder(__('product.customizations.type_name_placeholder'))
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->columnSpan(2)
                                        ->suffixIcon('heroicon-o-tag'),

                                    Forms\Components\Toggle::make('required')
                                        ->label(__('product.customizations.is_required'))
                                        ->helperText(__('product.customizations.is_required_help'))
                                        ->default(false)
                                        ->columnSpan(1)
                                        ->inline(false),
                                ]),
                            
                            Forms\Components\Section::make('Opciones de Personalización')
                                ->description('Define las opciones específicas que los clientes pueden seleccionar para este tipo de personalización')
                                ->schema([
                                    Forms\Components\Repeater::make('options')
                                        ->hiddenLabel()
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\Grid::make(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('name')
                                                        ->label(__('product.fields.option_name'))
                                                        ->placeholder(__('product.fields.option_name_placeholder'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->columnSpan(1)
                                                        ->prefixIcon('heroicon-o-check-circle'),

                                                    Forms\Components\TextInput::make('extra_price')
                                                        ->label(__('product.fields.option_extra_price'))
                                                        ->numeric()
                                                        ->prefix('$')
                                                        ->step(0.01)
                                                        ->minValue(0)
                                                        ->default(0)
                                                        ->columnSpan(1)
                                                        ->prefixIcon('heroicon-o-currency-dollar')
                                                        ->helperText('Precio adicional que se suma al precio base del producto'),
                                                ])
                                        ])
                                        ->itemLabel(
                                            fn(array $state): ?string =>
                                            $state['name'] ?? 'Nueva opción'
                                        )
                                        ->addActionLabel(__('product.actions.add_option'))
                                        ->deleteAction(
                                            fn(Forms\Components\Actions\Action $action) => $action
                                                ->requiresConfirmation()
                                                ->modalHeading('Eliminar opción')
                                                ->modalDescription('¿Estás seguro que deseas eliminar esta opción? Esta acción no se puede deshacer.')
                                                ->modalSubmitActionLabel('Sí, eliminar')
                                        )
                                        ->collapsed()
                                        ->cloneable()
                                        ->collapsible()
                                        ->defaultItems(1)
                                        ->minItems(1)
                                        ->maxItems(20)
                                        ->orderColumn('id')
                                        ->reorderable()
                                        ->columnSpanFull()
                                        ->extraAttributes([
                                            'class' => 'options-repeater'
                                        ])
                                ])
                                ->columnSpanFull()
                                ->collapsible()
                                ->collapsed(false)
                                ->extraAttributes([
                                    'class' => 'customization-options-section'
                                ])
                        ])
                        ->itemLabel(
                            fn(array $state): ?string =>
                            !empty($state['name'])
                                ? $state['name'] . ($state['required'] ? ' (Requerido)' : ' (Opcional)')
                                : 'Nuevo tipo de personalización'
                        )
                        ->addActionLabel(__('product.customizations.add_type'))
                        ->deleteAction(
                            fn(Forms\Components\Actions\Action $action) => $action
                                ->requiresConfirmation()
                                ->modalHeading('Eliminar tipo de personalización')
                                ->modalDescription('¿Estás seguro que deseas eliminar este tipo de personalización y todas sus opciones? Esta acción no se puede deshacer.')
                                ->modalSubmitActionLabel('Sí, eliminar')
                        )
                        ->collapsed()
                        ->cloneable()
                        ->collapsible()
                        ->defaultItems(0)
                        ->minItems(0)
                        ->maxItems(15)
                        ->orderColumn('id')
                        ->reorderable()
                        ->columnSpanFull()
                        ->extraAttributes([
                            'class' => 'customizations-repeater'
                        ])
                ])
                ->collapsible()
                ->collapsed(false),
        ];
    }
    //endregion

    //region Table methods
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\ImageColumn::make('image_path')
                ->label('Imagen')
                ->circular()
                ->size(50)
                ->getStateUsing(fn($record) => $record->getImageOrDefault())
                ->defaultImageUrl(asset('images/placeholder-product.jpg')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('product.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('product.fields.category_id'))
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('base_price')
                    ->label(__('product.fields.base_price'))
                    ->money('MXN')
                    ->sortable()
                    ->prefix('$'),
                 

                Tables\Columns\TextColumn::make('estimated_time_min')
                    ->label(__('product.fields.estimated_time_min'))
                    ->numeric(0)
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_available')
                    ->label(__('product.fields.is_available'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('product.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label(__('product.fields.category_id'))
                    ->relationship('category', 'name')
                    ->preload()
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_available')
                    ->label(__('product.fields.is_available'))
                    ->boolean()
                    ->trueLabel('Solo disponibles')
                    ->falseLabel('Solo no disponibles')
                    ->native(false),

                Tables\Filters\Filter::make('base_price')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price_from')
                                    ->label('Precio desde')
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('price_to')
                                    ->label('Precio hasta')
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn(Builder $query, $price): Builder => $query->where('base_price', '>=', $price),
                            )
                            ->when(
                                $data['price_to'],
                                fn(Builder $query, $price): Builder => $query->where('base_price', '<=', $price),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
    //endregion

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuProducts::route('/'),
            'create' => Pages\CreateMenuProduct::route('/create'),
            'view' => Pages\ViewMenuProduct::route('/{record}'),
            'edit' => Pages\EditMenuProduct::route('/{record}/edit'),
            // 'manage' => Pages\ManageMenuProducts::route('/manage'),
        ];
    }
}
