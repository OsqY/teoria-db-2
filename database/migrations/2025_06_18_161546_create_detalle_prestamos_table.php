<?php

use App\Models\Libro;
use App\Models\Prestamo;
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
        Schema::create('detalle_prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Prestamo::class)->constrained();
            $table->foreignIdFor(Libro::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_prestamos');
    }
};
