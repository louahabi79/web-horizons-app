<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->timestamp('date_proposition_editeur')->nullable();
            $table->text('motif_rejet')->nullable();
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('date_proposition_editeur');
            $table->dropColumn('motif_rejet');
        });
    }
}; 