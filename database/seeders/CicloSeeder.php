<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('ciclos')->insert([
        ['id_ciclo' => 'DAM001', 'nombre' => 'Desarrollo de Aplicaciones Multiplataforma'],
        ['id_ciclo' => 'ASIR01', 'nombre' => 'Administración de Sistemas Informáticos'],
        ['id_ciclo' => 'SMR01', 'nombre' => 'Sistemas Microinformáticos y Redes'],
        ['id_ciclo' => 'DAW01', 'nombre' => 'Desarrollo de Aplicaciones Web'],
        ['id_ciclo' => 'RI02', 'nombre' => 'Redes y Infraestructuras'],
        ['id_ciclo' => 'MAM02', 'nombre' => 'Mantenimiento de Aplicaciones Multiplataforma'],
        ['id_ciclo' => 'AEM02', 'nombre' => 'Administración y Gestión de Empresas'],
        ['id_ciclo' => 'DAM003', 'nombre' => 'Desarrollo de Aplicaciones Multiplataforma Avanzado'],
        ['id_ciclo' => 'ASIR02', 'nombre' => 'Administración de Sistemas Informáticos Avanzado'],
    ]);
}

}
