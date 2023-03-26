<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    public $table = 'SocialMedia';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SocialMediaId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SocialMediaId', 'SocialImage', 'StoreId', 'AffiliateUrlToRedirect',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate', 'Title', 'SocialMediaSharedURL', 'Description'
    ];
}
