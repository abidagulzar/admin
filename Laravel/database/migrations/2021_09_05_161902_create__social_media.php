<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SocialMedia', function (Blueprint $table) {
            $table->increments('SocialMediaId');
            $table->string('SocialImage');
            $table->integer('StoreId');
            $table->string('AffiliateUrlToRedirect');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->string('Title');
            $table->string('SocialMediaSharedURL');
            $table->string('Description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SocialMedia');
    }
}
