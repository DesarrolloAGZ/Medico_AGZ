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
      Schema::create('paciente', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del empleado / paciente');
        $table->bigInteger('gafete')->comment('Numero unico del empleado / paciente');
        $table->text('nombre')->comment('Nombre del empleado / paciente');
        $table->text('apellido_paterno')->comment('Apellido paterno del empleado / paciente');
        $table->text('apellido_materno')->comment('Apellido materno del empleado / paciente');
        $table->text('genero')->comment('Genero del empleado / paciente');
        $table->bigInteger('celular')->nullable()->comment('Numero telefonico del empleado / paciente');
        $table->integer('edad')->comment('Edad del empleado / paciente');
        $table->text('curp')->comment('CURP del empleado / paciente');
        $table->unsignedBigInteger('paciente_empresa_id')->comment('Unidad de la empresa del empleado / paciente');
        $table->unsignedBigInteger('paciente_unidad_negocio_id')->comment('Unidad de negocio del empleado / paciente');
        $table->unsignedBigInteger('paciente_area_id')->comment('Area del empleado / paciente');
        $table->unsignedBigInteger('paciente_subarea_id')->comment('Subarea del empleado / paciente');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('paciente_empresa_id')->references('id')->on('paciente_empresa');
        $table->foreign('paciente_unidad_negocio_id')->references('id')->on('paciente_unidad_negocio');
        $table->foreign('paciente_area_id')->references('id')->on('paciente_area');
        $table->foreign('paciente_subarea_id')->references('id')->on('paciente_subarea');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('paciente');
    }
};
