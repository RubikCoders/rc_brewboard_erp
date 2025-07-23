<?php

namespace App\Filament\Clusters\Menu\Resources\MenuProductResource\Pages;

use App\Filament\Clusters\Menu\Resources\MenuProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Group;
use Illuminate\Support\HtmlString;
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
                                    ->size('lg')
                                    ->weight('bold'),

                                TextEntry::make('category.name')
                                    ->label(__('product.fields.category_id'))
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('base_price')
                                    ->label(__('product.fields.base_price'))
                                    ->money('MXN')
                                    ->size('lg')
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
                            ])->columns(2),

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
                    ])->grow(),

                    Group::make([
                        InfolistSection::make('Imagen del Producto')
                            ->schema([
                                ImageEntry::make('image_path')
                                    ->hiddenLabel()
                                    ->height(300)
                                    ->width(300)
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
                    ])->grow(false),
                ]),

                // Section for customizations (will be expanded later)
                InfolistSection::make(__('product.sections.customizations.title'))
                    ->description(__('product.sections.customizations.description'))
                    ->schema([
                        TextEntry::make('customizations_placeholder')
                            ->hiddenLabel()
                            ->default('Las personalizaciones del producto se mostrarán aquí una vez implementadas.')
                            ->color('gray')
                            ->icon('heroicon-o-cog-6-tooth'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}