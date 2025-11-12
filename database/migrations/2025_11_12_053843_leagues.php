<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Leagues extends Migration {

    public function up() {

        Schema::create('leagues', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('season');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

        });

    }


    public function down() {
        Schema::dropIfExists('leagues');
    }

}
