<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    protected $table = 'CouponCategory';
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'CouponId', 'CategoryId'
    ];
}
