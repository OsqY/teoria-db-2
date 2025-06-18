<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
    protected $table = 'autores';

    public function libros():BelongsToMany {
        return $this->belongsToMany(Libro::class);
    }
}
