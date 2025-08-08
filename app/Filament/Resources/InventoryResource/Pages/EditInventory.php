<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Ingredient;
use App\Models\CustomizationOption;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventory extends EditRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        return \Filament\Notifications\Notification::make()
            ->success()
            ->title(__('inventory.notifications.updated'))
            ->body(__('inventory.messages.item_updated_successfully'));
    }

    /**
     * Prepara los datos antes de llenar el formulario para edición
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        $stockable = $record->stockable;

        if (!$stockable) {
            return $data;
        }

        // Determinar el tipo de elemento y mapear los datos
        if ($stockable instanceof Ingredient) {
            $data['item_type'] = 'ingredient';
            $data['name'] = $stockable->name;
            $data['unit'] = $stockable->unit;
            $data['category'] = $stockable->category;
            $data['description'] = $stockable->description;
        } elseif ($stockable instanceof CustomizationOption) {
            $data['item_type'] = 'customization_option';
            $data['name'] = $stockable->name;
            $data['customization_id'] = $stockable->customization_id;
            $data['extra_price'] = $stockable->extra_price;
        }

        return $data;
    }

    /**
     * Procesa los datos antes de guardar para actualizar tanto el inventario como el elemento relacionado
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();
        $stockable = $record->stockable;
        $itemType = $data['item_type'];

        if ($stockable && $itemType) {
            if ($itemType === 'ingredient' && $stockable instanceof Ingredient) {
                // Actualizar el ingrediente
                $stockable->update([
                    'name' => $data['name'],
                    'unit' => $data['unit'],
                    'category' => $data['category'] ?? null,
                    'description' => $data['description'] ?? null,
                ]);
            } elseif ($itemType === 'customization_option' && $stockable instanceof CustomizationOption) {
                // Actualizar la opción de personalización
                $stockable->update([
                    'name' => $data['name'],
                    'customization_id' => $data['customization_id'],
                    'extra_price' => $data['extra_price'] ?? 0,
                ]);
            }
        }

        // Devolver solo los datos que pertenecen al modelo Inventory
        return [
            'stock' => $data['stock'],
            'min_stock' => $data['min_stock'],
            'max_stock' => $data['max_stock'],
        ];
    }

    /**
     * Hook llamado después de llenar el formulario
     */
    protected function afterFill(): void
    {
        // Asegurar que los campos condicionales se muestren correctamente
        $this->form->fill($this->mutateFormDataBeforeFill($this->getRecord()->toArray()));
    }
}