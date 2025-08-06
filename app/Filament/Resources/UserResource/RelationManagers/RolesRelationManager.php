<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $title = 'Roles del Panel';

    protected static ?string $modelLabel = 'Rol';

    protected static ?string $pluralModelLabel = 'Roles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Rol')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('Ejemplo: manager, operator'),

                Forms\Components\TextInput::make('guard_name')
                    ->label('Guard')
                    ->default('web')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del Rol')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Permisos')
                    ->getStateUsing(function ($record) {
                        return $record->permissions()->count();
                    })
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Asignar Rol')
                    ->color('success')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name'])
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        // Solo mostrar roles que el usuario no tiene
                        $userRoleIds = $this->getOwnerRecord()->roles->pluck('id');
                        return $query->whereNotIn('id', $userRoleIds);
                    }),

                Tables\Actions\CreateAction::make()
                    ->label('Crear Rol')
                    ->color('primary')
                    ->modalHeading('Crear Nuevo Rol')
                    ->modalDescription('Este rol se creará y se asignará automáticamente al usuario')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['guard_name'] = 'web';
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('viewPermissions')
                    ->label('Ver Permisos')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(function ($record) {
                        return route('filament.admin.resources.shield.roles.edit', $record);
                    })
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Rol'),

                Tables\Actions\DetachAction::make()
                    ->label('Quitar Rol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalDescription(function ($record) {
                        return "¿Estás seguro de que quieres quitar el rol '{$record->name}' de este usuario? Esto puede afectar sus permisos en el panel.";
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->label('Quitar Roles')
                        ->requiresConfirmation()
                        ->modalDescription('¿Estás seguro de que quieres quitar estos roles del usuario?'),
                ]),
            ])
            ->emptyStateHeading('Sin roles asignados')
            ->emptyStateDescription('Este usuario no tiene roles asignados. Asigna o crea un rol para otorgar permisos.')
            ->emptyStateIcon('heroicon-o-shield-exclamation');
    }
}