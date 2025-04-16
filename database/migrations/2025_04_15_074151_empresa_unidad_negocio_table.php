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
      Schema::create('empresa_unidad_negocio', function (Blueprint $table) {
        $table->unsignedBigInteger('paciente_empresa_id')->comment('Id de la empresa');
        $table->unsignedBigInteger('paciente_unidad_negocio_id')->comment('Id de la unidad de negocio');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('paciente_empresa_id')->references('id')->on('paciente_empresa');
        $table->foreign('paciente_unidad_negocio_id')->references('id')->on('paciente_unidad_negocio');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('empresa_unidad_negocio');
    }
};
