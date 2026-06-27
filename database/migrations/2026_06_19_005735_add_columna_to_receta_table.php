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
    Schema::table('receta', function (Blueprint $table) {
      $table->unsignedBigInteger('receta_estatus_id')->default('1')->nullable()->comment('ID del estatus de la receta');
      $table->tinyInteger('surtida')->nullable()->default('0')->comment('Bandera de receta surtida 0=>No 1=>Si');

      $table->foreign('receta_estatus_id')->references('id')->on('receta_estatus');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropColumn('receta', function (Blueprint $table) {
      $table->dropForeign(['receta_estatus_id']);
      $table->dropColumn('receta_estatus_id');
      $table->dropForeign(['surtida']);
    });
  }
};
