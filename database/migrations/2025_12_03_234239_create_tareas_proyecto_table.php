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
        Schema::create('tareas_proyecto', function (Blueprint $table) {
            $table->id('id_tarea');
            $table->foreignId('id_proyecto')->constrained('proyectos', 'id_proyecto')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->foreignId('asignado_a')->nullable()->constrained('miembros_equipo', 'id_miembro')->onDelete('set null');
            $table->boolean('completada')->default(false);
            $table->foreignId('completada_por')->nullable()->constrained('users', 'id_usuario');
            $table->timestamp('fecha_completada')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_proyecto');
    }
};
