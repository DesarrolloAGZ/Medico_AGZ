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
        Schema::create('paciente_unidad_negocio', function (Blueprint $table) {
            $table->increments('id')->comment('ID único de la unidad de negocio');
            $table->text('nombre')->comment('Nombre de la unidad de negocio');
            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_unidad_negocio');
    }
};
