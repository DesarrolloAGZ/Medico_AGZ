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
      Schema::create('unidad_negocio_area', function (Blueprint $table) {
        $table->unsignedBigInteger('paciente_unidad_negocio_id')->comment('Id de la unidad de negocio');
        $table->unsignedBigInteger('paciente_area_id')->comment('Id de la empresa');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('paciente_unidad_negocio_id')->references('id')->on('paciente_unidad_negocio');
        $table->foreign('paciente_area_id')->references('id')->on('paciente_area');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('unidad_negocio_area');
    }
};
