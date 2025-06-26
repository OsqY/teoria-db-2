<?php

namespace App\Filament\Resources\DetalleDonacionResource\Pages;

use App\Filament\Resources\DetalleDonacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetalleDonacions extends ListRecords
{
    protected static string $resource = DetalleDonacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
