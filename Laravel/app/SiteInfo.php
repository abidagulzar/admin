<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    public $table = 'SiteInfo';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SiteInfoId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SiteInfoId', 'AboutUs', 'ContactUs', 'PrivacyPolicy', 'TermsOfUse',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate', 'SuggestionText'
    ];
}
