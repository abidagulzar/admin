<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->increments('StoreId');
            $table->string('Name');
            $table->string('Header1');
            $table->text('Description5');
            $table->string('SiteUrl');
            $table->string('LogoUrl');
            $table->string('MetaTitle');
            $table->text('MetaDescription');
            $table->string('MetaKeyword');
            $table->string('StoreNetworkName');
            $table->integer('NetworkId');
            $table->string('StoreNetworkLink');
            $table->boolean('IsTopStore');
            $table->string('Header5');
            $table->text('Description1');
            $table->string('Header2');
            $table->text('Description2');
            $table->string('Header3');
            $table->text('Description3');
            $table->string('Header4');
            $table->text('Description4');
            $table->string('SearchName');
            $table->boolean('Enabled');
            $table->integer('StoreNetworkId');
            $table->string('Keyword');
            $table->string('LogoUrl600X400');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->date('IsHomeStore');
            $table->date('SEOStoreName');
            $table->integer('StoreSettingID');
            $table->string('SEOStoreName');
            $table->string('RelatedSearches');
            $table->string('RegionalName');
            $table->string('RelatedStoresText');
            $table->string('FooterText');
            $table->string('DefaultContentKeywords');
            $table->string('RelatedStoreKeywords');
            $table->string('FooterKeywords');
            $table->string('IsShowAdd');
            $table->integer('RevenueModelID');
            $table->integer('StoreUpdateFrequency');
            $table->integer('LastCouponAddedBy');
            $table->integer('UserAssignedID');
            $table->string('IsHasSimilarStore');
            $table->string('QAKeywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
}
