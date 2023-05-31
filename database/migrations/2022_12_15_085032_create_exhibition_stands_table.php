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
        Schema::create('exhibition_stands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('exhibition_group_id')->default(0);
            $table->string('name');
            $table->foreignId('media_file_id')->nullable();
            $table->foreignId('featured_image_id')->nullable();
            $table->tinyInteger('layout_style')->default(1);
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
        Schema::dropIfExists('exhibition_stands');
    }
};
