<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('modulos')->insert([
            ['id_modulo' => 'M01', 'nombre' => 'Programación'],
            ['id_modulo' => 'M02', 'nombre' => 'Bases de Datos'],
        ]);
    }
    
}
