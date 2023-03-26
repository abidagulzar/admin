<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    public $table = 'StoreSetting';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'StoreSettingId';

    public $timestamps = false;
    //
    protected $fillable = [
        'StoreSettingId',
        'Title',
        'Description',
        'Keywords',
        'Footer',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate',
        'DefaultContent', 'RegionName',
        'RelatedSearches', 'RelatedStoresText', 'MonthsFull', 'MonthsShort',
        'RelatedStoreHeading', 'SubscribeToEmailHeading', 'SubscribeToEmailText', 'SubscribeToEmailFooter', 'SubscribeTranslate', 'EmailAddressTranslate', 'GotQuestionHeading', 'GotQuestionText', 'DropLineTranslate', 'RelatedSearchesTranslate', 'GeneralTranslate', 'ConnectTranslate', 'SpecialPagesHeading', 'GetDeal', 'ShowCode', 'ClickBelowTextAndPast', 'ExpiresOn', 'UnknownOutGoring', 'VisitOurStore', 'Coupon', 'Deal', 'Exclusive', 'ContinueToStore', 'NoCodeNeeded', 'DefaultContentKeywords', 'RelatedStoreKeywords', 'FooterKeywords', 'Lang', 'DefaultDealText', 'DefaultQA', 'QAKeywords', 'Header1'
    ];
}
