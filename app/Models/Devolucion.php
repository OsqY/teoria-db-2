<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devolucion extends Model
{
    protected $table = 'devoluciones';

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detalleDevoluciones(): HasMany
    {
        return $this->hasMany(DetalleDevolucion::class);
    }
}
