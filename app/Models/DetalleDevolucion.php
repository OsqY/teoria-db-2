<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleDevolucion extends Model
{
    protected $table = 'detalle_devoluciones';

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }

    public function devolucion(): BelongsTo
    {
        return $this->belongsTo(Devolucion::class);
    }

    protected static function booted()
    {
        static::created(function (self $detalleDevolucion) {
            $detalleDevolucion->libro->increment('cantidad_disponible', 1);
        });

        static::updated(function (self $detalleDevolucion) {
            $original = $detalleDevolucion->getOriginal('libro_id');

            if ($original !== $detalleDevolucion->libro_id) {
                $libroOriginal = Libro::findOrFail($original);
                $libroOriginal->decrement('cantidad_disponible', 1);
                $detalleDevolucion->libro->increment('cantidad_disponible', 1);
            }
        });

        static::deleted(function (self $detalleDevolucion) {
            $detalleDevolucion->libro->decrement('cantidad_disponible', 1);
        });
    }
}
