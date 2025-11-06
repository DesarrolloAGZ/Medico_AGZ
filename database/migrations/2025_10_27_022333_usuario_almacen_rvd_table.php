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
      Schema::create('usuario_almacen_rvd', function (Blueprint $table) {
        $table->unsignedBigInteger('usuario_id')->comment('Id del usuario');
        $table->text('empresa_id')->nullable()->comment('Id de la empresa asignada al usuario relacionada con RVD');
        $table->text('empresa_nombre')->nullable()->comment('Nombre de la empresa asignada al usuario relacionada con RVD');
        $table->text('almacen_id')->nullable()->comment('ID del almacen asignado al usuario relacionado con RVD');
        $table->text('almacen_nombre')->nullable()->comment('Nombre del almacen asignado al usuario relacionado con RVD');
        $table->text('almacen_codigo')->nullable()->comment('Codigo del almacen asignado al usuario relacionado con RVD');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('usuario_id')->references('id')->on('usuario');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('usuario_almacen_rvd');
    }
};
