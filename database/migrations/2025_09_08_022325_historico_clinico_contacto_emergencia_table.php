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
      Schema::create('historico_clinico_contacto_emergencia', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del step contacto de emergencia');
        $table->unsignedBigInteger('historico_clinico_id')->comment('Id del historico clinico');
        $table->text('nombre')->nullable()->comment('Nombre del contacto de emergencia');
        $table->text('parentesco')->nullable()->comment('Parentesco del contacto de emergencia');
        $table->bigInteger('celular')->nullable()->comment('Celular del contacto de emergencia');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('historico_clinico_id')->references('id')->on('historico_clinico');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('historico_clinico_contacto_emergencia');
    }
};
