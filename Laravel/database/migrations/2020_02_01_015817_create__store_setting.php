<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StoreSetting', function (Blueprint $table) {
            $table->increments('StoreSettingId');
            $table->string('Description');
            $table->string('Keywords');
            $table->string('Footer');
            $table->string('Title');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->string('DefaultContent');
            $table->string('RegionName');
            $table->string('RelatedSearches');
            $table->string('RelatedStoresText');
            $table->string('MonthsFull');
            $table->string('MonthsShort');


            $table->string('RelatedStoreHeading');
            $table->string('SubscribeToEmailHeading');
            $table->string('SubscribeToEmailText');
            $table->string('SubscribeToEmailFooter');
            $table->string('SubscribeTranslate');
            $table->string('EmailAddressTranslate');
            $table->string('GotQuestionHeading');
            $table->string('GotQuestionText');
            $table->string('DropLineTranslate');
            $table->string('RelatedSearchesTranslate');
            $table->string('GeneralTranslate');
            $table->string('ConnectTranslate');
            $table->string('SpecialPagesHeading');
            $table->string('GetDeal');
            $table->string('ShowCode');
            $table->string('ClickBelowTextAndPast');
            $table->string('ExpiresOn');
            $table->string('UnknownOutGoring');
            $table->string('VisitOurStore');
            $table->string('Exclusive');
            $table->string('Deal');
            $table->string('Coupon');
            $table->string('ContinueToStore');
            $table->string('NoCodeNeeded');
            $table->string('DefaultContentKeywords');
            $table->string('RelatedStoreKeywords');
            $table->string('FooterKeywords');
            $table->string('Lang');
            $table->string('DefaultDealText');
            $table->string('DefaultQA');
            $table->string('QAKeywords');
            $table->string('Header1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StoreSetting');
    }
}
