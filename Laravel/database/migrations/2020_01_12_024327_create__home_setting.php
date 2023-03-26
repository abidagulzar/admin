<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HomeSetting', function (Blueprint $table) {
            $table->increments('HomeSettingId');
            $table->string('Banner1Url');
            $table->string('Banner2Url');
            $table->string('Banner3Url');
            $table->string('Banner4Url');
            $table->string('Banner1HeaderText');
            $table->string('Banner2HeaderText');
            $table->string('Banner3HeaderText');
            $table->string('Banner4HeaderText');

            $table->string('AffiliateLink1');
            $table->string('AffiliateLink2');
            $table->string('AffiliateLink3');
            $table->string('AffiliateLink4');

            $table->string('Title');
            $table->string('Description');
            $table->string('Keywords');
            $table->string('Footer');

            $table->integer('IsBanner1Show');
            $table->integer('IsBanner2Show');
            $table->integer('IsBanner3Show');
            $table->integer('IsBanner4Show');


            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');

            $table->string('SchemaOrg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HomeSetting');
    }
}
