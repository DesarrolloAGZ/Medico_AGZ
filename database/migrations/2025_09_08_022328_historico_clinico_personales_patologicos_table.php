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
      Schema::create('historico_clinico_personales_patologicos', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step personales patologicos');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('cronico_degenerativas')->nullable()->comment('Antecedentes cronicos degenerativos de la persona perteneciente del historico clinico');
        $table->text('traumaticos')->nullable()->comment('Antecedentes traumaticos de la persona perteneciente del historico clinico');
        $table->text('quirurgicos')->nullable()->comment('Antecedentes quirurgicos de la persona perteneciente del historico clinico');
        $table->text('transfusionales')->nullable()->comment('Antecedentes transfusionales de la persona perteneciente del historico clinico');
        $table->text('alergicos')->nullable()->comment('Antecedentes alergicos de la persona perteneciente del historico clinico');
        $table->text('hospitalizaciones')->nullable()->comment('Antecedentes de hospitalizaciones de la persona perteneciente del historico clinico');
        $table->text('otros')->nullable()->comment('Antecedentes de otros de la persona perteneciente del historico clinico');
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
      Schema::dropIfExists('historico_clinico_personales_patologicos');
    }
};
