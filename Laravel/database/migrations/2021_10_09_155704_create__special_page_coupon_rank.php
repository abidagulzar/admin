<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialPageCouponRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SpecialPageCouponRank', function (Blueprint $table) {
            $table->increments('SpecialPageCouponRankId');
            $table->integer('CouponId');
            $table->integer('SpecialPageId');
            $table->integer('Rank');
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
        Schema::dropIfExists('SpecialPageCouponRank');
    }
}
