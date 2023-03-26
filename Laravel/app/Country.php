<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $table = 'Country';
    protected  $primaryKey = 'CountryId';

    protected $fillable = [
        'CountryId',
        'Name',
        'Code',
        'ISO_Code_2',
        'ISO_Code_3',
        'ISO_Country',
        'Lattitude',
        'Longitude'
    ];
    public function Store()
    {
        return $this->belongsToMany(Store::class, 'StoreCountry', 'StoreId', 'CountryId');
    }
}
