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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();

            $table->decimal('monto', 12, 2);
            $table->decimal('tasa_interes', 5, 2);
            $table->integer('plazo_meses');

            $table->date('fecha_solicitud');
            $table->date('fecha_aprobacion')->nullable();

            $table->decimal('saldo_pendiente', 12, 2);

            $table->string('estado')->default('pendiente'); 
            // pendiente, aprobado, rechazado, pagado

            // 🔥 RELACIÓN CON CLIENTE
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // 🔥 RELACIÓN CON EMPLEADO (quien aprueba)
            $table->foreignId('empleado_id')
                ->nullable()
                ->constrained('empleados')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
