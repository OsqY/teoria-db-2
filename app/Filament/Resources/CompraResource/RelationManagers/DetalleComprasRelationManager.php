<?php

namespace App\Filament\Resources\CompraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleComprasRelationManager extends RelationManager
{
    protected static string $relationship = 'detalleCompras';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('detalleCompra');
    }

    public static function getPluralModelLabel(): string
    {
        return __('detalleCompras');
    }

    public static function getModelLabel(): string
    {
        return __('detalleCompra');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('libro_id')
                    ->relationship('libro', 'titulo')
                    ->label(__('Libro'))
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('cantidad')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->label(__('cantidad'))
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $precio = $get('precio_unidad') ?? 0;
                        $cantidad = $get('cantidad') ?? 0;
                        if ($cantidad > 0 && $precio > 0) {
                            $set('sub_total',  (float)$cantidad * (float)$precio);
                        }
                    })
                    ->required(),
                TextInput::make('precio_unidad')
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->label(__('precio_unidad'))
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $precio = $get('precio_unidad') ?? 0;
                        $cantidad = $get('cantidad') ?? 0;
                        if ($cantidad > 0 && $precio > 0) {
                            $set('sub_total',  (float)$cantidad * (float)$precio);
                        }
                    }),
                TextInput::make('sub_total')
                    ->numeric()
                    ->label(__('sub_total'))
                    ->disabled()
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
                    ->label(__('cantidad')),
                Tables\Columns\TextColumn::make('precio_unidad')
                    ->label(__('precio_unidad'))
                    ->money('HNL'),
                Tables\Columns\TextColumn::make('sub_total')
                    ->label(__('sub_total'))
                    ->money('HNL'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularValor();
                        $this->dispatch('actualizar-totales');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularValor();
                        $this->dispatch('actualizar-totales');
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->ownerRecord->recalcularValor();
                        $this->dispatch('actualizar-totales');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            $this->ownerRecord->recalcularValor();
                            $this->dispatch('actualizar-totales');
                        }),
                ]),
            ]);
    }
}
