<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcludeTrafficIP extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ExcludeTrafficIP', function (Blueprint $table) {

            $table->increments('ExcludeTrafficIPID');
            $table->string('Title');
            $table->string('IP');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
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
        Schema::dropIfExists('ExcludeTrafficIP');
    }
}
