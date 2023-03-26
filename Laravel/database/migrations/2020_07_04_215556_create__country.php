<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Country', function (Blueprint $table) {
            $table->increments('CountryId');
            $table->string('Name');
            $table->string('Code');
            $table->string('ISO_Code_2');
            $table->string('ISO_Code_3');
            $table->string('ISO_Country');
            $table->decimal('Lattitude');
            $table->decimal('Longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Country');
    }
}
