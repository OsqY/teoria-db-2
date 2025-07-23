<?php

namespace App\Filament\Resources\DevolucionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleDevolucionesRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleDevoluciones';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('detalleDevolucion');
    }

    public static function getPluralModelLabel(): string
    {
        return __('detalleDevoluciones');
    }

    public static function getModelLabel(): string
    {
        return __('detalleDevolucion');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->label(__('libro'))
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
                Tables\Actions\CreateAction::make()
                    ->after(function () {
                        $this->ownerRecord->calcularTotales();
                        $this->dispatch('calcular-totales');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        $this->ownerRecord->calcularTotales();
                        $this->dispatch('calcular-totales');
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->ownerRecord->calcularTotales();
                        $this->dispatch('calcular-totales');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            $this->ownerRecord->calcularTotales();
                            $this->dispatch('calcular-totales');
                        }),
                ]),
            ]);
    }
}
