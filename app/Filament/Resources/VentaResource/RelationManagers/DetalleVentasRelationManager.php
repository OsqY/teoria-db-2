<?php

namespace App\Filament\Resources\VentaResource\RelationManagers;

use App\Models\Libro;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class DetalleVentasRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleVentas';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('detalleVenta');
    }

    public static function getPluralModelLabel(): string
    {
        return __('detalleVentas');
    }

    public static function getModelLabel(): string
    {
        return __('detalleVenta');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->label(__('Libro'))
                    ->relationship('libro', 'titulo')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $libroId =  $get('libro_id');
                        if (!$libroId) {
                            return;
                        }
                        $libro = Libro::find($libroId);
                        $precioBase = $libro->precio_base ?? 0;
                        if ($precioBase > 0) {
                            $set('valor_venta', $precioBase);
                        }
                    }),
                Forms\Components\TextInput::make('cantidad')
                    ->required()
                    ->live()
                    ->numeric()
                    ->minValue(1)->maxValue(function (Get $get) {
                        $libroId = $get('libro_id');
                        if (!$libroId) {
                            return 1;
                        }
                        return Libro::find($libroId)->cantidad_disponible ?? 1;
                    })
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $libroId = $get('libro_id');
                        if (!$libroId) {
                            return;
                        }

                        $maximo = Libro::find($libroId)->cantidad_disponible ?? 1;

                        if ($state > $maximo) {
                            $set('cantidad', $maximo);
                        }
                    }),
                Forms\Components\TextInput::make('valor_venta')
                    ->numeric()
                    ->readOnly()
                    ->live()
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('cantidad')
            ->columns([
                TextColumn::make('libro.titulo')
                    ->label(__('Libro')),
                Tables\Columns\TextColumn::make('cantidad')
                    ->label(__('cantidad')),
                TextColumn::make('valor_venta')
                    ->money('HNL')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularTotales();
                        $this->dispatch('recalcular-totales');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularTotales();
                        $this->dispatch('recalcular-totales');
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularTotales();
                        $this->dispatch('recalcular-totales');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            $this->ownerRecord->recalcularTotales();
                            $this->dispatch('recalcular-totales');
                        }),
                ]),
            ]);
    }
}
