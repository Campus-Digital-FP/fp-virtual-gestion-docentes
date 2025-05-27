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
        Schema::create('tutores', function (Blueprint $table) {
            $table->id(); 
            $table->string('id_centro', 50);
            $table->string('id_ciclo', 50);
            $table->string('dni');
        
            $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('cascade');
            $table->foreign('id_ciclo')->references('id_ciclo')->on('ciclos')->onDelete('cascade'); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutores');
    }
};
