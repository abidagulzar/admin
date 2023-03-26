<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Home;
use App\Category;
use App\HomeCategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Store;
use Auth;
use DateTime;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();
        $topStores = CacheHelper::instance()->GetTopStore();
        $topCategories = CacheHelper::instance()->GetTopCategory();

        // For Master Page Data

        //$homeCouponBannerDeal = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.IsTopDeal', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.CouponUrl', 'Coupon.HomeCoupon', 'Coupon.OFF', 'Coupon.IsUnknownOutGoing', 'Coupon.CopounTypeText', 'Coupon.LogoUrl', 'Coupon.BannerUrl', 'Coupon.IsBanner', 'Coupon.IsHomeBanner', 'Coupon.HomeCoupon', 'Store.LogoUrl As StoreLogoUrl', 'Store.Name As StoreName')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->where('Coupon.IsHomeBanner', '1')->orWhere('Coupon.IsBanner', '1')->orWhere('Coupon.HomeCoupon', '1')->orWhere('Coupon.IsTopDeal', '1')->get();

        // $homeCoupon = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.CouponUrl', 'Coupon.HomeCoupon', 'Coupon.OFF As OFF', 'Coupon.IsUnknownOutGoing', 'Coupon.CopounTypeText', 'Coupon.LogoUrl', 'Store.LogoUrl As StoreLogoUrl', 'Store.Name As StoreName')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId');

        //$homeCategory = DB::table('Category')->select('Category.CategoryId', 'Category.Name', 'Category.IconClass', 'Category.Header', 'Category.Description', 'Category.LogoUrl', 'Category.IsHomeCategory', 'Category.Enabled', 'Category.SearchName')->where('Category.IsHomeCategory', '1')->get();

        //$homeStore = DB::table('Store')->select('Store.StoreId', 'Store.Name', 'Store.Enabled', 'Store.Header1', 'Store.LogoUrl', 'Store.SearchName', 'Store.Enabled', 'Store.IsHomeStore', 'Store.CreateDate', 'Store.UpdateDate')->where('Store.IsHomeStore', '1')->get();

        $homeCouponData = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.IsTopDeal', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.CouponUrl', 'Coupon.HomeCoupon', 'Coupon.OFF', 'Coupon.IsUnknownOutGoing', 'Coupon.CopounTypeText', 'Coupon.LogoUrl', 'Coupon.BannerUrl', 'Coupon.IsBanner', 'Coupon.IsHomeBanner', 'Coupon.HomeCoupon', 'Coupon.IsShowAtHome', 'Coupon.GlobalRank', 'Store.LogoUrl As StoreLogoUrl', 'Store.SEOStoreName As StoreName')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->where('Coupon.IsShowAtHome', '1')->orWhere('Coupon.HomeCoupon', '1')->orderBy('GlobalRank', 'ASC')->orderBy('Coupon.CreateDate', 'DESC')->get();


        $crousalCoupon = $homeCouponData->filter(function ($item) {
            return data_get($item, 'HomeCoupon') == 1 && !empty(data_get($item, 'Code'));
        });

        $homeCoupon = $homeCouponData->filter(function ($item) {
            return data_get($item, 'IsShowAtHome') == 1;
        });

        $ip = geoip()->getClientIP();
        // $location = geoip()->getLocation($ip);


        return view('Site.Home.index', compact('homeSetting', 'homeCoupon', 'crousalCoupon', 'relatedSearch', 'specialPage', 'topStores', 'topCategories'));
    }

    public function siteSearch($keyword)
    {
        $stores = DB::table('Store')->select('StoreId', 'Name', 'Enabled', 'Header1', 'LogoUrl', 'SearchName', 'Enabled', 'SEOStoreName')->where('Name', 'like', '%' . $keyword . '%')->orWhere('SEOStoreName', 'like', '%' . $keyword . '%')->limit(15)->get();

        return view('Site.Layout.searchsuggesions', compact('stores'));
    }
}
