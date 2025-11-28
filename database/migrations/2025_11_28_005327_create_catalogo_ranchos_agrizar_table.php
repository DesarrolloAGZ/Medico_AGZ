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
        Schema::create('catalogo_ranchos_agrizar', function (Blueprint $table) {
          $table->increments('id')->comment('ID único del catalogo de ranchos agrizar');
          $table->text('nombre')->comment('Nombre del rancho agrizar');
          $table->text('sufijo')->comment('Sufijo del rancho agrizar');
          $table->text('centro_costo')->comment('Centro de costo del rancho agrizar');
          $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_ranchos_agrizar');
    }
};
