<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AutorResource\Pages;
use App\Models\Autor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AutorResource extends Resource
{
    protected static ?string $model = Autor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function getPluralModelLabel(): string {
        return __('Autores');
    }

    public static function getModelLabel(): string {
        return __('Autor');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombres')->required()
                ->label(__('nombres')),
                TextInput::make('apellidos')->required()
                ->label(__('apellidos')),
                DatePicker::make('fecha_nacimiento')->required()
                ->label(__('fecha_nacimiento'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombres')
                ->label(__('nombres')),
                TextColumn::make('apellidos')
                ->label(__('apellidos')),
                TextColumn::make('fecha_nacimiento')
                ->label(__('fecha_nacimiento')),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAutors::route('/'),
        ];
    }
}
