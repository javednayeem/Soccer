<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contributions extends Migration {

    public function up() {

        Schema::create('contributions', function (Blueprint $table) {

            $table->increments('contribution_id');

            $table->bigInteger('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('players');

            $table->double('amount')->default(0);

            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });

    }

    public function down() {
        Schema::dropIfExists('contributions');
    }
}
