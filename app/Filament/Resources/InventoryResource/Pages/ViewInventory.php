<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Acción para ajuste rápido desde vista
            Actions\Action::make('quick_adjust')
                ->label(__('inventory.actions.quick_adjust'))
                ->icon('heroicon-o-plus-minus')
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
                                ->reactive()
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
                    $reason = $data['reason'] ?? null;

                    match ($data['action_type']) {
                        'add' => $record->add($quantity),
                        'remove' => $record->consume($quantity),
                        'set' => $record->adjustTo($quantity, $reason),
                    };

                    // Refrescar la vista
                    redirect($this->getResource()::getUrl('view', ['record' => $record]));
                })
                ->successNotification(
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('inventory.notifications.adjusted'))
                ),

            // Acción para ver historial (futura implementación)
            Actions\Action::make('view_history')
                ->label(__('inventory.actions.view_history'))
                ->icon('heroicon-o-clock')
                ->color('info')
                ->url(fn() => '#') // Placeholder para futura implementación
                ->disabled(true)
                ->tooltip(__('inventory.tooltips.coming_soon')),

            Actions\EditAction::make(),
        ];
    }
}