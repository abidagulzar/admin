<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StoreCountry', function (Blueprint $table) {

            $table->integer('CountryId')->unsigned();
            $table->integer('StoreId')->unsigned();

            $table->unique(['CountryId', 'StoreId']);
            $table->foreign('CountryId')->references('CountryId')->on('Country')
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
        Schema::dropIfExists('StoreCountry');
    }
}
