<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Libro extends Model
{
    public function editorial():BelongsTo
    {
        return $this->belongsTo(Editorial::class);
    }

    public function categorias():BelongsToMany {
        return $this->belongsToMany(Categoria::class,'categoria_libro');
    }
}
