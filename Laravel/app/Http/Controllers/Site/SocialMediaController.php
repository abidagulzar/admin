<?php

namespace App\Http\Controllers\Site;

use App\CPCStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\SocialMedia;
use App\StoreExcludeCountry;
use App\StoreVisitor;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class SocialMediaController extends Controller
{

    public function socialOffer($socialMediaID = null)
    {
        $socialMediaEntity = SocialMedia::find($socialMediaID);

        if ($socialMediaEntity !== null) {

            $store = DB::table('Store')->select(
                'StoreId',
                'Name',
                'Header1',
                'Description5',
                'SiteUrl',
                'LogoUrl',
                'MetaTitle',
                'MetaDescription',
                'MetaKeyword',
                'StoreNetworkLink',
                'Header5',
                'Description1',
                'Header2',
                'Description2',
                'Header3',
                'Description3',
                'Header4',
                'Description4',
                'SearchName',
                'Keyword',
                'LogoUrl600X400',
                'LastCouponAdded',
                'SEOStoreName',
                'StoreSettingID',
                'ContentLinkText',
                'RelatedSearches',
                'RegionalName',
                'FooterText',
                'RelatedStoresText',
                'DefaultContentKeywords',
                'RelatedStoreKeywords',
                'FooterKeywords',
                'IsShowAdd',
                'NetworkId',
                'IsHasSimilarStore'

            )->where('StoreId', $socialMediaEntity->StoreId)->first();


            $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
            $specialPage = CacheHelper::instance()->GetSpecialPage();
            $customRelatedSearch = null;

            $storeSetting = CacheHelper::instance()->GetStoreSettingWithId($store->StoreSettingID);

            //  try {
            $storeSetting->Footer = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->Footer, $storeSetting->FooterKeywords, $store->FooterKeywords);

            if ($store->MetaTitle == null || trim($store->MetaTitle) == '') {
                $storeSetting->Title = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->Title, '@storename', $store->SEOStoreName);
            } else {
                $storeSetting->Title = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->MetaTitle, '@storename', $store->SEOStoreName);
            }
            if ($store->MetaDescription == null || trim($store->MetaDescription) == '') {
                $storeSetting->Description = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->Description, '@storename', $store->SEOStoreName);
            } else {
                $storeSetting->Description = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->MetaDescription, '@storename', $store->SEOStoreName);
            }
            if ($store->MetaKeyword == null || trim($store->MetaKeyword) == '') {
                $storeSetting->Keywords = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->Keywords, '@storename', $store->SEOStoreName);
            } else {
                $storeSetting->Keywords = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->MetaKeyword, '@storename', $store->SEOStoreName);
            }

            if ($store->RelatedStoresText == null || trim($store->RelatedStoresText) == '') {
                $storeSetting->RelatedStoresText = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->RelatedStoresText, '@storename', $store->SEOStoreName);
            } else {
                $storeSetting->RelatedStoresText = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->RelatedStoresText, '@storename', $store->SEOStoreName);
            }

            $storeSetting->Footer = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->Footer, '@storename', $store->SEOStoreName);

            $ip = geoip()->getClientIP();
            $countryIdResult = DB::select("select GetCountryId(?) As CountryId", [$ip]);


            $countryId = 0;
            if (isset($countryIdResult))
                $countryId = $countryIdResult[0]->CountryId;


            $trueCountry = 1;
            $where = array('StoreId' => $store->StoreId);
            $storeExcludeCountries = StoreExcludeCountry::where($where)->pluck('CountryId')->toArray();

            if ($countryId != 0 && count($storeExcludeCountries) > 0 && in_array($countryId, $storeExcludeCountries)) {
                $trueCountry = 0;
            }

            $relatedStores = DB::table('Store')->select('SearchName', 'SEOStoreName')
                ->whereIn('StoreId', function ($query) use ($store) {
                    $query->select('StoreId')
                        ->whereIn('CategoryId', function ($query2) use ($store) {
                            $query2->select('CategoryId')
                                ->where('StoreId', $store->StoreId)
                                ->from('StoreCategory')
                                ->get();
                        })
                        ->from('StoreCategory')

                        ->get();
                })
                ->limit(5)
                ->get();

            $storeCoupons = DB::table('Coupon')->leftJoin('Country', 'Coupon.CountryId', '=', 'Country.CountryId')->select('Coupon.*', 'Country.Name As CountryName')->Where('Coupon.StoreId', $store->StoreId)->where(function ($query) {
                $query->where('Coupon.Expired', '!=', 1)->orWhereNull('Coupon.Expired');
            })->where(function ($query) {
                $query->where('Coupon.ExpiryDate', '>=', \DB::raw('DATE_SUB(NOW(), INTERVAL 36 HOUR)'))
                    ->orWhereNull('Coupon.ExpiryDate');
            })->orderBy('Coupon.StoreRank', 'ASC')->limit(2)->get();

            $cpcStores = null;

            $cpcStores = DB::table('CPCStore')->leftJoin('Store', 'CPCStore.StoreId', '=', 'Store.StoreId')->select('CPCStore.*', 'Store.*')->Where('CPCStore.CountryId', $countryId)->limit(30)->orderBy('Commission', 'desc')->get();

            if (isset($store->RelatedSearches)) {
                $store->RelatedSearches = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->RelatedSearches, '@storename', $store->SEOStoreName);
                $customRelatedSearch = explode(",", $store->RelatedSearches);
            } else if (isset($storeSetting->RelatedSearches)) {

                $customRelatedSearch = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->RelatedSearches, '@storename', $store->SEOStoreName);
                $customRelatedSearch = explode(",", $customRelatedSearch);
            }
            $globalOffers = DB::table('Coupon')->select('*')->where('IsGlobalOffer',  1)->get();

            return view('Site.SocialMedia.socialOffer', compact('storeSetting', 'relatedSearch', 'store', 'specialPage', 'storeCoupons', 'relatedStores', 'customRelatedSearch', 'trueCountry', 'cpcStores', 'globalOffers', 'socialMediaEntity'));
        } else {

            $homeSetting = CacheHelper::instance()->GetHomeSetting();
            $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
            $specialPage = CacheHelper::instance()->GetSpecialPage();
            return view('Site.Shared.404', compact('homeSetting', 'relatedSearch', 'specialPage'));
        }

        return redirect()->route('site.home');
    }
}
