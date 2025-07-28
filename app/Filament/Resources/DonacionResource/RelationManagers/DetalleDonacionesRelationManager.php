<?php

namespace App\Filament\Resources\DonacionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleDonacionesRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleDonaciones';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('detalleDonacion');
    }

    public static function getPluralModelLabel(): string
    {
        return __('detalleDonaciones');
    }

    public static function getModelLabel(): string
    {
        return __('detalleDonacion');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('libro_id')
                    ->relationship('libro', 'titulo')
                    ->label(__('Libro'))
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('cantidad')
                    ->label(__('cantidad'))
                    ->numeric()
                    ->minValue(1)
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('libro.titulo')
            ->columns([
                Tables\Columns\TextColumn::make('libro.titulo')
                    ->label(__('libro')),
                Tables\Columns\TextColumn::make('cantidad')
                    ->label(__('cantidad'))
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
