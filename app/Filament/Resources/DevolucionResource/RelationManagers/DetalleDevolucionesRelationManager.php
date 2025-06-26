<?php

namespace App\Filament\Resources\DevolucionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleDevolucionesRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleDevoluciones';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->relationship('libro', 'titulo')
                    ->preload()
                    ->searchable()

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('libro.titulo')
            ->columns([
                Tables\Columns\TextColumn::make('libro.titulo'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
