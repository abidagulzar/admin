<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class ExternalOffer extends Model
{
    public $table = 'ExternalOffer';
    protected  $primaryKey = 'ExternalOfferId';

    protected $fillable = [
        'ExternalOfferId',
        'Code',
        'Header',
        'Description',
        'StoreId',
        'CouponUrl',
        'LogoUrl',
        'StartDate',
        'ExpiryDate',
        'Enabled',
        'Expired',
        'OFF',
        'PreviousPrice',
        'NewPrice',
        'IsUnknownOutGoing',
        'CreatedByUserId',
        'UpdatedByUserId',
        'CreateDate',
        'UpdateDate',
    ];
}
