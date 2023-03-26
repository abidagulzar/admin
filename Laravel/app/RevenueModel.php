<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class RevenueModel extends Model
{
    public $table = 'RevenueModel';
    protected  $primaryKey = 'RevenueModelID';

    public $timestamps = false;
    //
    protected $fillable = [
        'RevenueModelID', 'Name'
    ];
}
