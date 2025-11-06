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
      Schema::create('receta_medicamento', function (Blueprint $table) {
        $table->unsignedBigInteger('receta_id')->comment('Id de la receta relacionada');
        $table->string('medicamento_id')->nullable()->comment('ID del medicamento en hispatec');
        $table->string('medicamento_nombre')->nullable()->comment('Nombre del medicamento en hispatec');
        $table->string('medicamento_codigo')->nullable()->comment('Codigo del medicamento en hispatec');
        $table->string('cantidad_solicitada')->nullable()->comment('Cantidad solicitada del medicamento');
        $table->unsignedBigInteger('empresa_id')->nullable()->comment('ID de la empresa de hispatec');
        $table->unsignedBigInteger('almacen_id')->nullable()->comment('ID del almacen de hispatec');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('receta_id')->references('id')->on('receta');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('receta_medicamento');
    }
};
