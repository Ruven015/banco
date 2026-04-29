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
        Schema::create('tipo_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('saldo_minimo', 10, 2)->default(0);
            $table->decimal('comision_manejo', 10, 2)->default(0);
            $table->integer('limite_retiro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_cuentas');
    }
};
