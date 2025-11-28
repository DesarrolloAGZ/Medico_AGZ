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
        Schema::table('usuario', function (Blueprint $table) {
          $table->unsignedBigInteger('catalogo_ranchos_agrizar_id')->nullable()->comment('ID del catalogo de ranchos para identificar donde se ubica el usuario');

          $table->foreign('catalogo_ranchos_agrizar_id')->references('id')->on('catalogo_ranchos_agrizar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
          $table->dropForeign(['catalogo_ranchos_agrizar_id']);
          $table->dropColumn('catalogo_ranchos_agrizar_id');
        });
    }
};
