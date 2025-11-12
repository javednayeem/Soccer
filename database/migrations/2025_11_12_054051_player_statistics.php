<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerStatistics extends Migration {

    public function up() {

        Schema::create('player_statistics', function (Blueprint $table) {

            $table->id();

            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('season');
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
            $table->integer('minutes_played')->default(0);
            $table->integer('appearances')->default(0);
            $table->timestamps();

            $table->unique(['player_id', 'league_id', 'season']);

        });

    }

    public function down() {
        Schema::dropIfExists('player_statistics');
    }

}
