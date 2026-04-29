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
       
            Schema::create('tarjetas', function (Blueprint $table) {
    $table->id();

    $table->string('numero_tarjeta')->unique();
    $table->string('tipo'); // debito / credito
    $table->date('fecha_emision');
    $table->date('fecha_vencimiento');
    $table->string('pin_hash');
    $table->string('estatus')->default('activa');

    $table->foreignId('cuenta_id')->constrained()->onDelete('cascade');

    $table->timestamps();
    });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas');
    }
};
