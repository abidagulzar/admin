<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StoreVisitor', function (Blueprint $table) {
            $table->increments('StoreVisitorId');
            $table->integer('StoreId');
            $table->string('Location');
            $table->string('IP');
            $table->string('ReferedFrom');
            $table->date('CreateDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StoreVisitor');
    }
}
