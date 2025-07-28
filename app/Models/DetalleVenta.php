<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\throwException;

class DetalleVenta extends Model
{
    protected static function booted()
    {
        static::creating(function (self $detalleVenta) {
            $libro = $detalleVenta->libro;

            if ($libro->cantidad_disponible < $detalleVenta->cantidad) {
                throw ValidationException::withMessages([
                    'cantidad' => 'La cantidad seleccionada no está disponible en inventario (' . $libro->cantidad_disponible . ' disponibles).',
                ]);
            }

            $libro->decrement('cantidad_disponible', $detalleVenta->cantidad);
        });

        static::updating(function (self $detalleVenta) {
            $cantidadOriginal = $detalleVenta->getOriginal('cantidad');
            $diferencia = $detalleVenta->cantidad - $cantidadOriginal;
            $libro = $detalleVenta->libro;

            if ($diferencia > 0 && $libro->cantidad_disponible < $diferencia) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No se puede aumentar la cantidad, no hay suficiente inventario disponible.',
                ]);
            }

            if ($diferencia != 0) {
                $libro->decrement('cantidad_disponible', $diferencia);
            }
        });

        static::saved(function (self $detalleVenta) {
            $detalleVenta->venta->recalcularTotales();
        });

        static::deleted(function (self $detalleVenta) {
            $detalleVenta->libro->increment('cantidad_disponible', $detalleVenta->cantidad);
            $detalleVenta->venta->recalcularTotales();
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
