<?php

namespace Database\Seeders;

use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        CentroSeeder::class,
        CicloSeeder::class,
        ModuloSeeder::class,
        CentroCicloSeeder::class,
        CicloModuloSeeder::class,
        UsuarioSeeder::class,
        DocenteSeeder::class,
        CoordinadorSeeder::class,
        TutorSeeder::class,
        ImparteSeeder::class,
    ]);
}

}
