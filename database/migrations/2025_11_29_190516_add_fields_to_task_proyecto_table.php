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
        Schema::table('tareas_proyecto', function (Blueprint $table) {
            // Agregar nombre de la tarea (título corto)
            $table->string('nombre', 200)->after('id_proyecto');
            
            // Hacer descripción nullable y más larga
            $table->text('descripcion')->nullable()->change();
            
            // Agregar asignación por miembro
            $table->unsignedBigInteger('asignado_a')->nullable()->after('descripcion');
            $table->foreign('asignado_a')->references('id_miembro')->on('miembros_equipo')->onDelete('set null');
            
            // Agregar fecha límite y prioridad
            $table->date('fecha_limite')->nullable()->after('fecha_completada');
            $table->string('prioridad', 20)->default('Media')->after('fecha_limite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tareas_proyecto', function (Blueprint $table) {
            $table->dropForeign(['asignado_a']);
            $table->dropColumn(['nombre', 'asignado_a', 'fecha_limite', 'prioridad']);
        });
    }
};
