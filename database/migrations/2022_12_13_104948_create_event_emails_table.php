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
        Schema::create('event_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->string('email_address');
            $table->string('sender');
            $table->string('reply_to');
            $table->string('subject');
            $table->text('text')->nullable();
            $table->text('email_styles')->nullable();
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
        Schema::dropIfExists('event_emails');
    }
};
