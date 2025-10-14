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
      Schema::create('historico_clinico_laborales', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step laborales');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('empresa')->nullable()->comment('Antecedente de empresa de la persona perteneciente del historico clinico');
        $table->text('giro')->nullable()->comment('Antecedente de giro de la empresa de la persona perteneciente del historico clinico');
        $table->text('antiguedad')->nullable()->comment('Antecedente de antiguedad de la empresa de la persona perteneciente del historico clinico');
        $table->text('actividad')->nullable()->comment('Antecedente de actividad desarrollada en la empresa de la persona perteneciente del historico clinico');
        $table->tinyInteger('accidentes')->nullable()->comment('1=>Si 0=>No || Antecedente de accidentes en la empresa de la persona perteneciente del historico clinico');
        $table->tinyInteger('enfermedad')->nullable()->comment('1=>Si 0=>No || Antecedente de enfermedad en la empresa de la persona perteneciente del historico clinico');
        $table->text('biologicos')->nullable()->comment('1=>Si 0=>No || Antecedentes biologicos en la empresa de la persona perteneciente del historico clinico');
        $table->text('quimicos')->nullable()->comment('1=>Si 0=>No || Antecedentes quimicos en la empresa de la persona perteneciente del historico clinico');
        $table->text('fisicos')->nullable()->comment('1=>Si 0=>No || Antecedentes fisicos en la empresa de la persona perteneciente del historico clinico');
        $table->text('ergonomicos')->nullable()->comment('1=>Si 0=>No || Antecedentes fisicos en la empresa de la persona perteneciente del historico clinico');
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
      Schema::dropIfExists('historico_clinico_laborales');
    }
};
