<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected static function booted()
    {

        static::saved(function (self $detalleVenta) {
            $venta = $detalleVenta->venta;
            $detalleVenta->libro->decrement('cantidad_disponible', $detalleVenta->cantidad);
            $venta->recalcularTotales();
        });

        static::updated(function (self $detalleVenta) {
            $venta = $detalleVenta->venta;
            $valor =  $detalleVenta->cantidad - $detalleVenta->getOriginal('cantidad');
            $detalleVenta->libro->decrement('cantidad_disponible', $valor);
            $venta->recalcularTotales();
        });

        static::deleted(function (self $detalleVenta) {
            $venta = $detalleVenta->venta;
            $detalleVenta->libro->increment('cantidad_disponible', $detalleVenta->cantidad);
            $venta->recalcularTotales();
        });
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }
}
