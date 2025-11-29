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
        // 1. Eventos
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->integer('cupo_max_equipos');
            $table->enum('estado', ['Próximo', 'Activo', 'Cerrado', 'Finalizado'])->default('Próximo');
        });

        Schema::create('evento_jurados', function (Blueprint $table) {
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->foreignId('id_jurado')->constrained('jurados', 'id_usuario')->onDelete('cascade');
            $table->string('rol_en_evento', 50)->default('Evaluador General');
            $table->primary(['id_evento', 'id_jurado']);
        });

        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // 4. Inscripciones
        Schema::create('inscripciones_evento', function (Blueprint $table) {
            $table->id('id_inscripcion');
            $table->foreignId('id_equipo')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->string('codigo_acceso_equipo', 20)->nullable();
            $table->timestamp('fecha_inscripcion')->useCurrent();
            $table->integer('puesto_ganador')->nullable();
            $table->enum('status_registro', ['Incompleto', 'Completo', 'Descalificado'])->default('Incompleto');
            $table->unique(['id_equipo', 'id_evento']);
        });

        // 5. Miembros (Necesita que el Archivo 3 ya se haya ejecutado)
        Schema::create('miembros_equipo', function (Blueprint $table) {
            $table->id('id_miembro');
            $table->foreignId('id_inscripcion')->constrained('inscripciones_evento', 'id_inscripcion')->onDelete('cascade');
            $table->foreignId('id_estudiante')->constrained('estudiantes', 'id_usuario');
            $table->foreignId('id_rol_equipo')->constrained('cat_roles_equipo', 'id_rol_equipo');
            $table->boolean('es_lider')->default(false);
            $table->unique(['id_inscripcion', 'id_estudiante']);
        });
    }
// El Down está correcto como lo tenías
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros_equipo');
        Schema::dropIfExists('inscripciones_evento');
        Schema::dropIfExists('equipos');
        Schema::dropIfExists('evento_jurados');
        Schema::dropIfExists('eventos');
    }
};
