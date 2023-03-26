<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class CategorySetting extends Model
{
    public $table = 'CategorySetting';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'CategorySettingId';

    public $timestamps = false;
    //
    protected $fillable = [
        'CategorySettingId',
        'Title',
        'Description',
        'Keywords',
        'Footer',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate'
    ];
}
