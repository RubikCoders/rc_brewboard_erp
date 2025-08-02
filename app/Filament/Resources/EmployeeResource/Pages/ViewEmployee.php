<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información Personal')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nombre'),
                                Infolists\Components\TextEntry::make('last_name')
                                    ->label('Apellidos'),
                                Infolists\Components\TextEntry::make('birthdate')
                                    ->label('Fecha de Nacimiento')
                                    ->date('d/m/Y'),
                                Infolists\Components\TextEntry::make('entry_date')
                                    ->label('Fecha de Ingreso')
                                    ->date('d/m/Y'),
                            ]),
                        Infolists\Components\TextEntry::make('address')
                            ->label('Dirección'),
                    ]),

                Infolists\Components\Section::make('Información de Contacto')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Teléfono')
                                    ->icon('heroicon-m-phone'),
                                Infolists\Components\TextEntry::make('emergency_contact')
                                    ->label('Contacto de Emergencia')
                                    ->icon('heroicon-m-exclamation-triangle'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Información Laboral')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('role.name')
                                    ->label('Puesto')
                                    ->badge()
                                    ->color('info'),
                                Infolists\Components\TextEntry::make('nss')
                                    ->label('NSS'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Acceso al Sistema')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email de Usuario')
                            ->placeholder('Sin usuario asignado')
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('user.created_at')
                            ->label('Usuario creado')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('N/A'),
                    ])
                    ->visible(fn($record) => $record->user_id),
            ]);
    }

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return "{$record->name} {$record->last_name}";
    }
}