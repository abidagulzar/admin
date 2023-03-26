<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPCStoreVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPCStoreVisitor', function (Blueprint $table) {
            $table->increments('CPCStoreVisitorId');
            $table->integer('SourceStoreId');
            $table->integer('TargetStoreId');
            $table->string('Location');
            $table->string('IP');
            $table->date('CreateDate');
            $table->string('CountryCode');
            $table->integer('IsProcessed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPCStoreVisitor');
    }
}
