<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MatchEvents extends Migration {

    public function up() {

        Schema::create('match_events', function (Blueprint $table) {

            $table->id();

            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            // own_goal: team_id is the team of the player who scored it, the goal itself counts for the opponent
            $table->enum('type', ['goal', 'assist', 'yellow_card', 'red_card', 'substitution_in', 'substitution_out', 'own_goal']);

            // Nullable: the admin "quick goal" flow and addMatchEvent() (minute validation is disabled) send no minute
            $table->integer('minute')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

        });

    }

    public function down() {
        Schema::dropIfExists('match_events');
    }

}
