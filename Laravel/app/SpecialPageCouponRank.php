<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;


class SpecialPageCouponRank extends Model
{
    public $table = 'SpecialPageCouponRank';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SpecialPageCouponRankId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SpecialPageCouponRankId',
        'CouponId',
        'SpecialPageId',
        'Rank',
        'CreateDate',
        'UpdateDate'
    ];
}
