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
    protected static string $view = 'filament.pages.list-employees';

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
        $counts = Cache::remember('employee_tabs_counts', 300, function () {
            $model = $this->getModel();

            return [
                'total' => $model::count(),
                'with_user' => $model::whereNotNull('user_id')->count(),
                'without_user' => $model::whereNull('user_id')->count(),
                'recent' => $model::where('created_at', '>=', now()->subDays(30))->count(),
            ];
        });

        return [
            'all' => Tab::make('Todos')
                ->badge($counts['total'])
                ->badgeColor('primary')
                ->icon('heroicon-m-users'),

            'with_user' => Tab::make('Con Usuario')
                ->badge($counts['with_user'])
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('user_id'))
                ->icon('heroicon-m-check-circle'),

            'without_user' => Tab::make('Sin Usuario')
                ->badge($counts['without_user'])
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('user_id'))
                ->icon('heroicon-m-exclamation-triangle'),

            'recent' => Tab::make('Recientes')
                ->badge($counts['recent'])
                ->badgeColor('info')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('created_at', '>=', now()->subDays(30)))
                ->icon('heroicon-m-clock'),
        ];
    }

    public function updated($name, $value): void
    {
        parent::updated($name, $value);

        if ($name === 'activeTab') {
            Cache::forget('employee_tabs_counts');
        }
    }

    public function refreshCounts(): void
    {
        Cache::forget('employee_tabs_counts');
        Cache::forget('employee_count');

        $this->redirect(request()->header('Referer'));
    }
}