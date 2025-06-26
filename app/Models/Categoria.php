<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(Libro::class, 'categoria_libros');
    }
}
