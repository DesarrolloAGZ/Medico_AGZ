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
        Schema::create('paciente_tipo_visita', function (Blueprint $table) {
            $table->increments('id')->comment('ID único del tipo de visita por la que fue el paciente');
            $table->text('nombre')->comment('Nombre del tipo de motivo de visita');
            $table->text('descripcion')->comment('Descripcion del tipo de motivo de visita');
            $table->text('icono')->comment('Icono del motivo de visita');
            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_tipo_visita');
    }
};
