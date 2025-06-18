<?php

use App\Models\Autor;
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
        Schema::create('autor_libro', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Autor::class)->constrained('autores');
            $table->foreignIdFor(Libro::class)->constrained('libros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_libros');
    }
};
