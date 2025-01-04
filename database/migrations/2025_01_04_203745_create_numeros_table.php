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
    Schema::create('numeros', function (Blueprint $table) {
        $table->id('Id_numero');
        $table->string('titre_numero');
        $table->date('date_publication');
        $table->enum('statut', ['Brouillon', 'Publié', 'Désactivé']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numeros');
    }
};
