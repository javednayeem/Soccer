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
            $table->string('last_name');
            $table->string('nationality');
            $table->string('position');
            $table->integer('jersey_number')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->date('date_of_birth');
            $table->string('photo')->nullable();

            $table->timestamps();

        });

    }

    public function down() {
        Schema::dropIfExists('players');
    }

}
