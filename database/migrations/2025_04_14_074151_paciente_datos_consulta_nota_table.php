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
      Schema::create('paciente_datos_consulta_nota', function (Blueprint $table) {
        $table->increments('id')->comment('ID único de la nota');
        $table->text('descripcion')->comment('Texto de la nota');
        $table->unsignedBigInteger('paciente_id')->comment('Id del paciente al que corresponde la nota');
        $table->unsignedBigInteger('paciente_datos_consulta_id')->comment('Id de la consulta a la que se hizo la nota');
        $table->unsignedBigInteger('usuario_id')->comment('Id del usuario que guarda la nota');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('usuario_id')->references('id')->on('usuario');
        $table->foreign('paciente_id')->references('id')->on('paciente');
        $table->foreign('paciente_datos_consulta_id')->references('id')->on('paciente_datos_consulta');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('paciente_datos_consulta_nota');
    }
};
