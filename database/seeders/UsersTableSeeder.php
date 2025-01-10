<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     [
        //         'nom' => 'Test User 1',
        //         'email' => 'test1@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Invité',
        //         'date_inscription' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nom' => 'Test User 2',
        //         'email' => 'test2@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Abonné',
        //         'date_inscription' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],

        // ]);
    }
}
