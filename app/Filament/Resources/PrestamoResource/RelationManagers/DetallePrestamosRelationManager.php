<?php

namespace App\Filament\Resources\PrestamoResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DetallePrestamosRelationManager extends RelationManager
{
    protected static string $relationship = 'detallePrestamos';

    protected  function afterCreate():void {
        $detalle = $this->record;

        $libro = $detalle->libro;

        if ($libro && $libro->canitdad_disponible > 0) {
            $libro->canitdad_disponible -= 1;
            $libro->save();
        }
    }

    protected function afterEdit(): void
    {
        $original = $this->record->getOriginal();
        $nuevoLibro = $this->record->libro;

        if ($original['libro_id'] !== $this->record->libro_id) {
            $libroAnterior = \App\Models\Libro::find($original['libro_id']);

            if ($libroAnterior) {
                $libroAnterior->cantidad_disponible += 1;
                $libroAnterior->save();
            }

            if ($nuevoLibro) {
                $nuevoLibro->cantidad_disponible -= 1;
                $nuevoLibro->save();
            }

        }

    }

    protected function beforeDelete(): void
    {
        $libro = $this->record->libro;

        if ($libro) {
            $libro->cantidad_disponible += 1;
            $libro->save();
        }

    }



    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('detallePrestamo');
    }

    public static function getPluralModelLabel(): string {
        return __('detallePrestamos');
    }

    public static function getModelLabel(): string {
        return __('detallePrestamo');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->label(__('Libro'))
                    ->relationship('libro','titulo')
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('libro.titulo')
            ->columns([
                TextColumn::make('libro.titulo')
                    ->label(__('Libro'))
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
