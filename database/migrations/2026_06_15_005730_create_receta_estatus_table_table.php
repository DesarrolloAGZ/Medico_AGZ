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
      Schema::create('receta_estatus', function (Blueprint $table) {
        $table->increments('id')->comment('ID del estatus de la receta');
        $table->text('nombre')->comment('Nombre del estatus');
        $table->text('icono')->comment('Icono del estatus');
        $table->text('clase')->comment('Clase del estatus');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_estatus');
    }
};
