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
        ['id_centro' => 'CEN001', 'nombre' => 'IES Los Enlaces'],
        ['id_centro' => 'CEN002', 'nombre' => 'IES Sierra de Guara'],
    ]);
}

}
