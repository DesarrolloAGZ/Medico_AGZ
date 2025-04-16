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
      Schema::create('area_subarea', function (Blueprint $table) {
        $table->unsignedBigInteger('paciente_area_id')->comment('Id de la empresa');
        $table->unsignedBigInteger('paciente_subarea_id')->comment('Id de la unidad de negocio');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('paciente_area_id')->references('id')->on('paciente_area');
        $table->foreign('paciente_subarea_id')->references('id')->on('paciente_subarea');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('area_subarea');
    }
};
