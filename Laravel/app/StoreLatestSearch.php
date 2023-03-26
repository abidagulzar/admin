<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLatestSearch extends Model
{
    protected $table = 'StoreLatestSearch';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'StoreLatestSearchId', 'Value', 'Position'
    ];
}
