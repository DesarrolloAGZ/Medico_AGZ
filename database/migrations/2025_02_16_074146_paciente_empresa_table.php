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
        Schema::create('paciente_empresa', function (Blueprint $table) {
            $table->increments('id')->comment('ID único de la empresa');
            $table->text('nombre')->comment('Nombre de la empresa');
            $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_empresa');
    }
};
