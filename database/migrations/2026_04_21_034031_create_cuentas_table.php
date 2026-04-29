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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta')->unique();
            $table->decimal('saldo', 12, 2)->default(0);
            $table->date('fecha_apertura');
            $table->boolean('estatus')->default(true);

            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('tipo_cuenta_id')->constrained()->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained('sucursales')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
