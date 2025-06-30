<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleDonacion extends Model
{
    protected $table = 'detalle_donaciones';

    protected static function booted()
    {
        static::created(function (self $detalle) {
            $detalle->libro->increment('cantidad_disponible', $detalle->cantidad);
        });


        static::updating(function (self $detalle) {
            $originalCantidad = $detalle->getOriginal('cantidad');
            $diferencia = $detalle->cantidad - $originalCantidad;
            $detalle->libro->increment('cantidad_disponible', $diferencia);
        });

        static::deleted(function (self $detalle) {
            $detalle->libro->decrement('cantidad_disponible', $detalle->cantidad);
        });
    }

    public function donacion(): BelongsTo
    {
        return $this->belongsTo(Donacion::class);
    }
    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }
}
