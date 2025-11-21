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
      Schema::create('receta_vale_historico', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del histórico de vale generado para la receta');
        $table->json('json_data')->nullable()->comment('Estructura JSON con los datos del vale generado para la receta');
        $table->text('respuesta_api')->nullable()->comment('Respuesta de la API del vale generado para la receta');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('receta_vale_historico');
    }
};
