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
            'nom' => 'John Editor',
            'email' => 'editor@techhorizons.com',
            'password' => Hash::make('password123'),
            'role' => 'Éditeur',
            'date_inscription' => now(),
        ]);
        User::create([
            'nom' => 'hamza hamza',
            'email' => 'hamza@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Abonné',
            'date_inscription' => now(),
        ]);
        User::create([
            'nom' => 'Responsable Test',
            'email' => 'responsable@test.com',
            'password' => Hash::make('password'),
            'role' => 'Responsable de thème',
            'statut' => 'actif',
            'date_inscription' => now(),
        ]);

        // Créer quelques abonnés
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'nom' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('12345678'),
                'role' => 'Abonné',
                'date_inscription' => now(),
            ]);
        }
    }
}
