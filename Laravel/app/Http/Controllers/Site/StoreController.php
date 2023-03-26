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

class StoreController extends Controller
{
    public function CheckError($storeSearchName = null)
    {

        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();
        $customRelatedSearch = null;

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
            'NetworkId'

        )->where('SearchName', $storeSearchName)->first();


        if (isset($store)) {
            $storeSetting = CacheHelper::instance()->GetStoreSettingWithId($store->StoreSettingID);

            //  try {
            $storeSetting->DefaultContent = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->DefaultContent, $storeSetting->DefaultContentKeywords, $store->DefaultContentKeywords);
            $storeSetting->RelatedStoresText = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->RelatedStoresText, $storeSetting->RelatedStoreKeywords, $store->RelatedStoreKeywords);
            $storeSetting->Footer = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->Footer, $storeSetting->FooterKeywords, $store->FooterKeywords);
            $storeSetting->DefaultQA = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->DefaultQA, $storeSetting->QAKeywords, $store->QAKeywords);


            $storeSetting->DefaultDealText = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultDealText, '@storename', $store->SEOStoreName);

            try {

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
                    ->limit(10)
                    ->get();


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
                $storeSetting->DefaultContent = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultContent, '@storename', $store->SEOStoreName);

                $store->Header1 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header1, '@storename', $store->SEOStoreName);
                $store->Header2 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header2, '@storename', $store->SEOStoreName);
                $store->Header3 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header3, '@storename', $store->SEOStoreName);
                $store->Header4 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header4, '@storename', $store->SEOStoreName);
                $store->Header5 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header5, '@storename', $store->SEOStoreName);
                $store->Description1 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description1, '@storename', $store->SEOStoreName);
                $store->Description2 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description2, '@storename', $store->SEOStoreName);
                $store->Description3 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description3, '@storename', $store->SEOStoreName);
                $store->Description4 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description4, '@storename', $store->SEOStoreName);
                $store->Description5 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description5, '@storename', $store->SEOStoreName);

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


                $storeCoupons = DB::table('Coupon')->leftJoin('Country', 'Coupon.CountryId', '=', 'Country.CountryId')->select('Coupon.*', 'Country.Name As CountryName')->Where('Coupon.StoreId', $store->StoreId)->where(function ($query) {
                    $query->where('Coupon.Expired', '!=', 1)->orWhereNull('Coupon.Expired');
                })->where(function ($query) {
                    $query->where('Coupon.ExpiryDate', '>=', \DB::raw('DATE_SUB(NOW(), INTERVAL 36 HOUR)'))
                        ->orWhereNull('Coupon.ExpiryDate');
                })->orderBy('Coupon.StoreRank', 'ASC')->get();

                $cpcStores = null;

                if ($store->NetworkId == 13 || $store->NetworkId == 6) {

                    $cpcStores = DB::table('Store')->select('Name', 'StoreNetworkLink')
                        ->where('RevenueModelID', 2)
                        ->where('NetworkId', 2)
                        ->whereIn('StoreId', function ($query) use ($countryId) {
                            $query->select('StoreId')
                                ->from('StoreCountry')
                                ->where('CountryId', $countryId)
                                ->get();
                        })
                        ->limit(30)
                        ->get();

                    if (count($storeCoupons) > 0 & count($cpcStores) > 0) {

                        foreach ($storeCoupons as $c) {
                            $shuffled = $cpcStores->shuffle();
                            $c->CouponUrl = $shuffled[0]->StoreNetworkLink;
                        }
                    }
                }

                $headerdeal = $storeCoupons->Where('IsHeaderDeal', 1)->first();

                $distinctCountries = array();
                foreach ($storeCoupons as $c) {
                    $distinctCountries[$c->CountryId] = $c; // Get unique country by code.
                }



                $similarStoreCoupons12 = DB::select("WITH order_values AS(
                SELECT 
                    RANK() OVER (
                        PARTITION BY c.StoreId
                        ORDER BY c.CouponId DESC
                    ) order_value_rank
                FROM
                    Coupon c left join Store s
                    on c.StoreId = s.StoreId
                    where c.StoreId in(
                    Select SimilarStoreId from StoreSimilar
                    )   
            )
            SELECT 
                * 
            FROM 
                order_values
                Where order_value_rank < 3", ["StoreId" => $store->StoreId]);


                $similarStoreCoupons = DB::select("WITH order_values AS(
                SELECT 
             c.CouponId123, 
             c.CouponUrl,
             c.Header,
             c.Code,
             c.OFF,
             c.ExpiryDate,
             c.IsUnknownOutGoing,
             s.SEOStoreName,
             s.LogoUrl,
             s.StoreId,
                    RANK() OVER (
                        PARTITION BY c.StoreId
                        ORDER BY c.CouponId DESC
                    ) order_value_rank
                FROM
                    Coupon c left join Store s
                    on c.StoreId = s.StoreId
                    where c.StoreId in(
                    Select SimilarStoreId from StoreSimilar
                    where StoreId = :StoreId 
                    )   
            )
            SELECT 
                * 
            FROM 
                order_values
                Where order_value_rank < 3", ["StoreId" => $store->StoreId]);

                //print_r($similarStoreCoupons);
                //$this->LogStoreVisitor($store);

                if (isset($store->RelatedSearches)) {
                    $store->RelatedSearches = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->RelatedSearches, '@storename', $store->SEOStoreName);
                    $customRelatedSearch = explode(",", $store->RelatedSearches);
                } else if (isset($storeSetting->RelatedSearches)) {

                    $customRelatedSearch = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->RelatedSearches, '@storename', $store->SEOStoreName);
                    $customRelatedSearch = explode(",", $customRelatedSearch);
                }


                return view('Site.Store.storedetail', compact('storeSetting', 'relatedSearch', 'store', 'specialPage', 'storeCoupons', 'relatedStores', 'headerdeal', 'customRelatedSearch', 'trueCountry', 'distinctCountries', 'cpcStores', 'similarStoreCoupons'));
            } catch (\Exception $e) {

                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();

                return  view('Site.Store.error', compact('storeSetting', 'store', 'errorCode', 'errorMessage'));
            }
        } else {

            $homeSetting = CacheHelper::instance()->GetHomeSetting();
            $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
            $specialPage = CacheHelper::instance()->GetSpecialPage();
            return view('Site.Shared.404', compact('homeSetting', 'relatedSearch', 'specialPage'));
        }

        return redirect()->route('site.home');
    }
    public function storeList($keyword = null)
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();


        // For Master Page Data

        if ($keyword == null)
            $keyword = 'A';

        if ($keyword == 'num')
            $stores = DB::table('Store')->select('StoreId', 'Name', 'Enabled', 'Header1', 'LogoUrl', 'SearchName', 'Enabled', 'Description1')->where('Name', 'REGEXP', '^[0-9]')->orderBy('Name', 'ASC')->get();
        else
            $stores = DB::table('Store')->select('StoreId', 'Name', 'Enabled', 'Header1', 'LogoUrl', 'SearchName', 'Enabled', 'Description1')->where('Name', 'like', $keyword . '%')->orderBy('Name', 'ASC')->get();

        return view('Site.Store.storelist', compact('homeSetting', 'relatedSearch', 'stores', 'specialPage'));
    }

    public function storeDetail($storeSearchName = null)
    {

        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();
        $customRelatedSearch = null;
        // For Master Page Data
        //$store = CacheHelper::instance()->GetStoreFromCache($storeSearchName);

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
            'IsHasSimilarStore',
            'QAKeywords'

        )->where('SearchName', $storeSearchName)->first();


        if (isset($store)) {
            $storeSetting = CacheHelper::instance()->GetStoreSettingWithId($store->StoreSettingID);

            //  try {
            $storeSetting->DefaultContent = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->DefaultContent, $storeSetting->DefaultContentKeywords, $store->DefaultContentKeywords);
            $storeSetting->RelatedStoresText = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->RelatedStoresText, $storeSetting->RelatedStoreKeywords, $store->RelatedStoreKeywords);
            $storeSetting->Footer = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->Footer, $storeSetting->FooterKeywords, $store->FooterKeywords);
            //$storeSetting->DefaultQA = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultQA, '@storename', $store->SEOStoreName);
            $storeSetting->DefaultQA = AppHelper::instance()->ReplaceSEOKeywords($storeSetting->DefaultQA, $storeSetting->QAKeywords, $store->QAKeywords);


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
                ->limit(15)
                ->get();


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

            if ($store->Header1 == null || trim($store->Header1) == '') {
                $store->Header1 = $storeSetting->Header1;
            }

            $storeSetting->Footer = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->Footer, '@storename', $store->SEOStoreName);
            $storeSetting->DefaultContent = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultContent, '@storename', $store->SEOStoreName);
            $storeSetting->DefaultQA = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultQA, '@storename', $store->SEOStoreName);


            $store->Header1 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header1, '@storename', $store->SEOStoreName);
            $store->Header2 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header2, '@storename', $store->SEOStoreName);
            $store->Header3 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header3, '@storename', $store->SEOStoreName);
            $store->Header4 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header4, '@storename', $store->SEOStoreName);
            $store->Header5 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Header5, '@storename', $store->SEOStoreName);
            $store->Description1 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description1, '@storename', $store->SEOStoreName);
            $store->Description2 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description2, '@storename', $store->SEOStoreName);
            $store->Description3 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description3, '@storename', $store->SEOStoreName);
            $store->Description4 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description4, '@storename', $store->SEOStoreName);
            $store->Description5 = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->Description5, '@storename', $store->SEOStoreName);

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

            $storeCoupons = DB::table('Coupon')->leftJoin('Country', 'Coupon.CountryId', '=', 'Country.CountryId')->select('Coupon.*', 'Country.Name As CountryName')->Where('Coupon.StoreId', $store->StoreId)->Where('Coupon.Enabled', 1)->where(function ($query) {
                $query->where('Coupon.Expired', '!=', 1)->orWhereNull('Coupon.Expired');
            })->where(function ($query) {
                $query->where('Coupon.ExpiryDate', '>=', \DB::raw('DATE_SUB(NOW(), INTERVAL 36 HOUR)'))
                    ->orWhereNull('Coupon.ExpiryDate');
            })->orderBy('Coupon.StoreRank', 'ASC')->orderBy('Coupon.CouponId', 'DESC')->get();

            $cpcStores = null;


            // Offline and No Network Stores
            if ($store->NetworkId == 13 || $store->NetworkId == 6) {
                //$countryId = 1;
                //  $cpcStores =  CPCStore::where('CountryId', $countryId)->limit(30)->orderBy('Commission', 'desc')->get();

                $cpcStores = DB::table('CPCStore')->leftJoin('Store', 'CPCStore.StoreId', '=', 'Store.StoreId')->select('CPCStore.*', 'Store.*')->Where('CPCStore.CountryId', $countryId)->limit(30)->orderBy('Commission', 'desc')->get();

                foreach ($cpcStores as $str) {
                    $str->DealHeader = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultDealText, '@storename', $str->SEOStoreName);
                }
                if (count($storeCoupons) > 0 & count($cpcStores) > 0) {
                    $i = 0;
                    $totalCPCStore = count($cpcStores);
                    $shuffled = $cpcStores->shuffle();
                    $shuffled->all();
                    foreach ($storeCoupons as $c) {
                        $c->CouponUrl = $shuffled[$i]->TrackURL;
                        $c->CPCStoreId = $shuffled[$i]->StoreId;
                        $i++;

                        if ($i >= $totalCPCStore) {
                            $i = 0;
                        }
                    }
                }
            } else {
                $storeSetting->DefaultDealText = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->DefaultDealText, '@storename', $store->SEOStoreName);
            }

            $headerdeal = $storeCoupons->Where('IsHeaderDeal', 1)->first();

            $distinctCountries = array();
            foreach ($storeCoupons as $c) {
                $distinctCountries[$c->CountryId] = $c; // Get unique country by code.
            }
            $similarStoreCoupons = new Collection();
            if ($store->IsHasSimilarStore == 1) {
                $similarStoreCoupons = DB::select("WITH order_values AS(
                SELECT 
             c.CouponId, 
             c.CouponUrl,
             c.Header,
             c.Code,
             c.OFF,
             c.ExpiryDate,
             c.IsUnknownOutGoing,
             s.SEOStoreName,
             s.LogoUrl,
             s.StoreId,
                    RANK() OVER (
                        PARTITION BY c.StoreId
                        ORDER BY c.CouponId DESC
                    ) order_value_rank
                FROM
                    Coupon c left join Store s
                    on c.StoreId = s.StoreId
                    where c.StoreId in(
                    Select SimilarStoreId from StoreSimilar
                    where StoreId = :StoreId 
                    )   
            )
            SELECT 
                * 
            FROM 
                order_values
                Where order_value_rank < 6", ["StoreId" => $store->StoreId]);
            }

            if (isset($store->RelatedSearches)) {
                $store->RelatedSearches = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $store->RelatedSearches, '@storename', $store->SEOStoreName);
                $customRelatedSearch = explode(",", $store->RelatedSearches);
            } else if (isset($storeSetting->RelatedSearches)) {

                $customRelatedSearch = AppHelper::instance()->ReplaceSystemKeywordsWithStoreSettings($storeSetting, $storeSetting->RelatedSearches, '@storename', $store->SEOStoreName);
                $customRelatedSearch = explode(",", $customRelatedSearch);
            }
            $globalOffers = DB::table('Coupon')->select('*')->where('IsGlobalOffer',  1)->get();

            if ($store->NetworkId == 13 || $store->NetworkId == 6) {
                return view('Site.Store.offlineStoredetail', compact('storeSetting', 'relatedSearch', 'store', 'specialPage', 'storeCoupons', 'relatedStores', 'headerdeal', 'customRelatedSearch', 'trueCountry', 'distinctCountries', 'cpcStores', 'similarStoreCoupons', 'globalOffers', 'cpcStores'));
            } else {
                return view('Site.Store.storedetail', compact('storeSetting', 'relatedSearch', 'store', 'specialPage', 'storeCoupons', 'relatedStores', 'headerdeal', 'customRelatedSearch', 'trueCountry', 'distinctCountries', 'cpcStores', 'similarStoreCoupons', 'globalOffers'));
            }
        } else {

            $homeSetting = CacheHelper::instance()->GetHomeSetting();
            $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
            $specialPage = CacheHelper::instance()->GetSpecialPage();
            return view('Site.Shared.404', compact('homeSetting', 'relatedSearch', 'specialPage'));
        }

        return redirect()->route('site.home');
    }

    private function LogStoreVisitor($store)
    {
        $ip = geoip()->getClientIP();

        try {
            $storeVisitor = new StoreVisitor();
            $storeVisitor->StoreId = $store->StoreId;
            $storeVisitor->Location = "";
            $storeVisitor->IP =  $ip;
            if (request()->headers->get('referer') != null) {
                $storeVisitor->ReferedFrom = request()->headers->get('referer');
            }
            $storeVisitor->CreateDate = new DateTime();

            $storeVisitor->save();
        } catch (\Exception $e) {
        }
    }
}
