<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        // Créer quelques articles pour chaque thème
        for ($theme_id = 1; $theme_id <= 8; $theme_id++) {
            for ($i = 1; $i <= 3; $i++) {
                Article::create([
                    'titre' => "Article $i du thème $theme_id",
                    'contenu' => "Contenu de l'article $i du thème $theme_id...",
                    'date_publication' => now(),
                    'date_proposition' => now(), 
                    'statut' => 'publié',
                    'image_couverture' => 'image.jpg', // ImageCouverture
                    'temps_lecture' => 10, // TempsLecture
                    'vues' => 100, // Vues
                    'theme_id' => $theme_id,
                    'user_id' => rand(2, 6), // ID des abonnés
                ]);
            }
        }
    }
} 