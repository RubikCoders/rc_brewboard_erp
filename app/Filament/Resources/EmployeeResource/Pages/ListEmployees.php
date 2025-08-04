<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Empleado')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {        
        $totalEmployees = $this->getModel()::count();
        $employeesWithUser = $this->getModel()::whereNotNull('user_id')->count();
        $employeesWithoutUser = $totalEmployees - $employeesWithUser;
        $recentEmployees = $this->getModel()::where('created_at', '>=', now()->subDays(30))->count();

        return [
            'all' => Tab::make('Todos')
                ->badge($totalEmployees)
                ->badgeColor('primary')
                ->icon('heroicon-m-users'),

            'with_user' => Tab::make('Con Usuario')
                ->badge($employeesWithUser)
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('user_id'))
                ->icon('heroicon-m-check-circle'),

            'without_user' => Tab::make('Sin Usuario')
                ->badge($employeesWithoutUser)
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('user_id'))
                ->icon('heroicon-m-exclamation-triangle'),

            'recent' => Tab::make('Recientes')
                ->badge($recentEmployees)
                ->badgeColor('info')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subDays(30)))
                ->icon('heroicon-m-clock'),
        ];
    }

    public function refreshCounts(): void
    {
        Cache::forget('employee_tabs_counts');
        Cache::forget('employee_count');

        $this->redirect(request()->header('Referer'));
    }
}