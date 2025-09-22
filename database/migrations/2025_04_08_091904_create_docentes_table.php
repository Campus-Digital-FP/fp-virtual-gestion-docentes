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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id(); 
            $table->string('dni')->unique(); 
            $table->string('nombre'); 
            $table->string('apellido'); 
            $table->string('email_virtual')->unique();
            $table->boolean('de_baja')->default(false);
            // TODO $table->boolean('creado_google_workspace')->default(false);
            // TODO $table->boolean('creado_moodle')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
