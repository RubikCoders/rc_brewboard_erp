<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    
    protected static ?string $navigationGroup = 'Empleados';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Empleados';
    protected static ?int $navigationSort = 1;

    
    protected static ?string $modelLabel = 'Empleado';
    protected static ?string $pluralModelLabel = 'Empleados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Section::make('Información Personal')
                    ->description('Datos básicos del empleado')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ejemplo: Juan'),

                                Forms\Components\TextInput::make('last_name')
                                    ->label('Apellidos')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ejemplo: Pérez García'),

                                Forms\Components\DatePicker::make('entry_date')
                                    ->label('Fecha de Ingreso')
                                    ->required()
                                    ->default(now())
                                    ->maxDate(now())
                                    ->displayFormat('d/m/Y')
                                    ->format('Y-m-d')
                                    ->helperText('Fecha en que el empleado ingresó a la empresa'),

                                Forms\Components\DatePicker::make('birthdate')
                                    ->label('Fecha de Nacimiento')
                                    ->required()
                                    ->maxDate(now()->subYears(16))
                                    ->displayFormat('d/m/Y')
                                    ->format('Y-m-d')
                                    ->helperText('Fecha de nacimiento del empleado'),
                            ]),
                    ])
                    ->collapsible(),

                
                Forms\Components\Section::make('Información de Contacto')
                    ->description('Datos de contacto y emergencia')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('Teléfono')
                                    ->tel()
                                    ->required()
                                    ->placeholder('Ejemplo: +52 33 1234 5678'),

                                Forms\Components\TextInput::make('emergency_contact')
                                    ->label('Contacto de Emergencia')
                                    ->required()
                                    ->placeholder('Nombre y teléfono'),
                            ]),

                        Forms\Components\Textarea::make('address')
                            ->label('Dirección')
                            ->required()
                            ->rows(3)
                            ->placeholder('Dirección completa del empleado'),
                    ])
                    ->collapsible(),

                
                Forms\Components\Section::make('Información Laboral')
                    ->description('Datos relacionados con el trabajo')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('role_id')
                                    ->label('Puesto de Trabajo')
                                    ->relationship('role', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombre del Puesto')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Descripción')
                                            ->rows(3),
                                    ]),

                                Forms\Components\TextInput::make('nss')
                                    ->label('Número de Seguro Social')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Ejemplo: 12345678901'),
                            ]),
                    ])
                    ->collapsible(),

                
                Forms\Components\Section::make('Acceso al Sistema')
                    ->description('Información de usuario para acceso al panel')
                    ->schema([
                        Forms\Components\Placeholder::make('user_status')
                            ->label('Estado del Usuario')
                            ->content(function (?Employee $record): string {
                                if (!$record || !$record->user_id) {
                                    return '❌ Sin usuario asignado';
                                }
                                $user = $record->user;
                                return "✅ Usuario: {$user->email} (Creado: {$user->created_at->format('d/m/Y')})";
                            }),

                        Forms\Components\Select::make('user_id')
                            ->label('Usuario Asignado')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->placeholder('Selecciona un usuario existente (opcional)')
                            ->helperText('Deja vacío si crearás un nuevo usuario después'),
                    ])
                    ->visible(fn(?Employee $record) => $record !== null) 
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn(Builder $query) =>
                $query->with(['role', 'user'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nombre Completo')
                    ->width(200)
                    ->getStateUsing(fn(Employee $record): string => "{$record->name} {$record->last_name}")
                    ->searchable(['name', 'last_name'])
                    ->sortable(['name', 'last_name'])
                    ->limit(30)
                    ->tooltip(function (Employee $record): ?string {
                        $fullName = "{$record->name} {$record->last_name}";
                        return strlen($fullName) > 30 ? $fullName : null;
                    })
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('role.name')
                    ->label('Puesto')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable()
                    ->limit(15)
                    ->tooltip(fn(Employee $record) => $record->role->description ?? $record->role->name)
                    ->width('120px'),

                Tables\Columns\ViewColumn::make('user_status')
                    ->label('Usuario')
                    ->view('filament.tables.columns.user-status')
                    ->width('90px'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->icon('heroicon-m-phone')
                    ->copyable()
                    ->copyMessage('📞 Copiado')
                    ->toggleable()
                    ->limit(12)
                    ->width('120px'),

                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Trabaja desde')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable()
                    ->tooltip(function (Employee $record): ?string {
                        if ($record->entry_date) {
                            return "Ingresó: {$record->entry_date->format('d/m/Y')}";
                        }
                        return 'Sin fecha';
                    })
                    ->width('100px'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(function (Employee $record): ?string {
                        if ($record->created_at) {
                            return "Registrado: {$record->created_at->format('d/m/Y H:i:s')}";
                        }
                        return null;
                    })
                    ->width('100px'),

                Tables\Columns\TextColumn::make('age')
                    ->label('Edad')
                    ->getStateUsing(function (Employee $record): ?string {
                        if ($record->birthdate) {
                            return $record->birthdate->age . ' años';
                        }
                        return 'N/A';
                    })
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(function (Employee $record): ?string {
                        if ($record->birthdate) {
                            return "Nacimiento: {$record->birthdate->format('d/m/Y')}";
                        }
                        return 'Fecha de nacimiento no registrada';
                    })
                    ->width('80px'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_id')
                    ->label('Puesto')
                    ->relationship('role', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('user_id')
                    ->label('Estado de Usuario')
                    ->placeholder('Todos los empleados')
                    ->trueLabel('Con usuario asignado')
                    ->falseLabel('Sin usuario asignado')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('user_id'),
                        false: fn(Builder $query) => $query->whereNull('user_id'),
                    ),

                Tables\Filters\Filter::make('entry_date')
                    ->form([
                        Forms\Components\DatePicker::make('entry_from')
                            ->label('Ingreso desde'),
                        Forms\Components\DatePicker::make('entry_until')
                            ->label('Ingreso hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['entry_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('entry_date', '>=', $date),
                            )
                            ->when(
                                $data['entry_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('entry_date', '<=', $date),
                            );
                    }),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->tooltip('Editar empleado')
                    ->size('sm'),

                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->tooltip('Ver detalles')
                    ->size('sm'),

                Tables\Actions\ActionGroup::make([
                    // Action para crear usuario (mejorado)
                    Tables\Actions\Action::make('createUser')
                        ->label('Crear Usuario')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->visible(fn(Employee $record) => !$record->user_id)
                        ->form([
                            Forms\Components\Section::make('Datos del Usuario')
                                ->schema([
                                    Forms\Components\TextInput::make('email')
                                        ->label('Email')
                                        ->email()
                                        ->required()
                                        ->unique('users', 'email')
                                        ->placeholder('usuario@restaurant.com')
                                        ->helperText('Email único para acceder al sistema'),

                                    Forms\Components\TextInput::make('password')
                                        ->label('Contraseña')
                                        ->password()
                                        ->required()
                                        ->minLength(8)
                                        ->placeholder('Mínimo 8 caracteres'),
                                ]),

                            Forms\Components\Section::make('Roles y Permisos')
                                ->description('Opcional: Define permisos de acceso al panel')
                                ->schema([
                                    Forms\Components\Select::make('roles')
                                        ->label('Roles del Panel')
                                        ->multiple()
                                        ->options(function () {
                                            return \Spatie\Permission\Models\Role::all()->pluck('name', 'name');
                                        })
                                        ->searchable()
                                        ->placeholder('Selecciona roles (opcional)...')
                                        ->helperText('Deja vacío para permisos básicos'),

                                    Forms\Components\Toggle::make('email_verified')
                                        ->label('Marcar email como verificado')
                                        ->default(true)
                                        ->helperText('Recomendado para evitar problemas de acceso'),
                                ])
                                ->collapsible(),
                        ])
                        ->action(function (Employee $record, array $data): void {
                            try {
                                // Crear usuario
                                $user = User::create([
                                    'name' => "{$record->name} {$record->last_name}",
                                    'email' => $data['email'],
                                    'password' => Hash::make($data['password']),
                                    'email_verified_at' => ($data['email_verified'] ?? true) ? now() : null,
                                ]);

                                // Asignar roles si se seleccionaron
                                if (!empty($data['roles'])) {
                                    $user->assignRole($data['roles']);
                                }

                                // Vincular empleado con usuario
                                $record->update(['user_id' => $user->id]);

                                Notification::make()
                                    ->title('¡Usuario creado exitosamente!')
                                    ->body("Usuario {$data['email']} creado para {$record->name}")
                                    ->success()
                                    ->duration(5000)
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Error al crear usuario')
                                    ->body('Hubo un problema. Inténtalo de nuevo.')
                                    ->danger()
                                    ->send();
                            }
                        }),

                    // Action para gestionar usuario existente
                    Tables\Actions\Action::make('manageUser')
                        ->label('Gestionar Usuario')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->color('warning')
                        ->visible(fn(Employee $record) => (bool) $record->user_id)
                        ->url(fn(Employee $record) => \App\Filament\Resources\UserResource::getUrl('edit', ['record' => $record->user_id]))
                        ->openUrlInNewTab(),

                    // Action para desvincular usuario
                    Tables\Actions\Action::make('unlinkUser')
                        ->label('Desvincular Usuario')
                        ->icon('heroicon-o-user-minus')
                        ->color('danger')
                        ->visible(fn(Employee $record) => (bool) $record->user_id)
                        ->requiresConfirmation()
                        ->modalDescription('¿Estás seguro de que quieres desvincular el usuario de este empleado?')
                        ->action(function (Employee $record): void {
                            $userEmail = $record->user->email;
                            $record->update(['user_id' => null]);

                            Notification::make()
                                ->title('Usuario desvinculado')
                                ->body("Se desvinculó {$userEmail} de {$record->name}")
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->label('Eliminar Empleado')
                        ->requiresConfirmation()
                        ->modalDescription('¿Estás seguro? Se desvinculará el usuario si existe.')
                        ->before(function (Employee $record) {
                            // Desvincular usuario antes de eliminar empleado
                            if ($record->user_id) {
                                $record->update(['user_id' => null]);
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
                    Tables\Actions\BulkAction::make('createUsers')
                        ->label('Crear Usuarios')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalDescription('¿Crear usuarios automáticamente para los empleados seleccionados que no tengan usuario?')
                        ->action(function ($records) {
                            $created = 0;
                            $skipped = 0;

                            foreach ($records as $employee) {
                                if (!$employee->user_id) {
                                    try {
                                        $user = User::create([
                                            'name' => "{$employee->name} {$employee->last_name}",
                                            'email' => strtolower(str_replace(' ', '.', $employee->name)) . '@restaurant.com',
                                            'password' => Hash::make('password123'),
                                            'email_verified_at' => now(),
                                        ]);

                                        $employee->update(['user_id' => $user->id]);
                                        $created++;
                                    } catch (\Exception $e) {
                                        $skipped++;
                                    }
                                } else {
                                    $skipped++;
                                }
                            }

                            Notification::make()
                                ->title('Usuarios creados')
                                ->body("Se crearon {$created} usuarios. {$skipped} empleados se omitieron.")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Desvincular usuarios antes de eliminar empleados
                            foreach ($records as $employee) {
                                if ($employee->user_id) {
                                    $employee->update(['user_id' => null]);
                                }
                            }
                        }),

                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->persistSortInSession()
            ->persistSearchInSession()
            ->deferLoading();
    }

    public static function getRelations(): array
    {
        return [
            // EmployeeResource\RelationManagers\OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        return $count > 10 ? 'success' : 'warning';
    }
}