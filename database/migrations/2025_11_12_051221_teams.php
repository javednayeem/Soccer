<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Teams extends Migration {

    public function up() {

        Schema::create('teams', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('short_name')->nullable();

            $table->string('team_manager');
            $table->string('manager_email')->nullable();
            $table->string('manager_phone')->nullable();

            $table->string('logo')->default('default_team.png');
            $table->string('team_image')->default('default_team_image.png');

            $table->text('note')->nullable();
            $table->string('payment_reference_number')->nullable();

            $table->enum('active', ['0', '1'])->default('1');
            $table->enum('team_status', ['pending', 'approved', 'rejected', 'inactive'])->default('pending');

            $table->timestamps();

        });

    }


    public function down() {
        Schema::dropIfExists('teams');
    }

}
