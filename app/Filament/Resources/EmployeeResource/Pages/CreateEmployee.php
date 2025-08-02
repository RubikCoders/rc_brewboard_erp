<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Empleado registrado')
            ->body('El empleado ha sido registrado correctamente. Ahora puedes crear su usuario si es necesario.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('crear_usuario')
                    ->button()
                    ->url($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]))
                    ->label('Crear Usuario'),
            ]);
    }
}