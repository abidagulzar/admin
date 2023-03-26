<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Subscribe', function (Blueprint $table) {
            $table->increments('SubscribeId');
            $table->string('Email');
            $table->string('Reason');
            $table->integer('IsActive');
            $table->string('IPAddress');
            $table->string('Location');
            $table->date('CreateDate');
            $table->date('UpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Subscribe');
    }
}
