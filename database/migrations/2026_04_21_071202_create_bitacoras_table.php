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
       Schema::create('bitacoras', function (Blueprint $table) {
    $table->id();

    $table->string('accion'); // crear, actualizar, eliminar
    $table->string('tabla');  // clientes, cuentas, etc
    $table->text('descripcion')->nullable();

    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
