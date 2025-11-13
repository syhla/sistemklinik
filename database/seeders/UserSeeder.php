<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
    ['email' => 'resepsionis@klinik.com'],
    [
        'name' => 'Resepsionis Klinik',
        'password' => Hash::make('resepsionis123'),
        'role' => 'resepsionis',
    ]
);

         // Dokter Umum
        User::updateOrCreate(
            ['email' => 'dokterumum@klinik.com'],
            [
                'name' => 'Dokter Umum',
                'password' => Hash::make('dokterumum123'),
                'role' => 'dokter_umum',
            ]
        );

        // Dokter Gigi
        User::updateOrCreate(
            ['email' => 'doktergigi@klinik.com'],
            [
                'name' => 'Dokter Gigi',
                'password' => Hash::make('doktergigi123'),
                'role' => 'dokter_gigi',
            ]
        );

        // Bidan
        User::updateOrCreate(
            ['email' => 'bidan@klinik.com'],
            [
                'name' => 'Bidan',
                'password' => Hash::make('bidan123'),
                'role' => 'bidan',
            ]
        );

        //apoteker
        User::updateOrCreate(
            ['email' => 'apoteker@klinik.com'],
            [
                'name' => 'Apoteker Klinik',
                'password' => Hash::make('apoteker123'),
                'role' => 'apoteker',
            ]
        );


        
    
    }
}
