<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ThemesTableSeeder::class,
            ArticlesTableSeeder::class,
            SubscriptionsSeeder::class,
            NavigationHistorySeeder::class,
        ]);
    }
}

