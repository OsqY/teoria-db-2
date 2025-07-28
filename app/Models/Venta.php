<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use SplFixedArray;

class Venta extends Model
{

    public function detalleVentas(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function usuarioComprante(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recalcularTotales(): void
    {
        $subtotalCalculado = $this->detalleVentas()->get()->sum(function ($detalle) {
            return $detalle->valor_venta * $detalle->cantidad;
        });

        $this->sub_total = $subtotalCalculado;
        $this->isv = $this->sub_total * 0.15;
        $this->total_neto = $this->sub_total + $this->isv + $this->valor_sancion - $this->descuentos;

        $this->saveQuietly();
    }

    protected static function booted()
    {
        static::creating(function (self $venta) {
            $venta->numero = Venta::max('numero') + 1;
        });
    }
}
