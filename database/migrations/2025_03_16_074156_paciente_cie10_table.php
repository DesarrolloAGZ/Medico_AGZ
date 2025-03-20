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
        Schema::create('paciente_cie', function (Blueprint $table) {
            $table->increments('id')->comment('ID único del cie 10');
            $table->text('codigo')->comment('Codigo del cie 10');
            $table->text('descripcion')->comment('Descripcion del cie 10');

            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_cie');
    }
};
