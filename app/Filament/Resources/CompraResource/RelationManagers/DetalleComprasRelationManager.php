<?php

namespace App\Filament\Resources\CompraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleComprasRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleCompras';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->relationship('libro', 'titulo')
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('cantidad')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('precio_unidad')
                    ->minValue(0)
                    ->numeric()
                    ->required(),
                TextInput::make('sub_total')
                    ->numeric()
                    ->disabled()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('libro.titulo')
            ->columns([
                Tables\Columns\TextColumn::make('libro.titulo'),
                Tables\Columns\TextColumn::make('cantidad'),
                Tables\Columns\TextColumn::make('precio_unidad')
                    ->money('HNL'),
                Tables\Columns\TextColumn::make('sub_total')
                    ->money('HNL'),
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
