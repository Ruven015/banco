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
        Schema::create('solicitud_prestamos', function (Blueprint $table) {
            $table->id();

            $table->decimal('monto_solicitado', 12, 2);
            $table->integer('plazo');
            $table->decimal('ingresos_mensuales', 12, 2);

            $table->date('fecha_solicitud');
            $table->string('estado')->default('pendiente');
            $table->string('observaciones')->nullable();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_prestamos');
    }
};
