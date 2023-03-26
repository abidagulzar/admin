<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class CPCStore extends Model
{
    protected $table = 'CPCStore';
    //
    public $timestamps = false;
    protected  $primaryKey = 'CPCStoreId';
    //
    protected $fillable = [
        'CPCStoreId',  'StoreId', 'CountryId', 'TrackURL', 'Commission'
    ];
}
