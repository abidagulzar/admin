<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;


class AdmitadSale extends Model
{
    public $table = 'AdmitadSale';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey = 'AdmitadSaleId';

    public $timestamps = false;
    //
    protected $fillable = [
        'AdmitadSaleId', 'offer_id', 'offer_name', 'admitad_id', 'website_name', 'website_id'
    ];
}
