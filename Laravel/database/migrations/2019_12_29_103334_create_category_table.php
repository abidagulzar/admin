<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('CategoryId');
            $table->string('Name');
            $table->string('Header');
            $table->text('Description');
            $table->integer('MotherCategory');
            $table->string('LogoUrl');
            $table->string('MetaTitle');
            $table->text('MetaDescription');
            $table->string('MetaKeyword');
            $table->integer('IsTopCategory');
            $table->integer('Enabled');
            $table->string('SearchName');
            $table->string('IconClass');
            $table->integer('CreatedByUserId');
            $table->integer('UpdatedByUserId');
            $table->date('CreateDate');
            $table->date('UpdateDate');
            $table->date('IsHomeCategory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
