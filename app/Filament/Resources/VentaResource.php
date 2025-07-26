<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Filament\Resources\VentaResource\RelationManagers;
use App\Filament\Resources\VentaResource\RelationManagers\DetalleVentasRelationManager;
use App\Models\User;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                    ->label(__('numero'))
                    ->numeric(),
                Forms\Components\TextInput::make('isv')
                    ->disabled()
                    ->label(__('isv'))
                    ->numeric(),
                Forms\Components\TextInput::make('sub_total')
                    ->disabled()
                    ->label(__('sub_total'))
                    ->numeric(),
                Forms\Components\TextInput::make('valor_sancion')
                    ->disabled()
                    ->label(__('valor_sancion'))
                    ->numeric(),
                Forms\Components\TextInput::make('total_neto')
                    ->disabled()
                    ->label(__('total_neto'))
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha')
                    ->label(__('fecha'))
                    ->minDate(now()->toDateString())
                    ->required(),
                Forms\Components\TextInput::make('descuentos')
                    ->label(__('descuentos'))
                    ->default(0)
                    ->minValue(0)
                    ->numeric(),
                Forms\Components\Select::make('usuario_comprante_id')
                    ->label(__('usuario_comprante'))
                    ->options(function () {
                        $user = Auth::user();
                        if ($user->hasRole('super_admin')) {
                            return User::pluck('name', 'id');
                        }
                        return [$user->id => $user->name];
                    })
                    ->searchable()
                    ->default(function () {
                        $user = Auth::user();
                        if (!$user->hasRole('super_admin')) {
                            return $user->id;
                        }
                        return null;
                    })
                    ->disabled(fn() => !Auth::user()->hasRole('super_admin'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->numeric()
                    ->label(__('numero'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->date()
                    ->label(__('fecha'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('isv')
                    ->numeric()
                    ->label(__('isv'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->label(__('sub_total'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_sancion')
                    ->label(__('valor_sancion'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descuentos')
                    ->label(__('descuentos'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_neto')
                    ->label(__('total_neto'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('usuarioComprante.name')
                    ->label(__('usuario_comprante'))
                    ->numeric()
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
            DetalleVentasRelationManager::class
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if (!$user->hasRole('super_admin')) {
            $query->where('usuario_comprante_id', $user->id);
        }

        return $query;
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
