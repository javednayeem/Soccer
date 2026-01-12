<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerTransfers extends Migration {

    public function up() {

        Schema::create('player_transfers', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('players');

            $table->integer('from_team_id')->unsigned();
            $table->foreign('from_team_id')->references('team_id')->on('teams');

            $table->integer('to_team_id')->unsigned();
            $table->foreign('to_team_id')->references('team_id')->on('teams');

            $table->enum('transfer_status', ['pending', 'approved', 'rejected']);
            $table->text('transfer_notes')->nullable();

            $table->dateTime('approved_at')->nullable();
            $table->integer('approved_by')->nullable();

            $table->timestamps();

        });

    }


    public function down() {
        Schema::dropIfExists('player_transfers');
    }

}
