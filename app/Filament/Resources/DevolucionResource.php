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

    public static function getModelLabel(): string
    {
        return __('Devolucion');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Devoluciones');
    }

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
                DatePicker::make('fecha')
                    ->label(__('fecha')),
                TextInput::make('cantidad_total')
                    ->label(__('cantidad_total'))
                    ->disabled()
                    ->numeric(),
                RichEditor::make('motivo')
                    ->label(__('motivo'))
                    ->columnSpanFull(),
                Select::make('usuario_id')
                    ->label(__('User'))
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
                    ->label(__('fecha'))
                    ->sortable(),
                TextColumn::make('cantidad_total')
                    ->label(__('cantidad_total'))
                    ->sortable()
                    ->badge(),
                TextColumn::make('motivo')
                    ->label(__('motivo'))
                    ->html(),
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
