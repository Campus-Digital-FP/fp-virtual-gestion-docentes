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
            ['id_modulo' => 'M03', 'nombre' => 'Sistemas Operativos'],
            ['id_modulo' => 'M04', 'nombre' => 'Lenguajes de marcas y sistemas de gestión de información'],
            ['id_modulo' => 'M05', 'nombre' => 'Entornos de desarrollo'],
            ['id_modulo' => 'M06', 'nombre' => 'Redes locales'],
            ['id_modulo' => 'M07', 'nombre' => 'Seguridad informática'],
            ['id_modulo' => 'M08', 'nombre' => 'Administración de sistemas operativos'],
            ['id_modulo' => 'M09', 'nombre' => 'Desarrollo web en entorno cliente'],
            ['id_modulo' => 'M10', 'nombre' => 'Desarrollo web en entorno servidor'],
            ['id_modulo' => 'M11', 'nombre' => 'Diseño de interfaces'],
            ['id_modulo' => 'M12', 'nombre' => 'Implantación de aplicaciones web'],
            ['id_modulo' => 'M13', 'nombre' => 'Empresa e iniciativa emprendedora'],
            ['id_modulo' => 'M14', 'nombre' => 'Formación y orientación laboral'],
        ]);
    }
    
}
