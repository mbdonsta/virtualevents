<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('event_user_id');
            $table->tinyInteger('activity');
            $table->foreignId('model_id')->default(0);
            $table->integer('activity_value')->default(0);
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
        Schema::dropIfExists('event_user_activities');
    }
};