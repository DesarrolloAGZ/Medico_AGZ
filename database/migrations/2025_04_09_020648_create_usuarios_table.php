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
      Schema::create('usuario', function (Blueprint $table) {
        $table->increments('id')->comment('ID único del usuario en el sistema');
        $table->text('username')->comment('Username del usuario');
        $table->text('nombre')->comment('Nombre del usuario');
        $table->text('apellido_paterno')->comment('Apellido paterno del usuario');
        $table->text('apellido_materno')->comment('Apellido materno del usuario');
        $table->unsignedBigInteger('usuario_perfil_id')->comment('ID del paciente');
        $table->string('cedula_profesional')->comment('Cedula profesional (C.P.)');
        $table->string('registro_ssa')->comment('Registro ante la Secretaria de Salud (REG.SSA.)');
        $table->string('correo')->comment('Correo del usuario');
        $table->string('password')->comment('Contraseña del usuario');

        $table->tinyInteger('borrado')->default('0')->comment('Borrado lógico 1=>Si 0=>No');
        $table->timestamps();
        $table->foreign('usuario_perfil_id')->references('id')->on('usuario_perfil');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
