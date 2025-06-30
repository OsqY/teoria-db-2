<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Transacciones');
    }

    public static function getModelLabel(): string
    {
        return __('Venta');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Ventas');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero')
                    ->disabled()
                    ->numeric(),
                Forms\Components\TextInput::make('isv')
                    ->disabled()
                    ->label(__('isv'))
                    ->numeric(),
                Forms\Components\TextInput::make('sub_total')
                    ->disabled()
                    ->label(__('sub_total'))
                    ->numeric(),
                Forms\Components\TextInput::make('total_neto')
                    ->disabled()
                    ->label(__('total_neto'))
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha')
                    ->label(__('fecha'))
                    ->required(),
                Forms\Components\TextInput::make('descuentos')
                    ->label(__('descuentos'))
                    ->numeric(),
                Forms\Components\Select::make('usuario_comprante_id')
                    ->label(__('usuario_comprante'))
                    ->relationship('usuarioComprante', 'name')
                    ->preload()
                    ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isv')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descuentos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_neto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('usuario_comprante_id')
                    ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
