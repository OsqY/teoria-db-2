<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePrestamo extends Model
{
    public function prestamo():BelongsTo {
        return $this->belongsTo(Prestamo::class);
    }
    public function libro():BelongsTo {
        return $this->belongsTo(Libro::class);
    }
}
