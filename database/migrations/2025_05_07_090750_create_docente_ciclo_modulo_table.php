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
        Schema::create('docente_modulo_ciclo', function (Blueprint $table) {
            $table->id();
            $table->string('dni'); 
            $table->string('id_ciclo'); 
            $table->string('id_modulo'); 
            $table->string('id_centro'); 
            $table->timestamps();
        
            // Definimos las relaciones de claves foráneas
            $table->foreign('dni')->references('dni')->on('docentes')->onDelete('cascade');
            $table->foreign('id_ciclo')->references('id_ciclo')->on('ciclos')->onDelete('cascade');
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
            $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_modulo_ciclo');
    }
};
