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
    Schema::create('receta_firma_paciente', function (Blueprint $table) {
      $table->increments('id')->comment('ID único del paciente que firmo la receta de recibido');
      $table->unsignedBigInteger('receta_id')->nullable()->comment('ID de la receta relacionada');
      $table->unsignedBigInteger('paciente_id')->nullable()->comment('ID del paciente que recibio los medicamentos');
      $table->unsignedBigInteger('usuario_id')->nullable()->comment('ID del usuario que surtio la receta');
      $table->string('firma')->nullable()->comment('firma del paciente que recibio los medicamentos');
      $table->timestamps();
      $table->foreign('receta_id')->references('id')->on('receta');
      $table->foreign('usuario_id')->references('id')->on('usuario');
      $table->foreign('paciente_id')->references('id')->on('paciente');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('receta_firma_paciente');
  }
};
