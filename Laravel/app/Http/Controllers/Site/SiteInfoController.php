<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use Auth;
use DateTime;
use App\SiteInfo;

class SiteInfoController extends Controller
{
    function __construct()
    {
    }


    public function TermsOfUse()
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();

        // For Master Page Data

        $siteInfo = DB::table('SiteInfo')->select('SiteInfo.*')->first();

        return view('Site.SiteInfo.termsofuse', compact('homeSetting', 'relatedSearch', 'specialPage', 'siteInfo'));
    }

    public function PrivacyPolicy()
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();

        // For Master Page Data

        $siteInfo = DB::table('SiteInfo')->select('SiteInfo.*')->first();

        return view('Site.SiteInfo.privacypolicy', compact('homeSetting', 'relatedSearch', 'specialPage', 'siteInfo'));
    }

    public function AboutUs()
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();


        // For Master Page Data

        $siteInfo = DB::table('SiteInfo')->select('SiteInfo.*')->first();

        return view('Site.SiteInfo.aboutus', compact('homeSetting', 'relatedSearch', 'specialPage', 'siteInfo'));
    }

    public function Sitemap()
    {
        $stores = DB::table('Store')->select('StoreId', 'Name', 'Enabled', 'Header1', 'LogoUrl', 'SearchName', 'Enabled', 'Description1')->get();
        $categories = DB::table('Category')->select('Category.*')->orderBy('Name', 'ASC')->get();
        $specialPage = CacheHelper::instance()->GetSpecialPage();

        return view('Site.SiteInfo.sitemap', compact('stores', 'categories', 'specialPage'));
    }
}
