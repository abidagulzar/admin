<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ExternalOffer', function (Blueprint $table) {
            $table->increments('ExternalOfferId');
            $table->string('Code');
            $table->string('Header');
            $table->string('Description');
            $table->integer('StoreId');
            $table->string('CouponUrl');
            $table->string('LogoUrl');
            $table->date('StartDate');
            $table->date('ExpiryDate');
            $table->integer('Enabled');
            $table->integer('Expired');
            $table->string('OFF');
            $table->string('PreviousPrice');
            $table->string('NewPrice');
            $table->integer('IsUnknownOutGoing');
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
        Schema::dropIfExists('ExternalOffer');
    }
}
