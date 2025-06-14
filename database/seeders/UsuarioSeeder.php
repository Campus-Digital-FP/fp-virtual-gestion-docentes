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
            'id_centro' => '22002521',
            'nombre' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' =>  Hash::make('12345678'),
            
        ],
        [
            'id_centro' => '50020125',
            'nombre' => 'Jefe Estudios',
            'email' => 'jefeestudios@gmail.com',
            'password' => Hash::make('12345678'),
            
        ],
    ]);
}

}
