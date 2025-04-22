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
        Schema::create('imparte', function (Blueprint $table) {
            $table->string('dni');
            $table->string('id_modulo');
            $table->string('id_centro', 12);
        
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
            $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('cascade');
        
            $table->primary(['dni', 'id_modulo', 'id_centro']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imparte');
    }
};
