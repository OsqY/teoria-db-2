<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    protected static function booted()
    {
        static::created(function (self $detalleCompra) {
            $detalleCompra->libro->increment('cantidad_disponible', $detalleCompra->cantidad);
        });

        static::updating(function (self $detalleCompra) {
            $originalCantidad = $detalleCompra->getOriginal('cantidad');
            $diferencia = $detalleCompra->cantidad - $originalCantidad;
            $detalleCompra->libro->increment('cantidad_disponible', $diferencia);
        });

        static::deleted(function (self $detalleCompra) {
            $detalleCompra->libro->decrement('cantidad_disponible', $detalleCompra->cantidad);
        });
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }
}
