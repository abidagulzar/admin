<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class StoreVisitor extends Model
{
    public $table = 'StoreVisitor';
    const CREATED_AT = 'CreateDate';
    protected  $primaryKey = 'StoreVisitorId';

    public $timestamps = false;
    //
    protected $fillable = [
        'StoreVisitorId',
        'StoreId',
        'Location',
        'IP',
        'ReferedFrom',
        'CreateDate'

    ];
}
