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
    Schema::create('usuario_firma', function (Blueprint $table) {
      $table->increments('id')->comment('ID único de la firma');
      $table->unsignedBigInteger('usuario_id')->comment('Id del usuario relacionado a la firma');
      $table->string('firma')->nullable()->comment('firma del usuario medico');
      $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
      $table->timestamps();

      $table->foreign('usuario_id')->references('id')->on('usuario');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('usuario_firma');
  }
};
