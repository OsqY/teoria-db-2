<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EditorialResource\Pages;
use App\Filament\Resources\EditorialResource\RelationManagers;
use App\Models\Editorial;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EditorialResource extends Resource
{
    protected static ?string $model = Editorial::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $pluralModelLabel = 'Editoriales';
    protected static ?string $modelLabel = 'Editorial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')->required(),
                RichEditor::make('direccion')->required()->columnSpanFull(),
                TextInput::make('telefono')->tel(),
                TextInput::make('sitio_web')->url(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('direccion')->html(),
                TextColumn::make('telefono'),
                TextColumn::make('sitio_web'),
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
