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
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('ruta_imagen')->nullable()->after('descripcion');
        });

        Schema::table('equipos', function (Blueprint $table) {
            $table->string('ruta_imagen')->nullable()->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('ruta_imagen');
        });

        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn('ruta_imagen');
        });
    }
};
