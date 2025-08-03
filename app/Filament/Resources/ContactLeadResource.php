<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactLeadResource\Pages;
use App\Models\ContactLead;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactLeadResource extends Resource
{
    protected static ?string $model = ContactLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Leads de Contacto';

    protected static ?string $modelLabel = 'Lead de Contacto';

    protected static ?string $pluralModelLabel = 'Leads de Contacto';

    protected static ?string $navigationGroup = 'Ventas y Marketing';

    protected static ?int $navigationSort = 1;

    /**
     * Get the navigation badge (count of new leads)
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::new()->count();
    }

    /**
     * Navigation badge color
     */
    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::new()->count();
        return $count > 5 ? 'danger' : ($count > 0 ? 'warning' : null);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de Contacto')
                    ->description('Datos básicos del lead')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Teléfono')
                                    ->tel()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('business_name')
                                    ->label('Nombre del Negocio')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Textarea::make('message')
                            ->label('Mensaje')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('preferred_contact')
                                    ->label('Contacto Preferido')
                                    ->options(ContactLead::getPreferredContactOptions())
                                    ->required(),

                                Forms\Components\Select::make('source')
                                    ->label('Fuente')
                                    ->options(ContactLead::getSourceOptions())
                                    ->required(),

                                Forms\Components\Select::make('status')
                                    ->label('Estado')
                                    ->options(ContactLead::getStatusOptions())
                                    ->required()
                                    ->default(ContactLead::STATUS_NEW),
                            ]),
                    ]),

                Forms\Components\Section::make('Gestión Interna')
                    ->description('Seguimiento y asignación')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('assigned_to')
                                    ->label('Asignado a')
                                    ->options(User::pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable(),

                                Forms\Components\DateTimePicker::make('contacted_at')
                                    ->label('Contactado el')
                                    ->nullable(),
                            ]),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas Internas')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Notas sobre el seguimiento del lead...'),
                    ])
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
                    ->sortable(),

                Tables\Columns\TextColumn::make('business_name')
                    ->label('Negocio')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Teléfono copiado')
                    ->icon('heroicon-m-phone')
                    ->toggleable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Estado')
                    ->options(ContactLead::getStatusOptions())
                    ->rules(['required'])
                    ->selectablePlaceholder(false),

                Tables\Columns\TextColumn::make('preferred_contact')
                    ->label('Contacto Pref.')
                    ->formatStateUsing(fn(string $state): string => ContactLead::getPreferredContactOptions()[$state] ?? $state)
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'email' => 'info',
                        'phone' => 'warning',
                        'whatsapp' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Asignado a')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn(ContactLead $record): string => $record->created_at->format('d/m/Y H:i:s')),

                Tables\Columns\TextColumn::make('contacted_at')
                    ->label('Contactado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->placeholder('No contactado')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(ContactLead::getStatusOptions())
                    ->multiple(),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label('Asignado a')
                    ->options(User::pluck('name', 'id'))
                    ->multiple(),

                Tables\Filters\SelectFilter::make('preferred_contact')
                    ->label('Método de Contacto')
                    ->options(ContactLead::getPreferredContactOptions())
                    ->multiple(),

                Tables\Filters\Filter::make('needs_follow_up')
                    ->label('Necesita Seguimiento')
                    ->query(fn(Builder $query): Builder => $query->needsFollowUp()),

                Tables\Filters\Filter::make('new_leads')
                    ->label('Nuevos Leads')
                    ->query(fn(Builder $query): Builder => $query->new()),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Quick contact actions in the table row
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('whatsapp')
                        ->label('WhatsApp')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(fn(ContactLead $record): string => $record->getWhatsAppLink())
                        ->openUrlInNewTab()
                        ->visible(fn(ContactLead $record): bool => !empty($record->phone)),

                    Tables\Actions\Action::make('email')
                        ->label('Email')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->url(fn(ContactLead $record): string => $record->getEmailLink())
                        ->openUrlInNewTab(),

                    Tables\Actions\Action::make('mark_contacted')
                        ->label('Marcar Contactado')
                        ->icon('heroicon-o-check-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (ContactLead $record) {
                            $record->markAsContacted();

                            Notification::make()
                                ->title('Lead marcado como contactado')
                                ->success()
                                ->send();
                        })
                        ->visible(fn(ContactLead $record): bool => $record->status === ContactLead::STATUS_NEW),
                ])
                    ->label('Acciones')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->button(),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('assign_to_me')
                        ->label('Asignarme')
                        ->icon('heroicon-o-user-plus')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = $records->count();

                            foreach ($records as $record) {
                                $record->update(['assigned_to' => auth()->id()]);
                            }

                            Notification::make()
                                ->title("{$count} lead(s) asignados a ti")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('mark_as_contacted')
                        ->label('Marcar como Contactados')
                        ->icon('heroicon-o-check-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;

                            foreach ($records as $record) {
                                if ($record->status === ContactLead::STATUS_NEW) {
                                    $record->markAsContacted();
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("{$count} lead(s) marcados como contactados")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds for new leads
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información del Lead')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nombre')
                                    ->size('lg')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('business_name')
                                    ->label('Negocio')
                                    ->size('lg')
                                    ->color('primary'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable()
                                    ->url(fn(ContactLead $record): string => $record->getEmailLink())
                                    ->openUrlInNewTab(),

                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Teléfono')
                                    ->icon('heroicon-m-phone')
                                    ->copyable()
                                    ->url(fn(ContactLead $record): string => $record->getWhatsAppLink())
                                    ->openUrlInNewTab()
                                    ->placeholder('No proporcionado'),
                            ]),

                        Infolists\Components\TextEntry::make('message')
                            ->label('Mensaje')
                            ->columnSpanFull()
                            ->prose(),
                    ]),

                Infolists\Components\Section::make('Estado y Seguimiento')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Estado')
                                    ->formatStateUsing(fn(string $state): string => ContactLead::getStatusOptions()[$state] ?? $state)
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        ContactLead::STATUS_NEW => 'warning',
                                        ContactLead::STATUS_CONTACTED => 'info',
                                        ContactLead::STATUS_INTERESTED => 'primary',
                                        ContactLead::STATUS_DEMO_SCHEDULED => 'purple',
                                        ContactLead::STATUS_DEMO_COMPLETED => 'indigo',
                                        ContactLead::STATUS_PROPOSAL_SENT => 'orange',
                                        ContactLead::STATUS_CLOSED_WON => 'success',
                                        ContactLead::STATUS_CLOSED_LOST => 'danger',
                                        default => 'gray',
                                    }),

                                Infolists\Components\TextEntry::make('preferred_contact')
                                    ->label('Contacto Preferido')
                                    ->formatStateUsing(fn(string $state): string => ContactLead::getPreferredContactOptions()[$state] ?? $state)
                                    ->badge(),

                                Infolists\Components\TextEntry::make('source')
                                    ->label('Fuente')
                                    ->formatStateUsing(fn(string $state): string => ContactLead::getSourceOptions()[$state] ?? $state)
                                    ->badge(),
                            ]),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('assignedUser.name')
                                    ->label('Asignado a')
                                    ->placeholder('Sin asignar'),

                                Infolists\Components\TextEntry::make('contacted_at')
                                    ->label('Contactado el')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('No contactado'),
                            ]),

                        Infolists\Components\TextEntry::make('notes')
                            ->label('Notas Internas')
                            ->columnSpanFull()
                            ->prose()
                            ->placeholder('Sin notas'),
                    ]),

                Infolists\Components\Section::make('Información Técnica')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Recibido')
                                    ->dateTime('d/m/Y H:i:s'),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Última Actualización')
                                    ->dateTime('d/m/Y H:i:s'),

                                Infolists\Components\TextEntry::make('ip_address')
                                    ->label('IP')
                                    ->placeholder('No registrada'),

                                Infolists\Components\TextEntry::make('referer')
                                    ->label('Referencia')
                                    ->placeholder('Acceso directo')
                                    ->url(fn(?string $state): ?string => $state)
                                    ->openUrlInNewTab(),
                            ]),

                        Infolists\Components\TextEntry::make('user_agent')
                            ->label('Navegador')
                            ->columnSpanFull()
                            ->placeholder('No registrado'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactLeads::route('/'),
            'create' => Pages\CreateContactLead::route('/create'),
            // 'view' => Pages\ViewContactLead::route('/{record}'),
            'edit' => Pages\EditContactLead::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}