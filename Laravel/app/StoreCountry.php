<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCountry extends Model
{
    protected $table = 'StoreCountry';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'StoreId', 'CountryId'
    ];
}
