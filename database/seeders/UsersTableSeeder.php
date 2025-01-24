<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Créer un éditeur
        User::create([
            'nom' => 'admin global',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Éditeur',
            'date_inscription' => now(),
        ]);
        User::create([
            'nom' => 'user user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Abonné',
            'date_inscription' => now(),
        ]);
        User::create([
            'nom' => 'Responsable theme',
            'email' => 'responsable@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Responsable de thème',
            'statut' => 'actif',
            'date_inscription' => now(),
        ]);

        // Créer quelques abonnés
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'nom' => "User $i",
                'email' => "user$i@gmail.com",
                'password' => Hash::make('12345678'),
                'role' => 'Abonné',
                'date_inscription' => now(),
            ]);
        }
    }
}
