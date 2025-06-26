<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DevolucionResource\Pages;
use App\Filament\Resources\DevolucionResource\RelationManagers;
use App\Filament\Resources\DevolucionResource\RelationManagers\DetalleDevolucionesRelationManager;
use App\Models\DetalleVenta;
use App\Models\Devolucion;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DevolucionResource extends Resource
{
    protected static ?string $model = Devolucion::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Transacciones');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('fecha'),
                TextInput::make('cantidad_total')
                    ->numeric(),
                RichEditor::make('motivo')
                    ->columnSpanFull(),
                Select::make('usuario_id')
                    ->relationship('usuario', 'name')
                    ->preload()
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->sortable(),
                TextColumn::make('cantidad_total')
                    ->sortable()
                    ->badge(),
                TextColumn::make('motivo')
                    ->html(),
                TextColumn::make('usuario.name')


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
            DetalleDevolucionesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevolucions::route('/'),
            'create' => Pages\CreateDevolucion::route('/create'),
            'edit' => Pages\EditDevolucion::route('/{record}/edit'),
        ];
    }
}
