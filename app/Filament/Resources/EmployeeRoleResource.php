<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeRoleResource\Pages;
use App\Filament\Resources\EmployeeRoleResource\RelationManagers;
use App\Models\EmployeeRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeRoleResource extends Resource
{
    protected static ?string $model = EmployeeRole::class;
    protected static ?string $navigationGroup = 'Personal';
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    //region Label methods
    public static function getNavigationLabel(): string
    {
        return __("employeerole.model");
    }

    public static function getModelLabel(): string
    {
        return __("employeerole.role");
    }

    public static function getPluralModelLabel(): string
    {
        return __("employeerole.model");
    }

    //endregion

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::formInputs());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::tableColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListEmployeeRoles::route('/'),
//            'create' => Pages\CreateEmployeeRole::route('/create'),
//            'edit' => Pages\EditEmployeeRole::route('/{record}/edit'),
        ];
    }

    //region Table methods
    private static function tableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label(__("employeerole.fields.name"))
                ->searchable()
                ->badge()
                ->color('primary')
                ->description(fn(EmployeeRole $role) => $role->description),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('employeerole.fields.created_at'))
                ->searchable()
                ->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('employeerole.fields.updated_at'))
                ->searchable()
                ->dateTime(),
        ];
    }
    //endregion

    //region Form Methods

    public static function formInputs(): array {
        return [
            Forms\Components\TextInput::make('name')
                ->label(__("employeerole.fields.name"))
                ->columnSpanFull()
                ->required(),
            Forms\Components\Textarea::make("description")
                ->columnSpanFull()
                ->label(__('employeerole.fields.description'))
        ];
    }

    //endregion
}
