<?php

namespace App\Filament\Clusters\Menu\Resources\MenuCategoryResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuCategoryResource;
use App\Models\MenuCategory;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMenuCategories extends ListRecords
{
    protected static string $resource = MenuCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Nueva Categoría')
                ->tooltip('Crear nueva categoría'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todas')
                ->badge(MenuCategory::count())
                ->icon('heroicon-o-list-bullet'),

            'with_products' => Tab::make('Con productos')
                ->modifyQueryUsing(fn(Builder $query) => $query->has('products'))
                ->badge(MenuCategory::has('products')->count())
                ->icon('heroicon-o-check-circle'),

            'empty' => Tab::make('Sin productos')
                ->modifyQueryUsing(fn(Builder $query) => $query->doesntHave('products'))
                ->badge(MenuCategory::doesntHave('products')->count())
                ->icon('heroicon-o-x-circle'),
        ];
    }
}