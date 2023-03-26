<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\SpecialPage;
use App\Category;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;

class SpecialPageController extends Controller
{

    public function index($specialpageURL = null)
    {

        // For Master Page Data

        $metaSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();


        // For Master Page Data

        $selectedSpecialPage = DB::table('SpecialPage')->select('SpecialPage.*')->where('URL', $specialpageURL)->first();

        if (isset($selectedSpecialPage)) {

            if ($selectedSpecialPage->MetaTitle == null || trim($selectedSpecialPage->MetaTitle) == '') {
                $metaSetting->Title = AppHelper::instance()->ReplaceSystemKeywords($metaSetting->Title, '@storename', $selectedSpecialPage->Name);
            } else {
                $metaSetting->Title = AppHelper::instance()->ReplaceSystemKeywords($selectedSpecialPage->MetaTitle, '@storename', $selectedSpecialPage->Name);
            }
            if ($selectedSpecialPage->MetaDescription == null || trim($selectedSpecialPage->MetaDescription) == '') {
                $metaSetting->Description = AppHelper::instance()->ReplaceSystemKeywords($metaSetting->Description, '@storename', $selectedSpecialPage->Name);
            } else {
                $metaSetting->Description = AppHelper::instance()->ReplaceSystemKeywords($selectedSpecialPage->MetaDescription, '@storename', $selectedSpecialPage->Name);
            }
            if ($selectedSpecialPage->MetaKeyword == null || trim($selectedSpecialPage->MetaKeyword) == '') {
                $metaSetting->Keywords = AppHelper::instance()->ReplaceSystemKeywords($metaSetting->Keywords, '@storename', $selectedSpecialPage->Name);
            } else {
                $metaSetting->Keywords = AppHelper::instance()->ReplaceSystemKeywords($selectedSpecialPage->MetaKeyword, '@storename', $selectedSpecialPage->Name);
            }

            $metaSetting->Footer = AppHelper::instance()->ReplaceSystemKeywords($metaSetting->Footer, '@storename', $selectedSpecialPage->Name);

            $where = '';
            $unionWithWhere = '';
            if ($selectedSpecialPage->FilterKeywords != null && $selectedSpecialPage->FilterKeywords != '') {

                $filters = explode(',', $selectedSpecialPage->FilterKeywords);

                $ct = count($filters);
                for ($i = 0; $i < $ct; $i++) {
                    if ($i > 0) {
                        $where = $where . ' or';
                    }
                    $where  = $where . ' Header like \'%' . $filters[$i] . '%\' or Description like \'%' . $filters[$i] . '%\'';
                }

                $unionWithWhere = "union select CouponId from Coupon where " . $where;
            }



            $selectedSpecialPageCoupons = DB::select(
                "Select s.SearchName As StoreSearchName,s.LogoUrl As StoreLogoUrl, s.SEOStoreName As StoreName,c.*
        from Coupon c left join Store s on c.StoreId = s.StoreId left join SpecialPageCouponRank specialPageCouponRank on specialPageCouponRank.CouponId = c.CouponId
        and specialPageCouponRank.SpecialPageId = :SpecialPageId where c.CouponId in 
        (
         Select CouponId from CouponCategory where CategoryId = :CategoryId " . $unionWithWhere . ")
        and s.NetworkId in(1,2,3) order by specialPageCouponRank.Rank asc ",
                ["SpecialPageId" => $selectedSpecialPage->SpecialPageId, "CategoryId" => $selectedSpecialPage->CategoryId]
            );

            $specialPageRelatedStores = DB::table('CouponCategory')->select('Coupon.*', 'Store.SearchName As StoreSearchName', 'Store.Name As StoreName', 'Store.LogoUrl As StoreLogoUrl')->join('Coupon', 'Coupon.CouponId', '=', 'CouponCategory.CouponId')->join('Store', 'Store.StoreId', '=', 'Coupon.StoreId')->Where('CouponCategory.CategoryId', $selectedSpecialPage->CategoryId)->get();

            return view('Site.SpecialPage.index', compact('metaSetting', 'relatedSearch', 'specialPage', 'selectedSpecialPage', 'selectedSpecialPageCoupons', 'specialPageRelatedStores'));
        }

        return redirect()->route('site.home');
    }
}
