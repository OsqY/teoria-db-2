<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonacionResource\Pages;
use App\Filament\Resources\DonacionResource\RelationManagers;
use App\Filament\Resources\DonacionResource\RelationManagers\DetalleDonacionesRelationManager;
use App\Models\Donacion;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonacionResource extends Resource
{
    protected static ?string $model = Donacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Donacion');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Donaciones');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Transacciones');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('motivo')
                    ->label(__('motivo'))
                    ->columnSpanFull()
                    ->required(),
                Select::make('proveedor_id')
                    ->label(__('Proveedor'))
                    ->relationship('proveedor', 'nombre')
                    ->searchable()
                    ->preload(),
                Select::make('usuario_donante_id')
                    ->label(__('usuario_donante'))
                    ->relationship('usuario', 'name')
                    ->searchable()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('motivo')
                    ->label(__('motivo'))
                    ->html(),
                TextColumn::make('proveedor.nombre')
                    ->label(__('Proveedor')),
                TextColumn::make('usuario.name')
                    ->label(__('User'))
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
            DetalleDonacionesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonacions::route('/'),
            'create' => Pages\CreateDonacion::route('/create'),
            'edit' => Pages\EditDonacion::route('/{record}/edit'),
        ];
    }
}
