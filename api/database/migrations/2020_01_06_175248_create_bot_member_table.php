<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotMemberTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_member', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->json('last_data')->nullable();

            $table->unsignedBigInteger('member_id');
            $table->unsignedInteger('bot_id');

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('bot_id')
                  ->references('id')
                  ->on('bots')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_member');
    }
}
