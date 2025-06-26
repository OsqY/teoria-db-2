<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetalleCompraResource\Pages;
use App\Filament\Resources\DetalleCompraResource\RelationManagers;
use App\Models\DetalleCompra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetalleCompraResource extends Resource
{
    protected static ?string $model = DetalleCompra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('libro_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('compra_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libro_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('compra_id')
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
            'index' => Pages\ListDetalleCompras::route('/'),
            'create' => Pages\CreateDetalleCompra::route('/create'),
            'edit' => Pages\EditDetalleCompra::route('/{record}/edit'),
        ];
    }
}
