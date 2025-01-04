<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemeIdToArticlesTable extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add the theme_id column as a foreign key
            $table->foreignId('theme_id')
                  ->nullable() // Allow NULL values (if an article doesn't have a theme)
                  ->constrained('themes') // References the themes table
                  ->onDelete('set null'); // Set theme_id to NULL if the theme is deleted
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['theme_id']);
            // Drop the theme_id column
            $table->dropColumn('theme_id');
        });
    }
}
