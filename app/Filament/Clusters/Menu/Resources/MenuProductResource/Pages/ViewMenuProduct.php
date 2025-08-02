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
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;
use Illuminate\Support\HtmlString;
use App\Helpers\Money;

class ViewMenuProduct extends ViewRecord
{
    protected static string $resource = MenuProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil-square')
                ->size('lg'),
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->size('lg'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'lg' => 3,
                        ])
                            ->schema([
                                // COLUMNA 1: Imagen del producto (más amplia)
                                Group::make([                                    
                                    ImageEntry::make('image_path')
                                        ->hiddenLabel()
                                        ->height(400)
                                        ->width('100%')
                                        ->extraAttributes([
                                            'class' => 'rounded-xl shadow-xl border-2 border-gray-100 dark:border-gray-700',
                                            'style' => 'object-fit: cover; aspect-ratio: 4/3;'
                                        ])
                                        ->getStateUsing(function ($record): ?string {
                                            // Si tenemos image_url válida del seeder
                                            if ($record->image_url && str_contains($record->image_url, '/storage/products/')) {
                                                $filename = basename($record->image_url);

                                                // Verificar si el archivo existe físicamente
                                                if (file_exists(storage_path('app/public/products/' . $filename))) {
                                                    return asset('storage/products/' . $filename);
                                                }
                                            }

                                            // Procesar image_path 
                                            if ($record->image_path) {
                                                // Si es ruta relativa (FileUpload nuevo)
                                                if (!str_starts_with($record->image_path, '/')) {
                                                    if (file_exists(storage_path('app/public/' . $record->image_path))) {
                                                        return asset('storage/' . $record->image_path);
                                                    }
                                                } else {
                                                    // Si es ruta absoluta (seeder), extraer filename
                                                    $filename = basename($record->image_path);

                                                    if (file_exists(storage_path('app/public/products/' . $filename))) {
                                                        return asset('storage/products/' . $filename);
                                                    }
                                                }
                                            }

                                            return null;
                                        })
                                        ->extraAttributes([
                                            'class' => 'rounded-lg shadow-lg border border-gray-200 dark:border-gray-600',
                                            'style' => 'object-fit: cover;'
                                        ])
                                        ->defaultImageUrl(asset('images/placeholder-product.jpg'))
                                        ->columnSpan([
                                            'default' => 1,
                                            'lg' => 1,
                                        ]),
                                ])
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 1,
                                ]),
                                
                                Group::make([                                
                                    Group::make([
                                        TextEntry::make('name')
                                            ->hiddenLabel()
                                            ->size(TextEntry\TextEntrySize::Large)
                                            ->weight(FontWeight::Bold)
                                            ->color('primary')
                                            ->extraAttributes([
                                                'class' => 'text-3xl font-bold text-gray-900 dark:text-white mb-4 leading-tight'
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('category.name')
                                                    ->label('Categoría')
                                                    ->badge()
                                                    ->color('info')
                                                    ->size('lg')
                                                    ->extraAttributes([
                                                        'class' => 'mb-6'
                                                    ]),

                                                IconEntry::make('is_available')
                                                    ->label('Estado')
                                                    ->boolean()
                                                    ->trueIcon('heroicon-o-check-circle')
                                                    ->falseIcon('heroicon-o-x-circle')
                                                    ->trueColor('success')
                                                    ->falseColor('danger')
                                                    ->size('lg')
                                                    ->extraAttributes([
                                                        'class' => 'mb-6'
                                                    ]),
                                            ]),

                                        TextEntry::make('description')
                                            ->label('Descripción')
                                            ->placeholder('Sin descripción disponible')
                                            ->prose()
                                            ->extraAttributes([
                                                'class' => 'text-lg leading-relaxed text-gray-700 dark:text-gray-300 mb-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600'
                                            ])
                                            ->columnSpanFull(),

                                    ])
                                        ->extraAttributes([
                                            'class' => 'space-y-6'
                                        ]),

                                    Grid::make(2)
                                        ->schema([
                                            TextEntry::make('base_price')
                                                ->label('Precio Base')
                                                ->money('MXN')
                                                ->size(TextEntry\TextEntrySize::Large)
                                                ->weight(FontWeight::Bold)
                                                ->color('success')
                                                ->icon('heroicon-o-currency-dollar')
                                                ->extraAttributes([
                                                    'class' => 'text-2xl font-bold bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-700'
                                                ]),

                                            TextEntry::make('estimated_time_min')
                                                ->label('Tiempo de Preparación')
                                                ->numeric(0)
                                                ->suffix(' minutos')
                                                ->icon('heroicon-o-clock')
                                                ->size(TextEntry\TextEntrySize::Large)
                                                ->weight(FontWeight::SemiBold)
                                                ->color('warning')
                                                ->extraAttributes([
                                                    'class' => 'text-xl font-semibold bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg border border-orange-200 dark:border-orange-700'
                                                ]),
                                        ])
                                        ->extraAttributes([
                                            'class' => 'mt-8 gap-6'
                                        ]),

                                ])
                                    ->columnSpan([
                                        'default' => 1,
                                        'lg' => 2,
                                    ]),
                            ])
                    ])
                    ->extraAttributes([
                        'class' => 'p-8 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg'
                    ])
                    ->columnSpanFull(),

                InfolistSection::make(function ($record): string {
                    $ingredientsCount = $record->ingredients ? count(array_filter(array_map('trim', explode(',', $record->ingredients)))) : 0;
                    return "Ingredientes y Detalles ({$ingredientsCount})";
                })
                    ->description('Todos los ingredientes que componen este delicioso producto')
                    ->schema([
                        TextEntry::make('ingredients')
                            ->hiddenLabel()
                            ->placeholder('No se han especificado ingredientes para este producto')
                            ->formatStateUsing(function (?string $state): HtmlString {
                                if (!$state) {
                                    return new HtmlString('
                                            <div class="flex items-center justify-center p-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                                                <div class="text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                    </svg>
                                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No se han especificado ingredientes para este producto</p>
                                                </div>
                                            </div>
                                        ');
                                }

                                $ingredients = array_filter(array_map('trim', explode(',', $state)));

                                $html = '
                                        <style>
                                            .ingredients-grid {
                                                display: grid;
                                                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                                                gap: 0.875rem;
                                            }
                                            
                                            .ingredient-tag {
                                                background: linear-gradient(135deg, #f8fafc 0%, #f8fafc 50%, #E4E6C3 100%);                                                
                                                border-radius: 8px;
                                                padding: 0.75rem 0.75rem 0.75rem 2rem;
                                                display: flex;
                                                align-items: center;
                                                gap: 0.5rem;
                                                transition: transform 0.2s ease, box-shadow 0.2s ease;
                                                word-break: break-word;
                                                min-height: 48px;
                                            }
                                            
                                            .ingredient-tag::before {
                                                content: "";
                                                position: absolute;
                                                top: 0;
                                                left: 0;
                                                right: 0;
                                                height: 2px;
                                                background: rgba(var(--primary-500), 1);
                                                border-radius: 8px 8px 0 0;
                                                position: relative;
                                                margin: -0.75rem -0.75rem 0 -0.75rem;
                                            }
                                            
                                            .ingredient-tag:hover {
                                                transform: translateY(-1px);
                                                box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
                                            }
                                            
                                            .ingredient-icon {
                                                width: 18px;
                                                height: 18px;
                                                color: rgba(var(--primary-600), 1);
                                                flex-shrink: 0;
                                            }
                                            
                                            .ingredient-text {
                                                font-weight: 500;
                                                color: #374151;
                                                font-size: 0.875rem;
                                                line-height: 1.4;
                                                text-transform: capitalize;
                                                flex: 1;
                                            }
                                            
                                            .dark .ingredient-tag {
                                                padding-left: 16px;
                                                background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
                                                border-color: #374151;
                                            }
                                            
                                            .dark .ingredient-text {
                                                color: #d1d5db;
                                            }
                                            
                                            .dark .ingredient-icon {
                                                color: rgba(var(--primary-400), 1);
                                            }
                                            
                                            .dark .ingredient-tag:hover {
                                                box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.3);
                                            }
                                        </style>
                                        
                                        <div class="ingredients-grid">
                                    ';

                                foreach ($ingredients as $ingredient) {
                                    if (!empty($ingredient)) {
                                        $html .= '
                                                <div class="ingredient-tag">
                                                    <svg class="ingredient-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                    </svg>
                                                    <span class="ingredient-text">' . htmlspecialchars($ingredient) . '</span>
                                                </div>
                                            ';
                                    }
                                }

                                $html .= '</div>';
                                return new HtmlString($html);
                            })
                            ->columnSpanFull(),
                    ])
                    ->extraAttributes([
                        'class' => 'p-6 bg-gradient-to-br from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm'
                    ])
                    ->columnSpanFull(),

                InfolistSection::make('Tipos de Personalización')
                    ->description('Opciones de personalización disponibles para este producto')
                    ->schema([
                        RepeatableEntry::make('customizations')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make([
                                    'default' => 1,
                                    'md' => 2,
                                    'lg' => 3,
                                ])
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Tipo de Personalización')
                                            ->weight(FontWeight::Bold)
                                            ->size('lg')
                                            ->icon('heroicon-o-cog-6-tooth')
                                            ->color('primary')
                                            ->extraAttributes([
                                                'class' => 'text-xl font-bold'
                                            ]),

                                        IconEntry::make('required')
                                            ->label('¿Es Requerido?')
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-x-circle')
                                            ->trueColor('success')
                                            ->falseColor('gray')
                                            ->size('lg'),

                                        TextEntry::make('options_count')
                                            ->label('Opciones Disponibles')
                                            ->badge()
                                            ->color('info')
                                            ->getStateUsing(fn($record) => $record->options->count() . ' opciones')
                                            ->icon('heroicon-o-list-bullet'),
                                    ])
                                    ->extraAttributes([
                                        'class' => 'p-6 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm'
                                    ]),

                                RepeatableEntry::make('options')
                                    ->label('Opciones Disponibles')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('name')
                                                    ->label('Opción')
                                                    ->icon('heroicon-o-check')
                                                    ->weight(FontWeight::Medium),

                                                TextEntry::make('extra_price')
                                                    ->label('Precio Adicional')
                                                    ->money('MXN')
                                                    ->color('success')
                                                    ->icon('heroicon-o-plus')
                                                    ->placeholder('$0.00'),
                                            ])
                                    ])
                                    ->extraAttributes([
                                        'class' => 'mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-600'
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->extraAttributes([
                                'class' => 'space-y-4'
                            ])
                            ->placeholder('No se han configurado tipos de personalización para este producto')
                            ->columnSpanFull(),
                    ])
                    ->extraAttributes([
                        'class' => 'bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700'
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),

                InfolistSection::make('Información del Sistema')
                    ->description('Datos técnicos y fechas de registro')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Fecha de Creación')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-o-calendar')
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label('Última Actualización')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-o-pencil')
                                    ->color('gray'),
                            ])
                    ])
                    ->extraAttributes([
                        'class' => 'bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600'
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}

// InfolistSection::make('Imagen del Producto')
//     ->schema([    
//     ]),