<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CouponVisitor', function (Blueprint $table) {
            $table->increments('CouponVisitorId');
            $table->integer('CouponId');
            $table->integer('StoreId');
            $table->string('Location');
            $table->string('IP');
            $table->string('Header');
            $table->string('CouponUrl');
            $table->string('Code');
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
        Schema::dropIfExists('CouponVisitor');
    }
}
