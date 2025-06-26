<?php

use App\Models\Devolucion;
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
        Schema::create('detalle_devoluciones', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Libro::class)->constrained();
            $table->foreignIdFor(Devolucion::class)->constrained()->on('devoluciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_devoluciones');
    }
};
