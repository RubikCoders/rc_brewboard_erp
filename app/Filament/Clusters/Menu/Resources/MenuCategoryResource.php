<?php

namespace App\Filament\Clusters\Menu\Resources;

use App\Filament\Clusters\Menu;
use App\Filament\Clusters\Menu\Resources\MenuCategoryResource\Pages;
use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\SubNavigationPosition;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MenuCategoryResource extends Resource
{
    protected static ?string $model = MenuCategory::class;

    protected static ?string $cluster = Menu::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'Categorías';
    }

    public static function getModelLabel(): string
    {
        return 'Categoría';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Categorías';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('category.sections.basic_info.title'))
                ->description(__('category.sections.basic_info.description'))
                ->icon('heroicon-o-information-circle')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('category.fields.name'))
                                ->placeholder(__('category.fields.name_placeholder'))
                                ->helperText(__('category.fields.name_help'))
                                ->required()
                                ->maxLength(100)
                                ->unique(ignoreRecord: true)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, $set) {
                                    if (filled($state)) {
                                        $set('name', ucwords(strtolower($state)));
                                    }
                                })
                                ->columnSpan(2),

                            Forms\Components\Textarea::make('description')
                                ->label(__('category.fields.description'))
                                ->placeholder(__('category.fields.description_placeholder'))
                                ->helperText(__('category.fields.description_help'))
                                ->maxLength(500)
                                ->rows(3)
                                ->columnSpan(2),
                        ]),
                ])
                ->collapsible()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('category.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-tag')
                    ->iconColor('primary')
                    ->copyable()
                    ->copyMessage('Nombre copiado')
                    ->wrap(),

                Tables\Columns\TextColumn::make('description')
                    ->label(__('category.fields.description'))
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    })
                    ->placeholder('Sin descripción')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('category.fields.products_count'))
                    ->counts('products')
                    ->badge()
                    ->color(fn(string $state): string => match (true) {
                        $state === '0' => 'gray',
                        $state >= '1' && $state <= '5' => 'warning',
                        $state > '5' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match (true) {
                        $state === '0' => 'heroicon-o-x-circle',
                        $state >= '1' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-minus-circle',
                    })
                    ->sortable()
                    ->url(
                        fn(MenuCategory $record): ?string =>
                        $record->products_count > 0
                            ? MenuProductResource::getUrl('index', [
                                'tableFilters' => [
                                    'category_id' => [
                                        'values' => [$record->id]
                                    ]
                                ]
                            ])
                            : null
                    )
                    ->tooltip(
                        fn(MenuCategory $record): string =>
                        $record->products_count > 0
                            ? "Clic para ver los {$record->products_count} producto(s) de esta categoría"
                            : 'Esta categoría no tiene productos'
                    )
                    // ->openUrlInNewTab(fn(MenuCategory $record): bool => $record->products_count > 0)
                    ->extraAttributes(
                        fn(MenuCategory $record): array =>
                        $record->products_count > 0
                            ? ['style' => 'cursor: pointer;']
                            : []
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('category.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('category.fields.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('products_status')
                    ->label('Estado de productos')
                    ->options([
                        'with_products' => __('category.filters.with_products'),
                        'without_products' => __('category.filters.without_products'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'with_products',
                            fn(Builder $query): Builder => $query->has('products'),
                        )->when(
                            $data['value'] === 'without_products',
                            fn(Builder $query): Builder => $query->doesntHave('products'),
                        );
                    })
                    ->indicator('Estado'),

                Tables\Filters\Filter::make('recent')
                    ->label('Creadas recientemente')
                    ->query(fn(Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7)))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->tooltip('Ver detalles de la categoría'),

                Tables\Actions\EditAction::make()
                    ->hiddenLabel()
                    ->tooltip('Editar categoría'),

                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->requiresConfirmation()
                    ->modalHeading('Eliminar categoría')
                    ->modalDescription(
                        fn(MenuCategory $record): string =>
                        $record->products_count > 0
                            ? "Esta categoría tiene {$record->products_count} producto(s) asociado(s). No se puede eliminar."
                            : '¿Estás seguro de que quieres eliminar esta categoría?'
                    )
                    ->modalSubmitActionLabel('Sí, eliminar')
                    ->tooltip('Eliminar categoría')
                    ->hidden(fn(MenuCategory $record): bool => $record->products_count > 0),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('category.bulk_actions.delete_selected'))
                        ->requiresConfirmation()
                        ->modalHeading(__('category.bulk_actions.delete_confirmation'))
                        ->modalDescription(__('category.bulk_actions.delete_warning'))
                        ->action(function (Collection $records) {
                            $deletedCount = 0;
                            $skippedCount = 0;

                            foreach ($records as $record) {
                                if ($record->products_count == 0) {
                                    $record->delete();
                                    $deletedCount++;
                                } else {
                                    $skippedCount++;
                                }
                            }

                            if ($deletedCount > 0) {
                                Notification::make()
                                    ->title("Se eliminaron {$deletedCount} categoría(s)")
                                    ->success()
                                    ->send();
                            }

                            if ($skippedCount > 0) {
                                Notification::make()
                                    ->title("Se omitieron {$skippedCount} categoría(s) con productos")
                                    ->warning()
                                    ->send();
                            }
                        }),
                ]),
            ])
            ->emptyStateHeading(__('category.empty_state.title'))
            ->emptyStateDescription(__('category.empty_state.description'))
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('category.empty_state.action'))
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('name', 'asc')
            ->striped()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('products')
            ->orderBy('name');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Descripción' => $record->description ?? 'Sin descripción',
            'Productos' => $record->products_count . ' producto(s)',
        ];
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuCategories::route('/'),
            'create' => Pages\CreateMenuCategory::route('/create'),
            'edit' => Pages\EditMenuCategory::route('/{record}/edit'),
        ];
    }
}
