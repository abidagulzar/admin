<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table = 'StoreCategory';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'StoreId', 'CategoryId'
    ];
}
