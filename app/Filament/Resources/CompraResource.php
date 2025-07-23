<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompraResource\Pages;
use App\Filament\Resources\CompraResource\RelationManagers;
use App\Filament\Resources\CompraResource\RelationManagers\DetalleComprasRelationManager;
use App\Models\Compra;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Compra');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Compras');
    }


    public static function getNavigationGroup(): ?string
    {
        return __('Transacciones');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cantidad_total')
                    ->label(__('cantidad_total'))
                    ->default(0)
                    ->disabled()
                    ->numeric(),
                Forms\Components\TextInput::make('valor_de_compra')
                    ->label(__('valor_de_compra'))
                    ->default(0)
                    ->disabled()
                    ->numeric(),
                Select::make('proveedor_id')
                    ->label(__('Proveedor'))
                    ->preload()
                    ->searchable()
                    ->relationship('proveedor', 'nombre')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cantidad_total')
                    ->label(__('cantidad_total'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_de_compra')
                    ->label(__('valor_de_compra'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->label(__('Proveedor'))
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
            DetalleComprasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }
}
