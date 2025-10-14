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
      Schema::create('historico_clinico_aparatos_sistemas', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step aparatos sistemas');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->tinyInteger('sintomas_generales')->nullable()->comment('1=>Si 0=>No || Antecedente de sintomas generales de la persona perteneciente del historico clinico');
        $table->tinyInteger('aparato_digestivo')->nullable()->comment('1=>Si 0=>No || Antecedente de aparato digestivo de la persona perteneciente del historico clinico');
        $table->tinyInteger('aparato_respiratorio')->nullable()->comment('1=>Si 0=>No || Antecedente de aparato respiratorio de la persona perteneciente del historico clinico');
        $table->tinyInteger('cardiovascular')->nullable()->comment('1=>Si 0=>No || Antecedente cardiovascular de la persona perteneciente del historico clinico');
        $table->tinyInteger('urogenital')->nullable()->comment('1=>Si 0=>No || Antecedente urogenital de la persona perteneciente del historico clinico');
        $table->tinyInteger('musculoesqueletico')->nullable()->comment('1=>Si 0=>No || Antecedente musculoesqueletico de la persona perteneciente del historico clinico');
        $table->tinyInteger('endocrino')->nullable()->comment('1=>Si 0=>No || Antecedente endocrino de la persona perteneciente del historico clinico');
        $table->tinyInteger('hematopoyetico')->nullable()->comment('1=>Si 0=>No || Antecedente hematopoyetico de la persona perteneciente del historico clinico');
        $table->tinyInteger('nervioso')->nullable()->comment('1=>Si 0=>No || Antecedente nervioso de la persona perteneciente del historico clinico');
        $table->tinyInteger('piel_faneras')->nullable()->comment('1=>Si 0=>No || Antecedente de piel faneras de la persona perteneciente del historico clinico');
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
      Schema::dropIfExists('historico_clinico_aparatos_sistemas');
    }
};
