<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.pages.list-users';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Usuario')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'cssClass' => 'user-resource-tabs',
            'dataPage' => 'user-resource',
        ]);
    }

    public function getTabs(): array
    {
        $totalUsers = $this->getModel()::count();
        $usersWithEmployee = $this->getModel()::whereHas('employee')->count();
        $independentUsers = $totalUsers - $usersWithEmployee;
        $verifiedUsers = $this->getModel()::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;

        return [
            'all' => Tab::make('Todos')
                ->badge($totalUsers)
                ->badgeColor('primary')
                ->icon('heroicon-m-users'),

            'with_employee' => Tab::make('Con Empleado')
                ->badge($usersWithEmployee)
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('employee'))
                ->icon('heroicon-m-briefcase'),

            'independent' => Tab::make('Independientes')
                ->badge($independentUsers)
                ->badgeColor('gray')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereDoesntHave('employee'))
                ->icon('heroicon-m-user'),

            'verified' => Tab::make('Verificados')
                ->badge($verifiedUsers)
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('email_verified_at'))
                ->icon('heroicon-m-check-badge'),

            'unverified' => Tab::make('Sin Verificar')
                ->badge($unverifiedUsers)
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('email_verified_at'))
                ->icon('heroicon-m-exclamation-triangle'),
        ];
    }
}