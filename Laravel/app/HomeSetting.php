<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    public $table = 'HomeSetting';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'HomeSettingId';

    public $timestamps = false;
    //
    protected $fillable = [
        'HomeSettingId', 'Banner1Url', 'Banner2Url', 'Banner3Url', 'Banner4Url', 'Banner1HeaderText', 'Banner2HeaderText', 'Banner3HeaderText', 'Banner4HeaderText',
        'AffiliateLink1', 'AffiliateLink2', 'AffiliateLink3', 'AffiliateLink4', 'Title', 'Description', 'Keywords',
        'IsBanner1Show', 'IsBanner2Show', 'IsBanner3Show', 'IsBanner4Show', 'Footer',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate', 'SchemaOrg'
    ];
}
