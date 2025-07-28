<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestamoResource\Pages;
use App\Filament\Resources\PrestamoResource\RelationManagers\DetallePrestamosRelationManager;
use App\Models\Prestamo;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrestamoResource extends Resource
{
    protected static ?string $model = Prestamo::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getPluralModelLabel(): string
    {
        return __('Prestamos');
    }

    public static function getModelLabel(): string
    {
        return __('Prestamo');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Transacciones');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->preload()
                    ->required()
                    ->relationship('user', 'name')
                    ->searchable(),
                Forms\Components\DatePicker::make('fecha_prestamo')
                    ->label(__('fecha_prestamo'))
                    ->required(),
                Forms\Components\DatePicker::make('fecha_devolucion_esperada')
                    ->label(__('fecha_devolucion_esperada'))
                    ->required(),
                Select::make('estado')
                    ->options([
                        'prestado' => __('prestado'),
                        'pendiente' => __('pendiente'),
                        'devuelto' => __('devuelto'),
                    ])
                    ->label(__('estado'))

                    ->required()

                    ->native(false),

                Forms\Components\DatePicker::make('fecha_devuelto')
                    ->label(__('fecha_devuelto')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User')),
                Tables\Columns\TextColumn::make('fecha_prestamo')
                    ->label(__('fecha_prestamo'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_devolucion_esperada')
                    ->label(__('fecha_devolucion_esperada'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'prestado' => 'warning',
                        'pendiente' => 'danger',
                        'devuelto' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => __("$state"))
                    ->label(__('estado'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_devuelto')
                    ->label(__('fecha_devuelto'))
                    ->date()
                    ->sortable(),
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
