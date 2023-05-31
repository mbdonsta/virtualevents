<?php

use App\Models\Event;
use App\Models\Plan;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('plan_id')->default(Plan::BASIC);
            $table->string('title');
            $table->tinyInteger('title_option')->default(Event::TITLE_OPTION_SHOW_TITLE);
            $table->string('slug');
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('media_file_id')->nullable();
            $table->dateTime('begin_datetime');
            $table->dateTime('end_datetime');
            $table->string('location')->nullable();
            $table->tinyInteger('language_id');
            $table->tinyInteger('is_public')->default(0);
            $table->tinyInteger('enabled')->default(0);
            $table->text('design_settings')->nullable();
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
        Schema::dropIfExists('events');
    }
};
