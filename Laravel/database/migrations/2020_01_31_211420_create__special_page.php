<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SpecialPage', function (Blueprint $table) {
            $table->increments('SpecialPageId');
            $table->string('Name');
            $table->string('Title');
            $table->string('SubTitle');
            $table->string('BigTitle');
            $table->string('BannerUrl');
            $table->string('Keyword');
            $table->string('MetaTitle');
            $table->string('MetaDescription');
            $table->string('MetaKeyword');
            $table->integer('IsCurrentEventPage');
            $table->integer('CategoryId');
            $table->string('URL');
            $table->string('LogoUrl');
            $table->string('Description');
            $table->integer('IsActive');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->string('FilterKeywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SpecialPage');
    }
}
