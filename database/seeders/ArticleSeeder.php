<?php
namespace Database\Seeders;
use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'title' => 'Introduction to Laravel', // Titre
            'content' => 'Laravel is a PHP framework...', // Content
            'publication_date' => now(), // DatePublication
            'status' => 'published', // Etat
        ]);

        Article::create([
            'title' => 'Advanced Laravel Techniques',
            'content' => 'In this article, we will explore...',
            'publication_date' => now(),
            'status' => 'draft',
        ]);
    }
}
