<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->before(function () {
                    if ($this->getRecord()->employee) {
                        $this->getRecord()->employee->update(['user_id' => null]);
                    }
                }),
        ];
    }

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return "Editar Usuario: {$record->name}";
    }
}