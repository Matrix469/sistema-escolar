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
        // Carreras
        Schema::create('cat_carreras', function (Blueprint $table) {
            $table->id('id_carrera');
            $table->string('nombre', 100)->unique();
        });

        // 2. Roles de Equipo
        Schema::create('cat_roles_equipo', function (Blueprint $table) {
            $table->id('id_rol_equipo');
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
        });

        // Roles del Sistema 
        Schema::create('cat_roles_sistema', function (Blueprint $table) {
            $table->id('id_rol_sistema');
            $table->string('nombre', 20)->unique(); // admin, jurado, estudiante
        });

        // Tokens Jurados
        Schema::create('tokens_jurado', function (Blueprint $table) {
            $table->id('id_token');
            $table->string('token', 64)->unique();
            $table->boolean('usado')->default(false);
            $table->timestamp('fecha_expiracion');
            $table->string('email_invitado', 150)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens_jurado');
        Schema::dropIfExists('cat_roles_sistema'); // Agregado al rollback
        Schema::dropIfExists('cat_roles_equipo');
        Schema::dropIfExists('cat_carreras');
    }
};
