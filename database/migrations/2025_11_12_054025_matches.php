<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Matches extends Migration {

    public function up() {

        Schema::create('matches', function (Blueprint $table) {

            $table->id();

            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->dateTime('match_date');
            $table->string('venue');
            $table->enum('status', ['scheduled', 'live', 'finished', 'postponed', 'cancelled'])->default('scheduled');
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->string('match_week')->nullable();

            $table->foreignId('man_of_the_match')->nullable()->constrained('players')->onDelete('set null');

            $table->timestamps();

        });

    }

    public function down() {
        Schema::dropIfExists('matches');
    }

}
