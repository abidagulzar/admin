<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $table = 'Coupon';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'CouponId';

    public $timestamps = false;
    //
    protected $fillable = [
        'CouponId',
        'Code',
        'Header',
        'Description',
        'StoreId',
        'CouponUrl',
        'LogoUrl',
        'ExpiryDate',
        'Enabled',
        'Expired',
        'GlobalRank',
        'StoreRank',
        'HomeCoupon',
        'HomeOffer',
        'CopounTypeColour',
        'CopounTypeText',
        'CopounType',
        'BestDeal',
        'OFF',
        'PreviousPrice',
        'NewPrice',
        'IsUnknownOutGoing',
        'CreatedByUserId',
        'UpdatedByUserId',
        'CreateDate',
        'UpdateDate',
        'IsExclusive',
        'IsHeaderDeal',
        'IsBanner',
        'BannerUrl',
        'StartDate',
        'IsHomeBanner',
        'IsFlashDeal',
        'IsTopDeal',
        'DealPageUrl',
        'CountryId',
        'IsShowAtHome', 'IsGlobalOffer'
    ];

    public function Category()
    {
        return $this->belongsToMany(Category::class, 'CouponCategory', 'CouponId', 'CategoryId');
    }
}
