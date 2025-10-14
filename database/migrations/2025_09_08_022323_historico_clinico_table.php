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
      Schema::create('historico_clinico', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del historico clinico');
        $table->text('tipo_registro')->nullable()->comment('Tipo de registro del historico clinico');
        $table->unsignedBigInteger('elaborado_por_usuario_id')->nullable()->comment('Id del usuario que elaboro el historico clinico');
        $table->text('curp')->nullable()->comment('CURP de la persona perteneciente del historico clinico');
        $table->date('fecha_nacimiento')->nullable()->comment('Fecha de nacimiento de la persona perteneciente del historico clinico');
        $table->integer('edad')->nullable()->comment('Edad de la persona perteneciente del historico clinico');
        $table->bigInteger('celular')->nullable()->comment('Celular de la persona perteneciente del historico clinico');
        $table->text('nombre')->nullable()->comment('Nombre de la persona perteneciente del historico clinico');
        $table->text('apellido_paterno')->nullable()->comment('Apellido paterno de la persona perteneciente del historico clinico');
        $table->text('apellido_materno')->nullable()->comment('Apellido materno de la persona perteneciente del historico clinico');
        $table->text('genero')->nullable()->comment('Genero de la persona perteneciente del historico clinico');
        $table->text('estado_civil')->nullable()->comment('Estado civil de la persona perteneciente del historico clinico');
        $table->integer('hijos')->nullable()->comment('Hijos de la persona perteneciente del historico clinico');
        $table->text('grupo_sanguineo')->nullable()->comment('Tipo de sangre de la persona perteneciente del historico clinico');
        $table->text('escolaridad')->nullable()->comment('Escolaridad de la persona perteneciente del historico clinico');
        $table->text('profesion_oficio')->nullable()->comment('Profesion de la persona perteneciente del historico clinico');
        $table->text('domicilio')->nullable()->comment('Domicilio de la persona perteneciente del historico clinico');
        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();

        $table->foreign('elaborado_por_usuario_id')->references('id')->on('usuario');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('historico_clinico');
    }
};
