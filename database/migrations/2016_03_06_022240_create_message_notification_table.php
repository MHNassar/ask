<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('isSeen')->default(false);
            $table->boolean('isSender')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'message_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_notifications');
    }
}
