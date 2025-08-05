<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return \Filament\Notifications\Notification::make()
            ->success()
            ->title(__('inventory.notifications.created'))
            ->body(__('inventory.messages.item_created_successfully'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validar que no exista ya un inventario para este item
        $exists = \App\Models\Inventory::where('stockable_type', $data['stockable_type'])
            ->where('stockable_id', $data['stockable_id'])
            ->exists();

        if ($exists) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title(__('inventory.notifications.already_exists'))
                ->body(__('inventory.messages.inventory_already_exists'))
                ->send();

            $this->halt();
        }

        return $data;
    }
}