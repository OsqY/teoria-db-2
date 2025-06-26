<?php

use App\Models\Libro;
use App\Models\Proveedor;
use App\Models\User;
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
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->text('motivo')->nullable();
            $table->foreignIdFor(Proveedor::class)->nullable()->constrained()->on('proveedores');
            $table->foreignIdFor(User::class, 'usuario_donante_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaciones');
    }
};
