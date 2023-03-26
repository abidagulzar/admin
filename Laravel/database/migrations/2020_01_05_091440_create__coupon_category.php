<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CouponCategory', function (Blueprint $table) {

            $table->integer('CategoryId')->unsigned();
            $table->integer('CouponId')->unsigned();

            $table->unique(['CategoryId', 'CouponId']);
            $table->foreign('CategoryId')->references('CategoryId')->on('Category')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CouponId')->references('CouponId')->on('Coupon')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CouponCategory');
    }
}
