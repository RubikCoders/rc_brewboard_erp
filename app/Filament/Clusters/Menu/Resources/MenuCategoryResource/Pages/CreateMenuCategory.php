<?php

namespace App\Filament\Clusters\Menu\Resources\MenuCategoryResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuCategory extends CreateRecord
{
    protected static string $resource = MenuCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
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