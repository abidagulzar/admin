<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreExcludeCountry extends Model
{
    protected $table = 'StoreExcludeCountry';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'StoreId', 'CountryId'
    ];
}
