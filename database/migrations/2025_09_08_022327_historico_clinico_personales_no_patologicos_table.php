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
      Schema::create('historico_clinico_personales_no_patologicos', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step personales no patologicos');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('habitacion')->nullable()->comment('Antecedente habitacion de la persona perteneciente del historico clinico');
        $table->text('higiene_personal')->nullable()->comment('Antecedentes de higiene personal de la persona perteneciente del historico clinico');
        $table->text('actividad_fisica')->nullable()->comment('Antecedentes de actividad fisica de la persona perteneciente del historico clinico');
        $table->text('alcohol')->nullable()->comment('Antecedentes de alcohol de la persona perteneciente del historico clinico');
        $table->text('drogas')->nullable()->comment('Antecedentes de drogas de la persona perteneciente del historico clinico');
        $table->text('tabaco')->nullable()->comment('Antecedentes de tabaco de la persona perteneciente del historico clinico');
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
      Schema::dropIfExists('historico_clinico_personales_no_patologicos');
    }
};
