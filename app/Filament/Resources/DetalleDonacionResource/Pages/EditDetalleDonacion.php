<?php

namespace App\Filament\Resources\DetalleDonacionResource\Pages;

use App\Filament\Resources\DetalleDonacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetalleDonacion extends EditRecord
{
    protected static string $resource = DetalleDonacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
