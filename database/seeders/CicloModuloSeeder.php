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
            // DAM - Desarrollo de Aplicaciones Multiplataforma
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M01'], // Programación
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M02'], // Bases de Datos
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M05'], // Entornos de desarrollo
            ['id_ciclo' => 'DAM001', 'id_modulo' => 'M11'], // Diseño de interfaces

            // DAW - Desarrollo de Aplicaciones Web
            ['id_ciclo' => 'DAW01', 'id_modulo' => 'M01'],
            ['id_ciclo' => 'DAW01', 'id_modulo' => 'M02'],
            ['id_ciclo' => 'DAW01', 'id_modulo' => 'M09'], // Desarrollo web en entorno cliente
            ['id_ciclo' => 'DAW01', 'id_modulo' => 'M10'], // Desarrollo web en entorno servidor
            ['id_ciclo' => 'DAW01', 'id_modulo' => 'M12'], // Implantación de aplicaciones web

            // SMR - Sistemas Microinformáticos y Redes
            ['id_ciclo' => 'SMR01', 'id_modulo' => 'M03'],
            ['id_ciclo' => 'SMR01', 'id_modulo' => 'M06'],
            ['id_ciclo' => 'SMR01', 'id_modulo' => 'M07'],

            // ASIR - Administración de Sistemas Informáticos
            ['id_ciclo' => 'ASIR01', 'id_modulo' => 'M03'],
            ['id_ciclo' => 'ASIR01', 'id_modulo' => 'M06'],
            ['id_ciclo' => 'ASIR01', 'id_modulo' => 'M08'],
            ['id_ciclo' => 'ASIR01', 'id_modulo' => 'M07'],

            // RI - Redes e Infraestructuras
            ['id_ciclo' => 'RI02', 'id_modulo' => 'M06'],
            ['id_ciclo' => 'RI02', 'id_modulo' => 'M07'],

            // MAM - Mantenimiento de Aplicaciones Multiplataforma
            ['id_ciclo' => 'MAM02', 'id_modulo' => 'M01'],
            ['id_ciclo' => 'MAM02', 'id_modulo' => 'M05'],
            ['id_ciclo' => 'MAM02', 'id_modulo' => 'M11'],

            // AEM - Administración y Gestión de Empresas
            ['id_ciclo' => 'AEM02', 'id_modulo' => 'M13'], // Empresa e iniciativa emprendedora
            ['id_ciclo' => 'AEM02', 'id_modulo' => 'M14'], // FOL

            // Ciclos avanzados
            ['id_ciclo' => 'DAM003', 'id_modulo' => 'M01'],
            ['id_ciclo' => 'DAM003', 'id_modulo' => 'M02'],
            ['id_ciclo' => 'ASIR02', 'id_modulo' => 'M08'],
            ['id_ciclo' => 'ASIR02', 'id_modulo' => 'M07'],
        ]);
    }
    
}
