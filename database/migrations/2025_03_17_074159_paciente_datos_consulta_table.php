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
        Schema::create('paciente_datos_consulta', function (Blueprint $table) {
            $table->increments('id')->comment('ID único de los datos de la consulta del paciente');
            $table->unsignedBigInteger('paciente_id')->comment('ID del paciente');
            $table->text('motivo_consulta')->comment('Descripcion del motivo de la consulta');
            $table->unsignedBigInteger('cie_id')->comment('ID del cie');
            $table->text('cie_descripcion')->comment('Descripcion del cie');
            $table->text('temperatura')->comment('Temperatura del paciente');
            $table->text('peso')->comment('Peso del paciente');
            $table->text('altura')->comment('Altura del paciente');
            $table->text('imc')->comment('IMC del paciente');
            $table->text('frecuencia_cardiaca')->comment('Frecuencia cardiaca del paciente');
            $table->text('saturacion_oxigeno')->comment('Saturacion de oxigeno del paciente');
            $table->text('presion_arterial')->comment('Presion arterial del paciente');
            $table->text('observaciones')->nullable()->comment('Observaciones de la consulta');
            $table->text('medicamento_recetado')->nullable()->comment('Medicamento recetado en la consulta');
            $table->unsignedBigInteger('paciente_tipo_visita_id')->comment('ID del tipo de consulta');

            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('paciente');
            $table->foreign('cie_id')->references('id')->on('paciente_cie');
            $table->foreign('paciente_tipo_visita_id')->references('id')->on('paciente_tipo_visita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_datos_consulta');
    }
};
