<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['user' => 'admin'], // para evitar duplicados si corres varias veces
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
