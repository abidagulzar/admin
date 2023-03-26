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
use Auth;
use DateTime;

class CategoryController extends Controller
{
    public function categoryList(Request $request)
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();

        // For Master Page Data

        $categories = DB::table('Category')->select('Category.*')->orderBy('Name', 'ASC')->get();

        return view('Site.Category.categorylist', compact('homeSetting', 'relatedSearch', 'categories', 'specialPage'));
    }

    public function categoryDetail($categorySearchName = null)
    {
        // For Master Page Data

        $categorySetting = CacheHelper::instance()->GetCategorySetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();



        // For Master Page Data

        $category = DB::table('Category')->select('Category.*')->where('SearchName', $categorySearchName)->first();

        if (isset($category)) {

            if ($category->MetaTitle == null || trim($category->MetaTitle) == '') {
                $categorySetting->Title = AppHelper::instance()->ReplaceSystemKeywords($categorySetting->Title, '@categoryname', $category->Name);
            } else {
                $categorySetting->Title = AppHelper::instance()->ReplaceSystemKeywords($category->MetaTitle, '@categoryname', $category->Name);
            }
            if ($category->MetaDescription == null || trim($category->MetaDescription) == '') {
                $categorySetting->Description = AppHelper::instance()->ReplaceSystemKeywords($categorySetting->Description, '@categoryname', $category->Name);
            } else {
                $categorySetting->Description = AppHelper::instance()->ReplaceSystemKeywords($category->MetaDescription, '@categoryname', $category->Name);
            }
            if ($category->MetaKeyword == null || trim($category->MetaKeyword) == '') {
                $categorySetting->Keywords = AppHelper::instance()->ReplaceSystemKeywords($categorySetting->Keywords, '@categoryname', $category->Name);
            } else {
                $categorySetting->Keywords = AppHelper::instance()->ReplaceSystemKeywords($category->MetaKeyword, '@categoryname', $category->Name);
            }

            $categorySetting->Footer = AppHelper::instance()->ReplaceSystemKeywords($categorySetting->Footer, '@categoryname', $category->Name);

            $categoryCoupons = DB::table('CouponCategory')->select('Coupon.*', 'Store.SearchName As StoreSearchName', 'Store.Name As StoreName', 'Store.LogoUrl As StoreLogoUrl')->leftJoin('Coupon', 'Coupon.CouponId', '=', 'CouponCategory.CouponId')->leftJoin('Store', 'Store.StoreId', '=', 'Coupon.StoreId')->Where('CouponCategory.CategoryId', $category->CategoryId)->where(function ($query) {
                $query->where('Coupon.Expired', '!=', 1)->orWhereNull('Coupon.Expired');
            })->where(function ($query) {
                $query->where('Coupon.ExpiryDate', '>=', \DB::raw('DATE_SUB(NOW(), INTERVAL 36 HOUR)'))
                    ->orWhereNull('Coupon.ExpiryDate');
            })->orderBy('Coupon.StoreRank', 'ASC')->take(300)->get();


            $categoryCoupons = $categoryCoupons->shuffle();

            $categoryBanners = $categoryCoupons->where('IsBanner', 1)->shuffle()->take(5);

            $relatedDeals = $categoryCoupons->where('IsBanner', '!=', 1)->shuffle()->take(5);

            return view('Site.Category.categorydetail', compact('categorySetting', 'relatedSearch', 'category', 'specialPage', 'categoryCoupons', 'categoryBanners', 'relatedDeals'));
        }

        return redirect()->route('site.home');
    }
}
