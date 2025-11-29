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
        Schema::create('solicitudes_union', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes', 'id_usuario')->onDelete('cascade');
            $table->enum('status', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->text('mensaje')->nullable();
            $table->timestamps();

            $table->unique(['equipo_id', 'estudiante_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_union');
    }
};
