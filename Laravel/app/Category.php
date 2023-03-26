<?php

namespace App;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    public $table = 'Category';
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'UpdateDate';
    protected  $primaryKey = 'CategoryId';

    public $timestamps = false;
    //
    protected $fillable = [
        'CategoryId', 'Name', 'Header', 'IconClass', 'Description', 'MotherCategory', 'LogoUrl', 'Keyword', 'MetaTitle', 'MetaDescription', 'MetaKeyword', 'Enabled', 'IsTopCategory', 'IsHomeCategory', 'SearchName', 'CreatedByUserId', 'UpdatedByUserId', 'CreateDate', 'UpdateDate'
    ];

    public function Store()
    {
        return $this->belongsToMany(Store::class, 'StoreCategory', 'StoreId', 'CategoryId');
    }

    public function SetSearchName()
    {
        $this->Keyword = AppHelper::instance()->RemoveSpaces($this->Keyword);
        if (strlen($this->Keyword) > 0) {
            $this->SearchName =  AppHelper::instance()->RemoveSpaces($this->Name) . '-' . $this->Keyword;
        } else {
            $this->Keyword = 'coupon-codes';
            $this->SearchName = AppHelper::instance()->RemoveSpaces($this->Name) . '-coupon-codes';
        }
        $this->SearchName = strtolower($this->SearchName);
    }
}
