<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    public function run()
    {
        $themes = [
            [
                'nom_theme' => 'Intelligence Artificielle',
                'description' => 'Tout sur l\'IA et le machine learning'
            ],
            [
                'nom_theme' => 'Cybersécurité',
                'description' => 'Sécurité informatique et protection des données'
            ],
            [
                'nom_theme' => 'Internet des Objets',
                'description' => 'IoT et objets connectés'
            ],
            [
                'nom_theme' => 'Réalité Virtuelle',
                'description' => 'VR, AR et technologies immersives'
            ]
        ];

        // foreach ($themes as $theme) {
        //     Theme::create($theme);
        // }
    }
} 