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
    // * Tabla ya existe en la base de datos
    // Schema::create ya fue ejecutado previamente
    /*
    Schema::create('tareas_proyecto', function (Blueprint $table) {
        $table->id('id_tarea');
        $table->unsignedBigInteger('id_proyecto');
        $table->string('nombre', 200); // Título de la tarea
        $table->text('descripcion')->nullable(); // Descripción detallada (opcional)
        $table->unsignedBigInteger('asignado_a')->nullable(); // id_miembro o NULL = todo el equipo
        $table->boolean('completada')->default(false);
        $table->unsignedBigInteger('completada_por')->nullable();
        $table->timestamp('fecha_completada')->nullable();
        $table->date('fecha_limite')->nullable(); // Fecha límite opcional
        $table->string('prioridad', 20)->default('Media'); // Alta, Media, Baja
        $table->timestamps();

        // Claves foráneas
        $table->foreign('id_proyecto')->references('id_proyecto')->on('proyectos')->onDelete('cascade');
        $table->foreign('asignado_a')->references('id_miembro')->on('miembros_equipo')->onDelete('set null');
        $table->foreign('completada_por')->references('id_usuario')->on('users');
    });
    */
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_proyectos');
    }
};
