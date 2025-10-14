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
      Schema::create('historico_clinico_heredofamiliares', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step heredofamiliares');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('cronico_degenerativas')->nullable()->comment('Antecedentes cronicos degenerativos de la persona perteneciente del historico clinico');
        $table->text('cancer')->nullable()->comment('Antecedentes de cancer de la persona perteneciente del historico clinico');
        $table->text('cardiopatias')->nullable()->comment('Antecedentes de cardiopatias de la persona perteneciente del historico clinico');
        $table->text('otras')->nullable()->comment('Antecedentes de otras de la persona perteneciente del historico clinico');

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
      Schema::dropIfExists('historico_clinico_heredofamiliares');
    }
};
