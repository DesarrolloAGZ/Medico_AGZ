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
      Schema::create('receta', function (Blueprint $table) {
        $table->increments('id')->comment('ID único de la receta');
        $table->unsignedBigInteger('paciente_id')->comment('Id del paciente al que corresponde la receta');
        $table->unsignedBigInteger('usuario_id')->comment('Id del usuario que guarda la receta');
        $table->text('medicamento_indicaciones')->comment('Texto del medicamento recetado e indicaciones');
        $table->text('recomendaciones')->nullable()->comment('Texto de las recomendaciones');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('paciente_id')->references('id')->on('paciente');
        $table->foreign('usuario_id')->references('id')->on('usuario');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('receta');
    }
};
