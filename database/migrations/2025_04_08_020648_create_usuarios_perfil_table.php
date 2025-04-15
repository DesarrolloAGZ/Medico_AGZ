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
      Schema::create('usuario_perfil', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del perfil del usuario en el sistema');
        $table->text('nombre')->comment('Nombre del perfil del usuario');
        $table->string('descripcion')->nullable()->comment('Descripcion del perfil del usuario');

        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_perfil');
    }
};
