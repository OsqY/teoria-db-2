<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibroResource\Pages;
use App\Models\Libro;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LibroResource extends Resource
{
    protected static ?string $model = Libro::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getPluralModelLabel(): string
    {
        return __('Libros');
    }

    public static function getModelLabel(): string
    {
        return __('Libro');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Libros');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->label(__('titulo'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('isbn')
                    ->label(__('isbn'))
                    ->required()
                    ->maxLength(255),
                Select::make('autores')
                    ->label(__('Autores'))
                    ->relationship('autores', 'nombres')
                    ->multiple()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nombres . ' ' . $record->apellidos)
                    ->searchable(),
                Select::make('editorial_id')->required()
                    ->label(__('Editorial'))
                    ->relationship('editorial', 'nombre')
                    ->searchable(),
                Select::make('categorias')
                    ->label(__('Categorias'))
                    ->multiple()
                    ->relationship('categorias', 'nombre')
                    ->required()
                    ->searchable(),
                Forms\Components\DatePicker::make('anio_publicacion')
                    ->label(__('anio_publicacion'))
                    ->required(),
                TextInput::make(
                    'precio_base'
                )
                    ->label(__('precio_base'))
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('cantidad_disponible')
                    ->label(__('cantidad_disponible'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label(__('titulo'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label(__('isbn'))
                    ->searchable(),
                TextColumn::make('editorial.nombre')
                    ->label(__('Editorial'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('anio_publicacion')
                    ->label(__('anio_publicacion'))
                    ->date()
                    ->sortable(),
                TextColumn::make('precio_base')
                    ->label(__('precio_base'))
                    ->money('HNL'),
                Tables\Columns\TextColumn::make('cantidad_disponible')
                    ->label(__('cantidad_disponible'))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibros::route('/'),
            'create' => Pages\CreateLibro::route('/create'),
            'edit' => Pages\EditLibro::route('/{record}/edit'),
        ];
    }
}
