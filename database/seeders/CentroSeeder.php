<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('centros')->insert([
        ['id_centro' => '22002491', 'nombre' => 'Montearagón'],
        ['id_centro' => '22002521', 'nombre' => 'Sierra De Guara'],
        ['id_centro' => '22004611', 'nombre' => 'Martínez Vargas'],
        ['id_centro' => '22010712', 'nombre' => 'Pirámide'],
        ['id_centro' => '44003028', 'nombre' => 'De San Blas'],
        ['id_centro' => '44003211', 'nombre' => 'Santa Emerenciana'],
        ['id_centro' => '44003235', 'nombre' => 'Vega Del Turia'],
        ['id_centro' => '44010537', 'nombre' => 'Bajo Aragón'],
        ['id_centro' => '50008460', 'nombre' => 'Luis Buñuel'],
        ['id_centro' => '50008642', 'nombre' => 'María Moliner'],
        ['id_centro' => '50009348', 'nombre' => 'Avempace'],
        ['id_centro' => '50009567', 'nombre' => 'Río Gállego'],
        ['id_centro' => '50010144', 'nombre' => 'Pablo Serrano'],
        ['id_centro' => '50010156', 'nombre' => 'Miralbueno'],
        ['id_centro' => '50010314', 'nombre' => 'Los Enlaces'],
        ['id_centro' => '50010511', 'nombre' => 'Tiempos Modernos'],
        ['id_centro' => '50018829', 'nombre' => 'Corona De Aragón'],
        ['id_centro' => '50020125', 'nombre' => 'Campus Digital'],
    ]);
}

}
