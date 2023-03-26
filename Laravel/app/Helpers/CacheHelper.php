<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheHelper
{

    private $_instance;
    public static function instance()
    {
        if (!isset($_instance))
            $_instance = new CacheHelper();

        return $_instance;
    }

    public function GetHomeSetting()
    {

        if (Cache::has('HomeSetting')) {
            $homeSetting = Cache::get('HomeSetting');
            $homeSetting->Title = AppHelper::instance()->ReplaceSystemKeywords($homeSetting->Title);
            $homeSetting->Description = AppHelper::instance()->ReplaceSystemKeywords($homeSetting->Description);
            $homeSetting->Keywords = AppHelper::instance()->ReplaceSystemKeywords($homeSetting->Keywords);
            $homeSetting->Footer = AppHelper::instance()->ReplaceSystemKeywords($homeSetting->Footer);
            return  $homeSetting;
        } else {
            return Cache::rememberForever('HomeSetting', function () {
                return DB::table('HomeSetting')->select('HomeSetting.*')->first();
            });
        }
    }
    public function ClearHomeSetting()
    {
        Cache::forget('HomeSetting');
    }
    public function ResetHomeSetting()
    {
        $this->instance()->ClearHomeSetting();
        $this->instance()->GetHomeSetting();
    }

    public function GetCategorySetting()
    {

        if (Cache::has('CategorySetting')) {
            return Cache::get('CategorySetting');
        } else {
            return Cache::rememberForever('CategorySetting', function () {
                return DB::table('CategorySetting')->select('CategorySetting.*')->first();
            });
        }
    }
    public function ClearCategorySetting()
    {
        Cache::forget('CategorySetting');
    }
    public function ResetCategorySetting()
    {
        $this->instance()->ClearCategorySetting();
        $this->instance()->GetCategorySetting();
    }


    public function GetStoreSetting()
    {

        if (Cache::has('StoreSetting')) {
            return Cache::get('StoreSetting');
        } else {
            return Cache::rememberForever('StoreSetting', function () {
                return DB::table('StoreSetting')->select('StoreSetting.*')->get();
            });
        }
    }

    public function GetStoreSettingWithId($storesettingId)
    {
        $StoreSettingList = $this->instance()->GetStoreSetting();
        $res = $StoreSettingList->where('StoreSettingId', $storesettingId)->first();
        return $res;
    }
    public function ClearStoreSetting()
    {
        Cache::forget('StoreSetting');
    }
    public function ResetStoreSetting()
    {
        $this->instance()->ClearStoreSetting();
        $this->instance()->GetStoreSetting();
    }

    public function GetStoreLatestSearch()
    {
        if (Cache::has('StoreLatestSearch')) {
            return Cache::get('StoreLatestSearch');
        } else {
            return Cache::rememberForever('StoreLatestSearch', function () {
                return DB::table('StoreLatestSearch')->select('StoreLatestSearchId', 'Value', 'Position')->get();
            });
        }
    }
    public function ClearStoreLatestSearch()
    {
        Cache::forget('StoreLatestSearch');
    }
    public function ResetStoreLatestSearch()
    {
        $this->instance()->ClearStoreLatestSearch();
        $this->instance()->GetStoreLatestSearch();
    }


    public function GetSpecialPage()
    {
        if (Cache::has('SpecialPage')) {
            return Cache::get('SpecialPage');
        } else {
            return Cache::rememberForever('SpecialPage', function () {
                return DB::table('SpecialPage')->select('Name', 'URL')->where('SpecialPage.IsActive', '1')->get();
            });
        }
    }
    public function ClearSpecialPage()
    {
        Cache::forget('SpecialPage');
    }
    public function ResetSpecialPage()
    {
        $this->instance()->ClearSpecialPage();
        $this->instance()->GetSpecialPage();
    }



    public function GetTopStore()
    {

        if (Cache::has('TopStore')) {
            return Cache::get('TopStore');
        } else {
            return Cache::rememberForever('TopStore', function () {
                return DB::table('Store')->select('Name', 'SearchName')->where('IsTopStore', 1)->orderBy('Name', 'ASC')->get();
            });
        }
    }
    public function ClearTopStore()
    {
        Cache::forget('TopStore');
    }
    public function ResetTopStore()
    {
        $this->instance()->ClearTopStore();
        $this->instance()->GetTopStore();
    }


    public function GetTopCategory()
    {
        if (Cache::has('TopCategory')) {
            return Cache::get('TopCategory');
        } else {
            return Cache::rememberForever('TopCategory', function () {
                return DB::table('Category')->select('Name', 'SearchName')->where('IsTopCategory', 1)->orderBy('Name', 'ASC')->get();
            });
        }
    }
    public function ClearTopCategory()
    {
        Cache::forget('TopCategory');
    }

    public function ResetTopCategory()
    {
        $this->instance()->ClearTopCategory();
        $this->instance()->GetTopCategory();
    }

    public function GetStoreFromCache($SearchName)
    {
        if (Cache::has($SearchName)) {
            return Cache::get($SearchName);
        } else {

            return  Cache::rememberForever($SearchName, function () use ($SearchName) {
                return DB::table('Store')->select('Store.*')->where('SearchName', $SearchName)->first();
            });
        }
    }
    public function ClearStoreFromCache($SearchName)
    {
        Cache::forget($SearchName);
    }

    public function ResetStoreFromCache($SearchName)
    {
        $this->instance()->ClearStoreFromCache($SearchName);
        $this->instance()->GetStoreFromCache($SearchName);
    }

    public function ResetGlobalOffersCache()
    {
        $this->instance()->ClearGlobalOffers();
        $this->instance()->GetGlobalOffers();
    }

    public function GetGlobalOffers()
    {
        /* if (Cache::has('GlobalOffers')) {
            return Cache::get('GlobalOffers');
        } else {*/
        return Cache::rememberForever('GlobalOffers', function () {
            return DB::table('Coupon')->select('*')->where('IsGlobalOffer',  1)->get();
        });
        //}
    }
    public function ClearGlobalOffers()
    {
        Cache::forget('StoreLatestSearch');
    }
}
