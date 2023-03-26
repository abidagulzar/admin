<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSimilar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StoreSimilar', function (Blueprint $table) {

            $table->integer('StoreId')->unsigned();
            $table->integer('SimilarStoreId')->unsigned();

            $table->unique(['StoreId', 'SimilarStoreId']);
            $table->foreign('StoreId')->references('StoreId')->on('Store')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('SimilarStoreId')->references('StoreId')->on('Store')
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
        Schema::dropIfExists('StoreSimilar');
    }
}
