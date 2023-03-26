<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class ExcludeTrafficIP extends Model
{
    public $table = 'ExcludeTrafficIP';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'ExcludeTrafficIPID';

    public $timestamps = false;
    //
    protected $fillable = [
        'ExcludeTrafficIPID', 'Title', 'IP',
        'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate'
    ];
}
