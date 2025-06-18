<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    public function detallePrestamos():HasMany {
        return $this->hasMany(DetallePrestamo::class);
    }

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }
}
