<?php

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categoria_libro', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Categoria::class)->constrained();
            $table->foreignIdFor(Libro::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_libros');
    }
};
