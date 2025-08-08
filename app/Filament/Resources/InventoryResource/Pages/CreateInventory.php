<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Ingredient;
use App\Models\CustomizationOption;
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
        $itemType = $data['item_type'];

        // Crear el elemento según el tipo
        if ($itemType === 'ingredient') {
            // Verificar si ya existe un ingrediente con este nombre
            $existingIngredient = Ingredient::where('name', $data['name'])->first();

            if ($existingIngredient) {
                // Si ya existe, verificar si ya tiene inventario
                if ($existingIngredient->inventory) {
                    \Filament\Notifications\Notification::make()
                        ->danger()
                        ->title(__('inventory.notifications.already_exists'))
                        ->body(__('inventory.messages.ingredient_with_inventory_exists'))
                        ->send();

                    $this->halt();
                }

                $createdItem = $existingIngredient;
            } else {
                // Crear nuevo ingrediente
                $createdItem = Ingredient::create([
                    'name' => $data['name'],
                    'unit' => $data['unit'],
                    'category' => $data['category'] ?? null,
                    'description' => $data['description'] ?? null,
                    'is_active' => true,
                ]);
            }

            $stockableType = Ingredient::class;
        } elseif ($itemType === 'customization_option') {
            // Verificar si ya existe esta opción de personalización
            $existingOption = CustomizationOption::where('customization_id', $data['customization_id'])
                ->where('name', $data['name'])
                ->first();

            if ($existingOption) {
                // Si ya existe, verificar si ya tiene inventario
                if ($existingOption->inventory) {
                    \Filament\Notifications\Notification::make()
                        ->danger()
                        ->title(__('inventory.notifications.already_exists'))
                        ->body(__('inventory.messages.customization_with_inventory_exists'))
                        ->send();

                    $this->halt();
                }

                $createdItem = $existingOption;
            } else {
                // Crear nueva opción de personalización
                $createdItem = CustomizationOption::create([
                    'customization_id' => $data['customization_id'],
                    'name' => $data['name'],
                    'extra_price' => $data['extra_price'] ?? 0,
                ]);
            }

            $stockableType = CustomizationOption::class;
        } else {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title('Error')
                ->body(__('inventory.messages.invalid_item_type'))
                ->send();

            $this->halt();
        }

        // Preparar datos para crear el inventario
        return [
            'stockable_type' => $stockableType,
            'stockable_id' => $createdItem->id,
            'stock' => $data['stock'],
            'min_stock' => $data['min_stock'],
            'max_stock' => $data['max_stock'],
        ];
    }
}