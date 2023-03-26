<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmitadSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AdmitadSale', function (Blueprint $table) {
            $table->increments('AdmitadSaleId');
            $table->string('offer_id');
            $table->string('offer_name');
            $table->string('admitad_id');
            $table->string('website_name');
            $table->string('website_id');
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
        Schema::dropIfExists('AdmitadSale');
    }
}
