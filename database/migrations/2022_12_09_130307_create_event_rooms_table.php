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
        Schema::create('event_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('video_source_id');
            $table->string('name');
            $table->string('embed_id')->nullable();
            $table->tinyInteger('allow_all')->default(1);
            $table->text('slido_url')->nullable();
            $table->foreignId('media_file_id')->nullable();
            $table->tinyInteger('show_banner')->default(0);
            $table->tinyInteger('menu_order');
            $table->tinyInteger('enabled')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('event_rooms');
    }
};
