<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('first_name'); // Prenom
        $table->string('last_name'); // Nom
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('role')->default('user'); // Role
        $table->integer('subscriber_count')->default(0); // NombreAbonnes
        $table->integer('article_count')->default(0); // NombreArticles
        $table->float('average_rating')->nullable(); // MoyenneNotes
        $table->unsignedBigInteger('theme_id')->nullable(); // ID_Theme
        $table->date('registration_date'); // DateInscription
        $table->rememberToken();
        $table->timestamps();

        // Add foreign key constraint
        $table->foreign('theme_id')->references('id')->on('themes');
    });
}

public function down()
{
    Schema::dropIfExists('users');
}
};
