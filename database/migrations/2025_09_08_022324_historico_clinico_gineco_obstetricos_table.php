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
      Schema::create('historico_clinico_gineco_obstetricos', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step gineco obstetricos');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('menarca')->nullable()->comment('Menarca || dato del genero femenino para el historico clinico');
        $table->text('fur')->nullable()->comment('FUR || dato del genero femenino para el historico clinico');
        $table->text('ritmo')->nullable()->comment('Ritmo || dato del genero femenino para el historico clinico');
        $table->text('ivsa')->nullable()->comment('Ivsa || dato del genero femenino para el historico clinico');
        $table->text('gesta')->nullable()->comment('Gesta || dato del genero femenino para el historico clinico');
        $table->text('partos')->nullable()->comment('Partos || dato del genero femenino para el historico clinico');
        $table->text('doc')->nullable()->comment('DOC || dato del genero femenino para el historico clinico');
        $table->text('cesareas')->nullable()->comment('Cesareas || dato del genero femenino para el historico clinico');
        $table->text('abortos')->nullable()->comment('Abortos || dato del genero femenino para el historico clinico');
        $table->text('anticonceptivo')->nullable()->comment('Anticonceptivo || dato del genero femenino para el historico clinico');
        $table->text('otros')->nullable()->comment('Otros || dato del genero femenino para el historico clinico');
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
      Schema::dropIfExists('historico_clinico_gineco_obstetricos');
    }
};
