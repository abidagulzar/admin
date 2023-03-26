<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserMessage', function (Blueprint $table) {
            $table->increments('UserMessageId');
            $table->string('Name');
            $table->string('Email');
            $table->string('Website');
            $table->string('Message');

            $table->string('IPAddress');
            $table->string('Location');

            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->integer('IsSuggestion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UserMessage');
    }
}
