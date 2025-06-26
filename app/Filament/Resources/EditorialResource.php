<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EditorialResource\Pages;
use App\Models\Editorial;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EditorialResource extends Resource
{
    protected static ?string $model = Editorial::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function getPluralModelLabel(): string
    {
        return __('Editoriales');
    }

    public static function getModelLabel(): string
    {
        return __('Editorial');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Libros');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')->required()
                    ->label(__('nombre')),
                RichEditor::make('direccion')->required()->columnSpanFull()
                    ->label(__('direccion')),
                TextInput::make('telefono')->tel()
                    ->label(__('telefono')),
                TextInput::make('sitio_web')->url()
                    ->label(__('sitio_web')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label(__('nombre')),
                TextColumn::make('direccion')->html()
                    ->label(__('direccion')),
                TextColumn::make('telefono')
                    ->label(__('telefono')),
                TextColumn::make('sitio_web')
                    ->label(__('sitio_web')),
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
            'index' => Pages\ManageEditorials::route('/'),
        ];
    }
}
