<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMenuProduct extends CreateRecord
{
    protected static string $resource = MenuProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('product.notifications.created'))
            ->body('El producto "' . $this->getRecord()->name . '" ha sido registrado exitosamente en el sistema.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle image upload if needed
        if (isset($data['image_path']) && $data['image_path']) {
            $data['image_url'] = asset('storage/' . $data['image_path']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Any additional logic after product creation
        // For example, log the creation, update cache, etc.

        // Log product creation
        logger()->info('New menu product created', [
            'product_id' => $this->getRecord()->id,
            'product_name' => $this->getRecord()->name,
            'user_id' => auth()->id,
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCreateAnotherFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}