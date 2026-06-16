<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->id();
            $table->integer('martial_id')->nullable();
            $table->integer('tournament_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('red_name')->nullable();
            $table->string('red_club')->nullable();
            $table->string('red_photo')->nullable();
            $table->string('blue_name')->nullable();
            $table->string('blue_club')->nullable();
            $table->string('blue_photo')->nullable();
            $table->integer('winner')->nullable();
            $table->integer('disqualified')->nullable();
            $table->integer('match_number')->nullable();
            $table->integer('play_now')->nullable();
            $table->integer('order_code')->nullable();
            $table->integer('actived')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charts');
    }
};
