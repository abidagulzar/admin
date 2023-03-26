<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SiteInfo', function (Blueprint $table) {
            $table->increments('SiteInfoId');
            $table->string('AboutUs');
            $table->string('ContactUs');
            $table->string('PrivacyPolicy');
            $table->string('TermsOfUse');
            $table->string('SuggestionText');
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
        Schema::dropIfExists('SiteInfo');
    }
}
