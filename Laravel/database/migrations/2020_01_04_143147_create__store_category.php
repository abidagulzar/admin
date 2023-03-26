<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StoreCategory', function (Blueprint $table) {

            $table->integer('CategoryId')->unsigned();
            $table->integer('StoreId')->unsigned();

            $table->unique(['CategoryId', 'StoreId']);
            $table->foreign('CategoryId')->references('CategoryId')->on('Category')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('StoreId')->references('StoreId')->on('Store')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StoreCategory');
    }
}
