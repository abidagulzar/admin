<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class CPCStoreVisitor extends Model
{
    protected $table = 'CPCStoreVisitor';
    //
    const CREATED_AT = 'CreateDate';

    public $timestamps = false;

    protected  $primaryKey = 'CPCStoreVisitorId';

    protected $fillable = [
        'CPCStoreVisitorId',
        'SourceStoreId',
        'TargetStoreId',
        'Location',
        'IP',
        'CreateDate',
        'CountryCode',
        'IsProcessed'
    ];
}
