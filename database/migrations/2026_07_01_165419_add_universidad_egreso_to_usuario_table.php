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
      $table->text('universidad_egreso')->nullable()->comment('Nombre de la universidad de egreso del medico');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('usuario', function (Blueprint $table) {
      $table->dropColumn('universidad_egreso');
    });
  }
};
