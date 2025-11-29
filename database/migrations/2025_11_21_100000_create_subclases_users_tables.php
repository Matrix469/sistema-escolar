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

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->foreignId('id_usuario')->primary()->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->string('numero_control', 20)->unique();
            $table->integer('semestre');
            $table->foreignId('id_carrera')->constrained('cat_carreras', 'id_carrera');
        });
        Schema::create('jurados', function (Blueprint $table) {
            $table->foreignId('id_usuario')->primary()->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->string('cedula_profesional', 50)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('empresa_institucion', 100)->nullable();
        });
    }
// El Down está correcto como lo tenías

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurados');
        Schema::dropIfExists('estudiantes');
    }
};
