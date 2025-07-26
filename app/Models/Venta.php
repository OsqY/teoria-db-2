<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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
        $this->sub_total = $this->detalleVentas()->sum('valor_venta');
        $this->isv = $this->sub_total * 0.15;
        $this->total_neto = $this->sub_total + $this->isv - $this->descuentos + $this->valor_sancion;
        $this->save();
    }

    protected static function booted()
    {
        static::creating(function (self $venta) {
            $venta->numero = Venta::max('numero') + 1;
        });
    }
}
