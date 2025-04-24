<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CicloModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ciclo_modulo')->insert([
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M01'],
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M02'],
        ]);
    }
    
}
