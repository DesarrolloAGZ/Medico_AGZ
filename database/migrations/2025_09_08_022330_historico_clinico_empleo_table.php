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
      Schema::create('historico_clinico_empleo', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step empleo');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('ultimo_empleo')->nullable()->comment('Antecedente de ultimo empleo de la persona perteneciente del historico clinico');
        $table->text('motivo_separacion')->nullable()->comment('Antecedente de motivo de separacion de ultimo empleo de la persona perteneciente del historico clinico');
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
      Schema::dropIfExists('historico_clinico_empleo');
    }
};
