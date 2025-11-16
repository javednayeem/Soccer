<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Players extends Migration {

    public function up() {

        Schema::create('players', function (Blueprint $table) {

            $table->id();

            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('nationality');
            $table->string('position');
            $table->integer('jersey_number')->nullable();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->date('date_of_birth');
            $table->string('photo')->default('default_player.jpg');
            $table->enum('player_status', ['0', '1'])->default('1');

            $table->timestamps();

        });

    }

    public function down() {
        Schema::dropIfExists('players');
    }

}
