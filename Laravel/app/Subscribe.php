<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    public $table = 'Subscribe';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SubscribeId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SubscribeId', 'Email', 'IsActive', 'Reason', 'IPAddress', 'Location',
        'CreateDate', 'UpdateDate'
    ];
}
