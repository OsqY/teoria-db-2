<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{

    public function recalcularValor(): void
    {
        $this->valor_de_compra = $this->detalleCompras->sum('sub_total');
        $this->cantidad_total = $this->detalleCompras->sum('cantidad');
        $this->save();
    }

    protected static function booted()
    {
        static::creating(function (self $compra) {
            $compra->cantidad_total = 0;
            $compra->valor_de_compra = 0;
        });
    }

    public function detalleCompras(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}
