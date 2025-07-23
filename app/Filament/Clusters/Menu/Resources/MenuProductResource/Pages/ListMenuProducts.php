<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use App\Models\MenuProduct;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMenuProducts extends ListRecords
{
    protected static string $resource = MenuProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos')
                ->icon('heroicon-o-squares-2x2')
                ->badge(MenuProduct::count()),

            'available' => Tab::make('Disponibles')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', true))
                ->badge(MenuProduct::where('is_available', true)->count())
                ->badgeColor('success'),

            'unavailable' => Tab::make('No Disponibles')
                ->icon('heroicon-o-x-circle')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_available', false))
                ->badge(MenuProduct::where('is_available', false)->count())
                ->badgeColor('danger'),

            'recent' => Tab::make('Recientes')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subWeek()))
                ->badge(MenuProduct::where('created_at', '>=', now()->subWeek())->count())
                ->badgeColor('info'),
        ];
    }
}