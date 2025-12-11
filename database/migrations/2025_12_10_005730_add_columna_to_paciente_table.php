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
        Schema::table('paciente', function (Blueprint $table) {
          $table->unsignedBigInteger('usuario_id')->nullable()->comment('ID del usuario que creó el paciente');

          $table->foreign('usuario_id')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paciente', function (Blueprint $table) {
          $table->dropForeign(['usuario_id']);
          $table->dropColumn('usuario_id');
        });
    }
};
