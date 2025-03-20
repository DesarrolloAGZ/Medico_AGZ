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
        Schema::create('paciente_datos_consulta_historico', function (Blueprint $table) {
            $table->increments('id')->comment('ID único del paciente historico');
            $table->unsignedBigInteger('paciente_datos_consulta_id')->comment('ID de los datos de consulta del paciente');
            $table->string('tipo_movimiento', 2)->comment('Tipo de movimiento realizado U=>Update I=>Insert');
            $table->text('data')->comment('json de los datos realizados en la acción');
            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();

            $table->foreign('paciente_datos_consulta_id')->references('id')->on('paciente_datos_consulta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_datos_consulta_historico');
    }
};
