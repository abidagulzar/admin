<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPCStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPCStore', function (Blueprint $table) {
            $table->increments('CPCStoreId');
            $table->integer('CountryId')->unsigned();
            $table->integer('StoreId')->unsigned();

            $table->unique(['CountryId', 'StoreId']);
            $table->foreign('CountryId')->references('CountryId')->on('Country')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('StoreId')->references('StoreId')->on('Store')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('TrackURL');
            $table->decimal('Commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPCStore');
    }
}
