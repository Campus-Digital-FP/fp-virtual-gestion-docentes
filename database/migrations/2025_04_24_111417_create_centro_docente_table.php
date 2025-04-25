<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('centro_docente', function (Blueprint $table) {
        $table->string('id_centro');
        $table->string('dni');
        $table->string('email');

        $table->primary(['id_centro', 'dni']);

        $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('cascade');
        $table->foreign('dni')->references('dni')->on('docentes')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_docente');
    }
};
