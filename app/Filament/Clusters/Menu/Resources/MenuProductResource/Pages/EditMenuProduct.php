<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditMenuProduct extends EditRecord
{
    protected static string $resource = MenuProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('product.notifications.deleted'))
                        ->body('El producto ha sido eliminado del sistema.')
                        ->duration(5000)
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('product.notifications.updated'))
            ->body('Los cambios del producto "' . $this->getRecord()->name . '" han sido guardados exitosamente.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle image upload if needed
        if (isset($data['image_path']) && $data['image_path']) {
            $data['image_url'] = asset('storage/' . $data['image_path']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Any additional logic after product update
        // For example, clear cache, update related records, etc.

        // Log product update
        logger()->info('Menu product updated', [
            'product_id' => $this->getRecord()->id,
            'product_name' => $this->getRecord()->name,
            'user_id' => auth()->id,
        ]);
    }
}