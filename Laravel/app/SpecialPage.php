<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;


class SpecialPage extends Model
{
    public $table = 'SpecialPage';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'SpecialPageId';

    public $timestamps = false;
    //
    protected $fillable = [
        'SpecialPageId',
        'Name',
        'Title',
        'SubTitle',
        'BigTitle',
        'BannerUrl',
        'Keyword',
        'MetaTitle',
        'MetaDescription',
        'MetaKeyword',
        'IsCurrentEventPage',
        'CategoryId',
        'URL',
        'LogoUrl',
        'Description',
        'IsActive',
        'CreatedByUserId',
        'UpdatedByUserId',
        'CreateDate',
        'UpdateDate',
        'FilterKeywords'

    ];
}
