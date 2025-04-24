<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImparteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('imparte')->insert([
        ['dni' => '12345678A', 'id_modulo' => 'M01', 'id_centro' => 'CEN001'],
        ['dni' => '87654321B', 'id_modulo' => 'M02', 'id_centro' => 'CEN002'],
    ]);
}

}
