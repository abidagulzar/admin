<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class SubmittedCoupon extends Model
{
    public $table = 'SubmittedCoupon';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SubmittedCouponId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SubmittedCouponId', 'StoreId', 'Code', 'Description', 'ExpiryDate',
        'CreateDate', 'UpdateDate'
    ];
}
