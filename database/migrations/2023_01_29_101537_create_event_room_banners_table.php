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
        Schema::create('event_room_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_room_id');
            $table->tinyInteger('banner_type');
            $table->foreignId('banner_image_id');
            $table->foreignId('download_file_id')->nullable();
            $table->string('banner_redirect_url')->nullable();
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
        Schema::dropIfExists('event_room_banners');
    }
};
