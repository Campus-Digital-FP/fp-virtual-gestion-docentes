<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   

public function run()
{
    DB::table('usuario')->insert([
        [
            'id_centro' => '50020125',
            'nombre' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' =>  Hash::make('ZL3OkiDgON8Ya0M4Uj36'),
            
        ],
        [
            'id_centro' => '22002491',
            'nombre'    => 'Jefatura de Montearagón',
            'email'     => 'cpifpmontearagon@educa.aragon.es',
            'password'  => Hash::make('22002491'),
        ],
        [
            'id_centro' => '22002521',
            'nombre'    => 'Jefatura de Sierra De Guara',
            'email'     => 'iessguhuesca@educa.aragon.es',
            'password'  => Hash::make('22002521'),
        ],
        [
            'id_centro' => '22004611',
            'nombre'    => 'Jefatura de Martínez Vargas',
            'email'     => 'iesmvbarbastro@educa.aragon.es',
            'password'  => Hash::make('22004611'),
        ],
        [
            'id_centro' => '22010712',
            'nombre'    => 'Jefatura de Pirámide',
            'email'     => 'cpifppiramide@educa.aragon.es',
            'password'  => Hash::make('22010712'),
        ],
        [
            'id_centro' => '44003028',
            'nombre'    => 'Jefatura de De San Blas',
            'email'     => 'ifpeteruel@educa.aragon.es',
            'password'  => Hash::make('44003028'),
        ],
        [
            'id_centro' => '44003211',
            'nombre'    => 'Jefatura de Santa Emerenciana',
            'email'     => 'iessemteruel@educa.aragon.es',
            'password'  => Hash::make('44003211'),
        ],
        [
            'id_centro' => '44003235',
            'nombre'    => 'Jefatura de Vega Del Turia',
            'email'     => 'iesvtteruel@educa.aragon.es',
            'password'  => Hash::make('44003235'),
        ],
        [
            'id_centro' => '44010537',
            'nombre'    => 'Jefatura de Bajo Aragón',
            'email'     => 'cpifpbajoaragon@educa.aragon.es',
            'password'  => Hash::make('44010537'),
        ],
        [
            'id_centro' => '50008460',
            'nombre'    => 'Jefatura de Luis Buñuel',
            'email'     => 'ieslbuzaragoza@educa.aragon.es',
            'password'  => Hash::make('50008460'),
        ],
        [
            'id_centro' => '50008642',
            'nombre'    => 'Jefatura de María Moliner',
            'email'     => 'iesmmozaragoza@educa.aragon.es',
            'password'  => Hash::make('50008642'),
        ],
        [
            'id_centro' => '50009348',
            'nombre'    => 'Jefatura de Avempace',
            'email'     => 'iesavempace@educa.aragon.es',
            'password'  => Hash::make('50009348'),
        ],
        [
            'id_centro' => '50009567',
            'nombre'    => 'Jefatura de Río Gállego',
            'email'     => 'iesrgazaragoza@educa.aragon.es',
            'password'  => Hash::make('50009567'),
        ],
        [
            'id_centro' => '50010144',
            'nombre'    => 'Jefatura de Pablo Serrano',
            'email'     => 'iespsezaragoza@educa.aragon.es',
            'password'  => Hash::make('50010144'),
        ],
        [
            'id_centro' => '50010156',
            'nombre'    => 'Jefatura de Miralbueno',
            'email'     => 'iesmirzaragoza@educa.aragon.es',
            'password'  => Hash::make('50010156'),
        ],
        [
            'id_centro' => '50010314',
            'nombre'    => 'Jefatura de Los Enlaces',
            'email'     => 'cpilosenlaces@educa.aragon.es',
            'password'  => Hash::make('50010314'),
        ],
        [
            'id_centro' => '50010511',
            'nombre'    => 'Jefatura de Tiempos Modernos',
            'email'     => 'iestiemposmodernos@educa.aragon.es',
            'password'  => Hash::make('50010511'),
        ],
        [
            'id_centro' => '50018829',
            'nombre'    => 'Jefatura de Corona De Aragón',
            'email'     => 'cpifpcorona@educa.aragon.es',
            'password'  => Hash::make('50018829'),
        ],
        [
            'id_centro' => '50020125',
            'nombre'    => 'Jefatura de Campus Digital',
            'email'     => 'campusdigital@aragon.es',
            'password'  => Hash::make('50020125'),
        ],
    ]);
}

}
