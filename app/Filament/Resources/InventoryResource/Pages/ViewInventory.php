<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Ingredient;
use App\Models\CustomizationOption;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            // Acción para ajuste rápido desde vista
            Actions\Action::make('quick_adjust')
                ->label(__('inventory.actions.quick_adjust'))
                ->icon('heroicon-o-arrows-right-left')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\Grid::make(2)
                        ->schema([
                            \Filament\Forms\Components\Select::make('action_type')
                                ->label(__('inventory.fields.action_type'))
                                ->options([
                                    'add' => __('inventory.actions.add_stock'),
                                    'remove' => __('inventory.actions.remove_stock'),
                                    'set' => __('inventory.actions.set_stock'),
                                ])
                                ->required()
                                ->live()
                                ->columnSpan(1),

                            \Filament\Forms\Components\TextInput::make('quantity')
                                ->label(__('inventory.fields.quantity'))
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->step(1)
                                ->columnSpan(1),
                        ]),

                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label(__('inventory.fields.reason'))
                        ->placeholder(__('inventory.placeholders.reason'))
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $record = $this->getRecord();
                    $quantity = (int) $data['quantity'];
                    $reason = $data['reason'] ?? 'Ajuste manual de stock';

                    match ($data['action_type']) {
                        'add' => $record->add($quantity),
                        'remove' => $record->consume($quantity),
                        'set' => $record->adjustTo($quantity, $reason),
                    };

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('inventory.notifications.adjusted'))
                        ->body("Stock actualizado correctamente")
                        ->send();

                    // Refrescar la página para mostrar los cambios
                    $this->redirect($this->getResource()::getUrl('view', ['record' => $record]));
                })
                ->requiresConfirmation()
                ->modalDescription('Esta acción modificará el nivel de stock actual del inventario.')
                ->modalSubmitActionLabel('Aplicar ajuste'),
        ];
    }
}