<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SubmittedCoupon', function (Blueprint $table) {
            $table->increments('SubmittedCouponId');
            $table->integer('StoreId');
            $table->string('Code');
            $table->string('Description');
            $table->date('ExpiryDate');
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
        Schema::dropIfExists('SubmittedCoupon');
    }
}
