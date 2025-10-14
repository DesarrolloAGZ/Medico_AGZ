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
      Schema::create('historico_clinico_exploracion_fisica', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step exploracion fisica');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->decimal('peso')->nullable()->comment('Peso de la persona perteneciente del historico clinico');
        $table->decimal('talla')->nullable()->comment('Talla de la persona perteneciente del historico clinico');
        $table->text('presion_arterial')->nullable()->comment('Presion arterial de la persona perteneciente del historico clinico');
        $table->decimal('frecuencia_cardiaca')->nullable()->comment('Frecuencia cardiaca de la persona perteneciente del historico clinico');
        $table->decimal('frecuencia_respiratoria')->nullable()->comment('Frecuencia respiratoria de la persona perteneciente del historico clinico');
        $table->decimal('temperatura')->nullable()->comment('Temperatura de la persona perteneciente del historico clinico');
        $table->decimal('glucosa')->nullable()->comment('Glucosa de la persona perteneciente del historico clinico');
        $table->tinyInteger('tatuajes')->nullable()->comment('1=>Si 0=>No || Tatuajes de la persona perteneciente del historico clinico');
        $table->text('craneo')->nullable()->comment('Observacion de craneo de la persona perteneciente del historico clinico');
        $table->text('cara')->nullable()->comment('Observacion de cara de la persona perteneciente del historico clinico');
        $table->text('ojos')->nullable()->comment('Observacion de ojos de la persona perteneciente del historico clinico');
        $table->text('a_visual_oi')->nullable()->comment('Observacion de agudeza visual ojo izquierdo de la persona perteneciente del historico clinico');
        $table->text('a_visual_od')->nullable()->comment('Observacion de agudeza visual ojo derecho de la persona perteneciente del historico clinico');
        $table->text('nariz')->nullable()->comment('Observacion de nariz de la persona perteneciente del historico clinico');
        $table->text('boca')->nullable()->comment('Observacion de boca de la persona perteneciente del historico clinico');
        $table->text('oidos')->nullable()->comment('Observacion de oidos de la persona perteneciente del historico clinico');
        $table->text('cuello')->nullable()->comment('Observacion de cuello de la persona perteneciente del historico clinico');
        $table->text('torax')->nullable()->comment('Observacion de torax de la persona perteneciente del historico clinico');
        $table->text('columna')->nullable()->comment('Observacion de columna de la persona perteneciente del historico clinico');
        $table->text('abdomen')->nullable()->comment('Observacion de abdomen de la persona perteneciente del historico clinico');
        $table->text('extremidades_superiores')->nullable()->comment('Observacion de extremidades superiores de la persona perteneciente del historico clinico');
        $table->text('extremidades_inferiores')->nullable()->comment('Observacion de inferiores superiores de la persona perteneciente del historico clinico');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('historico_clinico_id')->references('id')->on('historico_clinico');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('historico_clinico_exploracion_fisica');
    }
};
