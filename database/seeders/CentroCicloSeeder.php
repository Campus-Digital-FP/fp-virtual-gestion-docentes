<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('centro_ciclo')->insert([
        
        // Ciclos para el Centro CEN001
        ['id_centro' => 'CEN001', 'id_ciclo' => 'DAM001'],
        ['id_centro' => 'CEN001', 'id_ciclo' => 'SMR01'],
        ['id_centro' => 'CEN001', 'id_ciclo' => 'DAW01'],
        ['id_centro' => 'CEN001', 'id_ciclo' => 'RI02'],
        ['id_centro' => 'CEN001', 'id_ciclo' => 'MAM02'],

        // Ciclos para el Centro CEN002
        ['id_centro' => 'CEN002', 'id_ciclo' => 'ASIR01'],
        ['id_centro' => 'CEN002', 'id_ciclo' => 'DAW01'],
        ['id_centro' => 'CEN002', 'id_ciclo' => 'RI02'],
        ['id_centro' => 'CEN002', 'id_ciclo' => 'SMR01'],
        ['id_centro' => 'CEN002', 'id_ciclo' => 'AEM02'],
    ]);
}

}
