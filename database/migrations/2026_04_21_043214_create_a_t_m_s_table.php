<?php

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
        Schema::create('atms', function (Blueprint $table) {
    $table->id();

    $table->string('codigo_atm')->unique();
    $table->string('ubicacion');
    $table->decimal('efectivo_disponible', 12, 2)->default(0);
    $table->string('estatus')->default('activo');

    // 🔥 RELACIÓN
    $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atms');
    }
};
