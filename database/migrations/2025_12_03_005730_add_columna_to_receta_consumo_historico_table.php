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
        Schema::table('receta_consumo_historico', function (Blueprint $table) {
          $table->unsignedBigInteger('receta_id')->nullable()->comment('ID de la receta relacionada');
          $table->text('centro_costos')->nullable()->comment('Centro de costos asociado a la receta');
          $table->text('vale_id')->nullable()->comment('ID del vale asociado a la receta');

          $table->foreign('receta_id')->references('id')->on('receta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receta_consumo_historico', function (Blueprint $table) {
          $table->dropForeign(['receta_id']);
          $table->dropColumn('receta_id');
        });
    }
};
