<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donacion extends Model
{
    public function detalleDonaciones(): HasMany
    {
        return $this->hasMany(DetalleDonacion::class);
    }
}
