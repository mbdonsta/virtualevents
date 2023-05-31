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
        Schema::create('event_posters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('poster_image_id')->nullable();
            $table->string('author');
            $table->text('description');
            $table->string('youtube_url')->nullable();
            $table->tinyInteger('menu_order')->default(0);
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
        Schema::dropIfExists('event_posters');
    }
};
