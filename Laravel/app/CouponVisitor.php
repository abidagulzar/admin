<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class CouponVisitor extends Model
{
    public $table = 'CouponVisitor';
    const CREATED_AT = 'CreateDate';
    protected  $primaryKey = 'CouponVisitorId';

    public $timestamps = false;
    //
    protected $fillable = [
        'CouponVisitorId',
        'CouponId',
        'Location',
        'IP',
        'CreateDate',
        'Header',
        'CouponUrl',
        'Code',
        'StoreId',
        'ReferedFrom'
    ];
}
