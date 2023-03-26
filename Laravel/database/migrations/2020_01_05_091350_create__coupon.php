<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('Coupon', function (Blueprint $table) {
            $table->increments('CouponId');
            $table->string('Code');
            $table->string('Header');
            $table->string('Description');
            $table->integer('StoreId');
            $table->string('CouponUrl');
            $table->string('LogoUrl');
            $table->date('ExpiryDate');
            $table->integer('Enabled');
            $table->integer('Expired');
            $table->integer('GlobalRank');
            $table->integer('StoreRank');
            $table->integer('HomeCoupon');
            $table->integer('HomeOffer');
            $table->string('CopounTypeColour');
            $table->string('CopounTypeText');
            $table->string('CopounType');
            $table->integer('BestDeal');
            $table->string('OFF');
            $table->string('PreviousPrice');
            $table->string('NewPrice');
            $table->integer('IsUnknownOutGoing');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->integer('IsExclusive');
            $table->integer('IsHeaderDeal');
            $table->integer('IsBanner');
            $table->integer('IsHomeBanner');
            $table->integer('IsFlashDeal');
            $table->integer('IsTopDeal');
            $table->string('BannerUrl');
            $table->date('StartDate');
            $table->string('DealPageUrl');
            $table->integer('CountryId');
            $table->integer('IsShowAtHome');
            $table->integer('IsGlobalOffer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Coupon');
    }
}
