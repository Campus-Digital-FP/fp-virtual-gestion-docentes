<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('id_centro', 50)->nullable();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};

