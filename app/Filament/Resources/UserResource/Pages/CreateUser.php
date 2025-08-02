<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Employee;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $employeeId = $data['employee_id'] ?? null;
        unset($data['employee_id']);

        $this->employeeId = $employeeId;

        return $data;
    }

    protected function afterCreate(): void
    {
        if (isset($this->employeeId) && $this->employeeId) {
            Employee::find($this->employeeId)->update(['user_id' => $this->getRecord()->id]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        $record = $this->getRecord();
        $message = "Usuario {$record->email} creado exitosamente.";

        if ($record->employee) {
            $message .= " Vinculado con el empleado {$record->employee->name}.";
        }

        return Notification::make()
            ->success()
            ->title('Usuario registrado')
            ->body($message);
    }
}