<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use App\Models\Venta;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

class EditVenta extends EditRecord
{
    protected static string $resource = VentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    #[On('recalcular-totales')]
    public function refreshForm()
    {
        $this->refreshFormData(['isv', 'sub_total', 'total_neto']);
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        $record->recalcularTotales();

        return $record;
    }
}
