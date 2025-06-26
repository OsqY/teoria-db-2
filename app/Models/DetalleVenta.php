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
            $venta->recalcularTotales();
        });

        static::deleted(function (self $detalleVenta) {
            $venta = $detalleVenta->venta;
            $venta->recalcularTotales();
        });
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }
}
