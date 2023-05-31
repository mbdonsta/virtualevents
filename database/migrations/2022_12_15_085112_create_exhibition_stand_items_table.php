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
        Schema::create('exhibition_stand_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_stand_id');
            $table->string('name');
            $table->tinyInteger('item_type')->default(1);
            $table->foreignId('download_file_id')->nullable();
            $table->foreignId('banner_file_id')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('exhibition_stand_items');
    }
};
