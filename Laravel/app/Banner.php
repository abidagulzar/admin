<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;


class Banner extends Model
{
    public $table = 'Banner';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey = 'BannerId';

    public $timestamps = false;
    //
    protected $fillable = [
        'BannerId', 'Url', 'HeaderText', 'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate'
    ];
}
