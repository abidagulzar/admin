<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Home;
use App\Category;
use App\CouponVisitor;
use App\CPCStoreVisitor;
use App\HomeCategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use Auth;
use DateTime;

class CouponController extends Controller
{
    public function CouponPopup($storename = null, $couponid = null)
    {
        $ip = geoip()->getClientIP();

        $couponVisitor = new CouponVisitor();
        $couponVisitor->CouponId = $couponid;
        $couponVisitor->Location = "";
        $couponVisitor->IP =  $ip;

        $couponVisitor->CreateDate = new DateTime();

        $Model = DB::table('Coupon')->select('Coupon.StoreId', 'Coupon.CouponId', 'Coupon.Code', 'Coupon.Header', 'Coupon.CouponUrl', 'Coupon.Description', 'Store.Name As StoreName', 'Store.SEOStoreName As SEOStoreName', 'Store.LogoUrl As StoreLogoUrl', 'Store.SearchName As StoreSearchName', 'Store.StoreSettingID As StoreSettingID')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->where('Coupon.CouponId', $couponid)->first();


        $storeSetting = CacheHelper::instance()->GetStoreSettingWithId($Model->StoreSettingID);

        $storeSetting->VisitOurStore = AppHelper::instance()->ReplaceSystemKeywords($storeSetting->VisitOurStore, '@storename', $Model->SEOStoreName);
        $storeSetting->ClickBelowTextAndPast = AppHelper::instance()->ReplaceSystemKeywords($storeSetting->ClickBelowTextAndPast, '@storename', $Model->SEOStoreName);

        $couponVisitor->StoreId =  $Model->StoreId;
        $couponVisitor->Header =  $Model->Header;
        $couponVisitor->CouponUrl =  $Model->CouponUrl;
        $couponVisitor->Code =  $Model->Code;

        $couponVisitor->save();

        return view('Site.Coupon.couponpopup', compact('Model', 'storeSetting'));
    }

    public function CPCPopUrl($sourcestoreid = null, $targetstoreid = null)
    {
        $ip = geoip()->getClientIP();

        $cpcStoreVisitor = new CPCStoreVisitor();
        $cpcStoreVisitor->SourceStoreId = $sourcestoreid;
        $cpcStoreVisitor->TargetStoreId =  $targetstoreid;
        $cpcStoreVisitor->IP =  $ip;

        $cpcStoreVisitor->CreateDate = new DateTime();

        // $storeSetting = CacheHelper::instance()->GetStoreSettingWithId($Model->StoreSettingID);
        // $storeSetting->VisitOurStore = AppHelper::instance()->ReplaceSystemKeywords($storeSetting->VisitOurStore, '@storename', $Model->SEOStoreName);
        // $storeSetting->ClickBelowTextAndPast = AppHelper::instance()->ReplaceSystemKeywords($storeSetting->ClickBelowTextAndPast, '@storename', $Model->SEOStoreName);

        $cpcStoreVisitor->save();

        return 1;
    }
}
