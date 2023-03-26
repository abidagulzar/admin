<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    public $table = 'Network';
    protected  $primaryKey = 'NetworkId';

    public $timestamps = false;
    //
    protected $fillable = [
        'NetworkId', 'Name'
    ];
}
