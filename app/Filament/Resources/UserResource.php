<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Empleados';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Usuario')
                    ->description('Datos básicos para acceso al sistema')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre Completo')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ejemplo: Juan Pérez García'),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('usuario@restaurant.com'),
                            ]),

                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->placeholder('Mínimo 8 caracteres')
                            ->helperText('Deja vacío para mantener la contraseña actual'),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verificado')
                            ->placeholder('No verificado')
                            ->helperText('Marca cuándo se verificó el email del usuario'),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Roles y Permisos del Panel')
                    ->description('Determina qué puede hacer el usuario en el panel administrativo')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->label('Roles del Panel')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable()
                            ->placeholder('Selecciona los roles...')
                            ->helperText('Estos roles controlan el acceso al panel administrativo')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre del Rol')
                                    ->required()
                                    ->unique('roles', 'name'),
                                Forms\Components\TextInput::make('guard_name')
                                    ->label('Guard')
                                    ->default('web')
                                    ->required(),
                            ]),

                        Forms\Components\Placeholder::make('permissions_info')
                            ->label('Información de Permisos')
                            ->content('Los permisos específicos se asignan a través de los roles. Usa el Resource "Roles" para gestionar permisos detallados.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Empleado Asociado')
                    ->description('Vinculación con datos de empleado del restaurante')
                    ->schema([
                        Forms\Components\Placeholder::make('employee_status')
                            ->label('Estado del Empleado')
                            ->content(function (?User $record): string {
                                if (!$record || !$record->employee) {
                                    return '❌ Sin empleado asociado';
                                }
                                $employee = $record->employee;
                                return "✅ Empleado: {$employee->name} {$employee->last_name} ({$employee->role->name})";
                            }),

                        Forms\Components\Select::make('employee_id')
                            ->label('Empleado')
                            ->options(function (?User $record) {
                                return Employee::query()
                                    ->when($record, function ($query) use ($record) {
                                        $query->where(function ($q) use ($record) {
                                            $q->whereNull('user_id')
                                                ->orWhere('user_id', $record->id);
                                        });
                                    }, function ($query) {
                                        $query->whereNull('user_id');
                                    })
                                    ->get()
                                    ->mapWithKeys(function ($employee) {
                                        return [$employee->id => "{$employee->name} {$employee->last_name} ({$employee->role->name})"];
                                    });
                            })
                            ->searchable()
                            ->placeholder('Selecciona un empleado (opcional)')
                            ->helperText('Vincula este usuario con un empleado del restaurante')
                            ->afterStateUpdated(function ($state, $operation, ?User $record) {
                                if ($operation === 'edit' && $record) {
                                    if ($record->employee && $record->employee->id !== $state) {
                                        $record->employee->update(['user_id' => null]);
                                    }
                                    if ($state) {
                                        Employee::find($state)?->update(['user_id' => $record->id]);
                                    }
                                }
                            }),
                    ])
                    ->visible(fn(?User $record) => $record !== null) // Solo en edición
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->limit(25) // Limitar caracteres para evitar overflow
                    ->tooltip(function (User $record): ?string {
                        return strlen($record->name) > 25 ? $record->name : null;
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('📧 Copiado')
                    ->limit(30)
                    ->tooltip(function (User $record): ?string {
                        return strlen($record->email) > 30 ? $record->email : null;
                    }),

                // Tables\Columns\ViewColumn::make('employee_status')
                //     ->label('Empleado')
                //     ->view('filament.tables.columns.employee-status')
                //     ->width('80px'),

                // Alternativa:
                Tables\Columns\IconColumn::make('employee_status')
                    ->label('Puesto')
                    ->getStateUsing(fn (User $record): bool => (bool) $record->employee)                    
                    ->view('filament.tables.columns.employee-status')                    
                    ->width('150px')
                    ->alignment('left'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->default('Ninguno')                    
                    ->badge()
                    ->color('info')                    
                    ->separator(', ')
                    ->limitList(1) // Solo mostrar 1 rol, resto en expandible
                    ->expandableLimitedList()
                    ->tooltip('Roles del panel administrativo')
                    ->width('120px'),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('✓')
                    ->boolean()
                    ->trueIcon('heroicon-s-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(function (User $record): string {
                        return $record->email_verified_at
                            ? "✅ Verificado: {$record->email_verified_at->format('d/m/Y')}"
                            : '❌ Email no verificado';
                    })
                    ->width('50px')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registro')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable()
                    ->tooltip(fn(User $record) => $record->created_at->format('d/m/Y H:i:s'))
                    ->width('100px'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('has_employee')
                    ->label('Estado de Empleado')
                    ->placeholder('Todos los usuarios')
                    ->trueLabel('Con empleado asociado')
                    ->falseLabel('Usuario independiente')
                    ->queries(
                        true: fn(Builder $query) => $query->whereHas('employee'),
                        false: fn(Builder $query) => $query->whereDoesntHave('employee'),
                    ),

                Tables\Filters\SelectFilter::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verificado')
                    ->placeholder('Todos')
                    ->trueLabel('Verificados')
                    ->falseLabel('Sin verificar')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn(Builder $query) => $query->whereNull('email_verified_at'),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->tooltip('Editar usuario')
                    ->size('sm'),

                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->tooltip('Ver detalles')
                    ->size('sm'),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('linkEmployee')
                        ->label('Vincular Empleado')
                        ->icon('heroicon-o-link')
                        ->color('success')
                        ->visible(fn(User $record) => !$record->employee)
                        ->form([
                            Forms\Components\Select::make('employee_id')
                                ->label('Empleado')
                                ->options(
                                    Employee::whereNull('user_id')
                                        ->get()
                                        ->mapWithKeys(function ($employee) {
                                            return [$employee->id => "{$employee->name} {$employee->last_name} ({$employee->role->name})"];
                                        })
                                )
                                ->required()
                                ->searchable()
                                ->placeholder('Selecciona un empleado...'),
                        ])
                        ->action(function (User $record, array $data): void {
                            Employee::find($data['employee_id'])->update(['user_id' => $record->id]);

                            Notification::make()
                                ->title('Empleado vinculado')
                                ->body("Se vinculó el empleado exitosamente con {$record->email}")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('manageEmployee')
                        ->label('Gestionar Empleado')
                        ->icon('heroicon-o-briefcase')
                        ->color('warning')
                        ->visible(fn(User $record) => (bool) $record->employee)
                        ->url(fn(User $record) => \App\Filament\Resources\EmployeeResource::getUrl('edit', ['record' => $record->employee->id]))
                        ->openUrlInNewTab(),

                    Tables\Actions\Action::make('unlinkEmployee')
                        ->label('Desvincular Empleado')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->visible(fn(User $record) => (bool) $record->employee)
                        ->requiresConfirmation()
                        ->modalDescription('¿Estás seguro de que quieres desvincular este empleado del usuario?')
                        ->action(function (User $record): void {
                            $employeeName = $record->employee->name;
                            $record->employee->update(['user_id' => null]);

                            Notification::make()
                                ->title('Empleado desvinculado')
                                ->body("Se desvinculó {$employeeName} del usuario {$record->email}")
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->label('Eliminar Usuario')
                        ->requiresConfirmation()
                        ->modalDescription('¿Estás seguro? Esto eliminará el usuario permanentemente.')
                        ->before(function (User $record) {
                            if ($record->employee) {
                                $record->employee->update(['user_id' => null]);
                            }
                        }),
                ])
                    ->label('')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->tooltip('Más acciones'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verifyEmails')
                        ->label('Verificar Emails')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function (User $record) {
                                $record->update(['email_verified_at' => now()]);
                            });

                            Notification::make()
                                ->title('Emails verificados')
                                ->body('Se verificaron los emails seleccionados')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            $records->each(function (User $record) {
                                if ($record->employee) {
                                    $record->employee->update(['user_id' => null]);
                                }
                            });
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        return $count > 5 ? 'success' : 'warning';
    }
}