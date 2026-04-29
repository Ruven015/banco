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
      
            Schema::create('transacciones', function (Blueprint $table) {
    $table->id();

    $table->string('tipo'); // deposito, retiro, transferencia
    $table->decimal('monto', 12, 2);
    $table->dateTime('fecha_hora');
    $table->string('descripcion')->nullable();
    $table->string('canal'); // ATM, online, cajero
    $table->string('referencia')->nullable();
    $table->string('estado')->default('completado');

    // 🔥 RELACIONES
    $table->foreignId('cuenta_origen_id')->constrained('cuentas')->onDelete('cascade');
    $table->foreignId('cuenta_destino_id')->nullable()->constrained('cuentas')->onDelete('cascade');

    $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
