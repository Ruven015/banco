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
        Schema::create('empleados', function (Blueprint $table) {
    $table->id();

    $table->string('nombre');
    $table->string('apellidos');
    $table->string('puesto');

    $table->string('estatus')->default('activo');

    // 🔥 RELACIÓN CON USUARIO
    $table->foreignId('user_id')->nullable()->unique()->constrained()->onDelete('cascade');

    // 🔥 RELACIÓN CON SUCURSAL
    $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
    
};
