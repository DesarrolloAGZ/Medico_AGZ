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
        Schema::table('receta_medicamento', function (Blueprint $table) {
          $table->text('abreviatura')->nullable()->comment('Abreviatura de la unidad de medida del medicamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumn('receta_medicamento', function (Blueprint $table) {
          $table->dropColumn('abreviatura');
        });
    }
};
