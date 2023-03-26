<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    public $table = 'UserMessage';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'UserMessageId';

    public $timestamps = false;
    //
    protected $fillable = [
        'UserMessageId', 'Name', 'Email', 'Website', 'Message', 'IPAddress', 'Location',
        'CreateDate', 'UpdateDate', 'IsSuggestion'
    ];
}
