<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSimilar extends Model
{
    protected $table = 'StoreSimilar';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'StoreId', 'SimilarStoreId'
    ];
}
