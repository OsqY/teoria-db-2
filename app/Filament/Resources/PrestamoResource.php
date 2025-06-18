<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestamoResource\Pages;
use App\Filament\Resources\PrestamoResource\RelationManagers;
use App\Filament\Resources\PrestamoResource\RelationManagers\DetallePrestamosRelationManager;
use App\Models\Prestamo;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestamoResource extends Resource
{
    protected static ?string $model = Prestamo::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user','name')
                ->searchable(),
                Forms\Components\DatePicker::make('fecha_prestamo')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_devolucion_esperada')
                    ->required(),
                Select::make('estado')
                    ->options([
                        'Prestado',
                        'Pendiente',
                        'Devuelto',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('fecha_devuelto'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('fecha_prestamo')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_devolucion_esperada')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_devuelto')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            DetallePrestamosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrestamos::route('/'),
            'create' => Pages\CreatePrestamo::route('/create'),
            'edit' => Pages\EditPrestamo::route('/{record}/edit'),
        ];
    }
}
