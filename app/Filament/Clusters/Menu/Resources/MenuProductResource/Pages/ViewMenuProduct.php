<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use App\Helpers\Money;

class ViewMenuProduct extends ViewRecord
{
    protected static string $resource = MenuProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Group::make([
                        InfolistSection::make(__('product.sections.basic_info.title'))
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('product.fields.name'))
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),

                                TextEntry::make('category.name')
                                    ->label(__('product.fields.category_id'))
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('base_price')
                                    ->label(__('product.fields.base_price'))
                                    ->money('MXN')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold')
                                    ->color('success'),

                                TextEntry::make('estimated_time_min')
                                    ->label(__('product.fields.estimated_time_min'))
                                    ->suffix(' minutos')
                                    ->icon('heroicon-o-clock'),

                                IconEntry::make('is_available')
                                    ->label(__('product.fields.is_available'))
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ])
                            ->columns(2),

                        InfolistSection::make(__('product.sections.details.title'))
                            ->schema([
                                TextEntry::make('description')
                                    ->label(__('product.fields.description'))
                                    ->placeholder('Sin descripción')
                                    ->prose(),

                                TextEntry::make('ingredients')
                                    ->label(__('product.fields.ingredients'))
                                    ->placeholder('Sin ingredientes especificados')
                                    ->badge()
                                    ->separator(',')
                                    ->color('gray'),
                            ]),
                    ])
                        ->grow(),

                    Group::make([
                        InfolistSection::make('Imagen del Producto')
                            ->schema([
                                ImageEntry::make('image_path')
                                    ->hiddenLabel()
                                    ->height(300)
                                    ->width(300)
                                    ->disk('public')
                                    ->getStateUsing(function ($record): ?string {
                                        if (!$record->image_path) {
                                            return null;
                                        }

                                        // Si la ruta ya es relativa (desde FileUpload)
                                        if (!str_starts_with($record->image_path, '/')) {
                                            return $record->image_path;
                                        }

                                        // Si es ruta absoluta (desde seeder), extraer solo el nombre del archivo
                                        $filename = basename($record->image_path);
                                        $relativePath = 'products/' . $filename;

                                        // Verificar si el archivo existe
                                        if (file_exists(storage_path('app/public/' . $relativePath))) {
                                            return $relativePath;
                                        }

                                        return null;
                                    })
                                    ->extraAttributes(['class' => 'rounded-lg'])
                                    ->defaultImageUrl(asset('images/placeholder-product.png')),
                            ]),

                        InfolistSection::make('Información del Sistema')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('product.fields.created_at'))
                                    ->dateTime()
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('updated_at')
                                    ->label(__('product.fields.updated_at'))
                                    ->dateTime()
                                    ->icon('heroicon-o-pencil'),
                            ]),
                    ])
                        ->grow(false),
                ]),

                // Section for customizations
                InfolistSection::make(__('product.sections.customizations.title'))
                    ->description(__('product.sections.customizations.description'))
                    ->schema([
                        RepeatableEntry::make('customizations')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('product.customizations.type_name'))
                                    ->weight('medium')
                                    ->icon('heroicon-o-cog-6-tooth'),

                                IconEntry::make('required')
                                    ->label(__('product.customizations.is_required'))
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('gray'),
                            ])
                            ->columns(2)
                            ->placeholder('No se han configurado tipos de personalización para este producto'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}