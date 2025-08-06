<?php

namespace App\Filament\Clusters\Menu\Resources\MenuCategoryResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuCategoryResource;
use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuCategory extends EditRecord
{
    protected static string $resource = MenuCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_products')
                ->label('Ver Productos')
                ->icon('heroicon-o-cube')
                ->color('info')
                ->url(
                    fn(): string =>
                    MenuProductResource::getUrl('index', [
                        'tableFilters' => ['category_id' => ['value' => $this->record->id]]
                    ])
                )
                ->visible(fn(): bool => $this->record->products_count > 0)
                ->openUrlInNewTab(),

            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Eliminar categoría')
                ->modalDescription(
                    fn(): string =>
                    $this->record->products_count > 0
                        ? "Esta categoría tiene {$this->record->products_count} producto(s). No se puede eliminar."
                        : "¿Estás seguro de que quieres eliminar '{$this->record->name}'?"
                )
                ->disabled(fn(): bool => $this->record->products_count > 0),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['name'])) {
            $data['name'] = ucwords(strtolower(trim($data['name'])));
        }

        if (isset($data['description']) && empty(trim($data['description']))) {
            $data['description'] = null;
        }

        return $data;
    }
}