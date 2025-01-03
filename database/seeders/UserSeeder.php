<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'John', // Prenom
            'last_name' => 'Doe', // Nom
            'email' => 'john.doe@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // MotDePasse
            'role' => 'admin', // Type_Utilisateur
            'subscriber_count' => 100, // NombreAbonnes
            'article_count' => 10, // NombreArticles
            'average_rating' => 4.5, // MoyenneNotes
            'theme_id' => 1, // ID_Theme
            'registration_date' => now(), // DateInscription
            'remember_token' => \Str::random(10),
        ]);

        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscriber_count' => 50,
            'article_count' => 5,
            'average_rating' => 4.0,
            'theme_id' => 2,
            'registration_date' => now(),
            'remember_token' => \Str::random(10),
        ]);
    }
}
