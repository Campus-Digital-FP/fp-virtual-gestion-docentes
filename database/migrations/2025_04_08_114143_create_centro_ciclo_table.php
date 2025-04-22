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
        Schema::create('centro_ciclo', function (Blueprint $table) {
            $table->string('id_centro', 12);
            $table->string('id_ciclo', 6);
        
            $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('cascade');
            $table->foreign('id_ciclo')->references('id_ciclo')->on('ciclos')->onDelete('cascade');
        
            $table->primary(['id_centro', 'id_ciclo']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_ciclo');
    }
};
