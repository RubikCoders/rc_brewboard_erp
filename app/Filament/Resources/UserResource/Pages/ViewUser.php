<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

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
                Infolists\Components\Section::make('Información del Usuario')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nombre Completo'),
                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('email_verified_at')
                                    ->label('Email Verificado')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('No verificado')
                                    ->color(fn($state) => $state ? 'success' : 'danger'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Usuario desde')
                                    ->dateTime('d/m/Y H:i'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Roles y Permisos')
                    ->schema([
                        Infolists\Components\TextEntry::make('roles.name')
                            ->label('Roles del Panel')
                            ->badge()
                            ->color('info')
                            ->separator(', ')
                            ->placeholder('Sin roles asignados'),
                    ]),

                Infolists\Components\Section::make('Empleado Asociado')
                    ->schema([
                        Infolists\Components\TextEntry::make('employee.name')
                            ->label('Nombre del Empleado')
                            ->getStateUsing(fn($record) => $record->employee ?
                                "{$record->employee->name} {$record->employee->last_name}" : null)
                            ->placeholder('Sin empleado asociado'),
                        Infolists\Components\TextEntry::make('employee.role.name')
                            ->label('Puesto')
                            ->badge()
                            ->color('warning')
                            ->placeholder('N/A'),
                        Infolists\Components\TextEntry::make('employee.phone')
                            ->label('Teléfono del Empleado')
                            ->icon('heroicon-m-phone')
                            ->placeholder('N/A'),
                    ])
                    ->visible(fn($record) => $record->employee),
            ]);
    }

    public function getTitle(): string
    {
        $record = $this->getRecord();
        return "Usuario: {$record->name}";
    }
}