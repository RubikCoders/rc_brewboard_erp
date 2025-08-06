<?php

namespace App\Filament\Resources\EmployeeRoleResource\Pages;

use App\Filament\Resources\EmployeeRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeRole extends EditRecord
{
    protected static string $resource = EmployeeRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
