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
        Schema::create('pago_servicios', function (Blueprint $table) {
    
    $table->id();

    $table->string('servicio'); // luz, agua, etc
    $table->string('referencia');
    $table->decimal('monto', 12, 2);
    $table->dateTime('fecha_hora');
    $table->string('estatus')->default('pagado');

    $table->foreignId('cuenta_id')->constrained()->onDelete('cascade');

    $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_servicios');
    }
};
