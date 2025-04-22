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
        Schema::create('ciclo_modulo', function (Blueprint $table) {
            $table->string('id_ciclo', 6);
            $table->string('id_modulo');
        
            $table->foreign('id_ciclo')->references('id_ciclo')->on('ciclos')->onDelete('cascade');
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
        
            $table->primary(['id_ciclo', 'id_modulo']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_modulo');
    }
};
