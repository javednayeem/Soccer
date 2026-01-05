<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Events extends Migration {

    public function up() {

        Schema::create('events', function (Blueprint $table) {

            $table->increments('event_id');

            $table->string('event_name');
            $table->longText('event_description')->nullable();
            $table->string('event_image')->default('default_event.jpg');
            $table->date('event_date');

            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('default_event', ['0', '1'])->default('0');
            $table->enum('featured_event', ['0', '1'])->default('0');

            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();

        });

    }

    public function down() {
        Schema::dropIfExists('events');
    }

}
