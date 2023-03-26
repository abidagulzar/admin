<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $table = 'Store';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'StoreId';

    public $timestamps = false;
    //
    protected $fillable = [
        'StoreId', 'Name', 'Header1', 'Description5', 'SiteUrl', 'LogoUrl', 'MetaTitle', 'MetaDescription', 'MetaKeyword', 'StoreNetworkName', 'NetworkId', 'StoreNetworkLink', 'IsTopStore', 'IsHomeStore', 'Header5', 'Description1', 'Header2', 'Description2', 'Header3', 'Description3', 'Header4', 'Description4', 'SearchName', 'Enabled', 'StoreNetworkId', 'Keyword', 'LogoUrl600X400', 'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate', 'SEOStoreName', 'StoreSettingID', 'ContentLinkText', 'RelatedSearches', 'RegionalName', 'RelatedStoresText', 'FooterText', 'DefaultContentKeywords', 'RelatedStoreKeywords', 'FooterKeywords', 'IsShowAdd', 'RevenueModelID', 'StoreUpdateFrequency', 'LastCouponAddedBy', 'UserAssignedID', 'IsHasSimilarStore', 'QAKeywords'
    ];

    public function Category()
    {
        return $this->belongsToMany(Category::class, 'StoreCategory', 'StoreId', 'CategoryId');
    }
    public function Country()
    {
        return $this->belongsToMany(Country::class, 'StoreCountry', 'StoreId', 'CountryId');
    }
    public function ExludeCountry()
    {
        return $this->belongsToMany(Country::class, 'StoreExcludeCountry', 'StoreId', 'CountryId');
    }
    public function StoreSimilar()
    {
        return $this->belongsToMany(Country::class, 'StoreSimilar', 'StoreId', 'SimilarStoreId');
    }
    public function SetSearchName()
    {
        $this->Keyword = AppHelper::instance()->RemoveSpaces($this->Keyword);
        if (strlen($this->Keyword) > 0) {
            $this->SearchName =  AppHelper::instance()->RemoveSpaces($this->Name) . '-' . $this->Keyword;
        } else {
            $this->Keyword = 'coupon-codes';
            $this->SearchName = AppHelper::instance()->RemoveSpaces($this->Name) . '-coupon-codes';
        }
        $this->SearchName = strtolower($this->SearchName);
    }
}
