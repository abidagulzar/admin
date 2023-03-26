<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store;
use App\Category;
use App\Country;
use App\Network;
use App\RevenueModel;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\StoreCategory;
use App\StoreCountry;
use App\StoreExcludeCountry;
use App\StoreSetting;
use App\StoreSimilar;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use App\User;

class StoreController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Store View|Store Create|Store Edit|Store Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Store Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Store Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Store Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {

            $networkIds = explode(",", $request->get('NetworkId'));
            // $data = DB::table('Store')->select('Store.RegionalName', 'Store.StoreId', 'Store.Name', 'Store.Enabled', 'Store.LogoUrl', 'Store.SearchName', 'Store.Enabled', 'Store.IsHomeStore', 'Store.LastCouponAdded', 'Store.CreateDate', 'Store.StoreUpdateFrequency', 'LastCouponAddByUser.Name As LastCouponAddByName', 'CreatedBy.Name As CreatedByUser', 'Network.Name as NetworkName', 'RevenueModel.Name as RevenueModelName')->leftJoin('users as LastCouponAddByUser', 'Store.LastCouponAddedBy', '=', 'LastCouponAddByUser.id')->leftJoin('users as CreatedBy', 'Store.CreatedByUserId', '=', 'CreatedBy.id')->leftJoin('Network', 'Store.NetworkId', '=', 'Network.NetworkId')->leftJoin('RevenueModel', 'Store.RevenueModelID', '=', 'RevenueModel.RevenueModelID')->whereIn('Store.NetworkId', $networkIds)->orderBy('Store.CreateDate', 'DESC')->get();


            $data = DB::select("select store.RegionalName,store.StoreNetworkName, store.StoreId, 
            store.Name, store.Enabled, store.LogoUrl, store.SearchName, store.Enabled, store.IsHomeStore,
             store.LastCouponAdded, store.CreateDate, store.StoreUpdateFrequency,
             lastCouponAddByUser.Name As LastCouponAddByName, createdBy.Name As CreatedByUser, network.Name as NetworkName,
             revenueModel.Name as RevenueModelName, ifnull(couponCount.CouponsCount,0) As CouponsCount
             from Store store
             left join users lastCouponAddByUser on store.LastCouponAddedBy = lastCouponAddByUser.id
             left join users as createdBy on store.CreatedByUserId = createdBy.id
             left join Network as network on store.NetworkId = network.NetworkId
             left join RevenueModel as revenueModel on store.RevenueModelID = revenueModel.RevenueModelID
             left join (select StoreId, count(*) CouponsCount from Coupon Group by StoreId) couponCount
             on store.StoreId = couponCount.StoreId
             order by store.StoreId desc");


            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        $network = Network::all()->pluck('Name', 'NetworkId')->toArray();
        return view('Admin.Store.index', [
            'network' => $network,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();
        $networks = Network::all()->pluck('Name', 'NetworkId')->toArray();
        $storeSettings = StoreSetting::all()->pluck('RegionName', 'StoreSettingId')->toArray();
        $revenueModels = RevenueModel::all()->pluck('Name', 'RevenueModelID')->toArray();
        $storesList = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $users = User::all()->pluck('name', 'id')->toArray();

        return view('Admin.Store.create', [
            'categories' => $categories,
            'countries' => $countries,
            'networks' => $networks,
            'storeSettings' => $storeSettings,
            'revenueModels' => $revenueModels,
            'users' => $users,
            'storesList' => $storesList
        ]);
    }

    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Keyword' => 'required',
                'SiteUrl' => 'required',
                'StoreNetworkLink' => 'required',
                'CategoryId' => 'required'
            ]);

            $data = $request->all();
            $model = new Store($data);

            $model->SetSearchName();
            $model->SEOStoreName = $request->get('Name');
            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {

                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl->storeAs('/storelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('storelogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $fileLogoUrl600X400 = $request->file('LogoUrl600X400');
            if (isset($fileLogoUrl600X400)) {

                $guessExtension =  $fileLogoUrl600X400->guessExtension();

                $saveNameLogoUrl600X400 = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl600X400->storeAs('/storelogo', $saveNameLogoUrl600X400);
                AppHelper::instance()->MoveToPublicFolder('storelogo', $saveNameLogoUrl600X400);
                $model->LogoUrl600X400 = $saveNameLogoUrl600X400;
            }

            $model->CreatedByUserId = Auth::user()->id;
            $model->CreateDate = new DateTime();

            if ($request->input('SimilarStoreId') !== null && count($request->input('SimilarStoreId')) > 0) {
                $model->IsHasSimilarStore = 1;
            } else {
                $model->IsHasSimilarStore = 0;
            }

            if ($model->save()) {
                $model->Category()->syncWithoutDetaching($request->input('CategoryId'));
                $model->Country()->syncWithoutDetaching($request->input('CountryId'));
                $model->ExludeCountry()->syncWithoutDetaching($request->input('ExcludeCountryId'));
                $model->StoreSimilar()->syncWithoutDetaching($request->input('SimilarStoreId'));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Store with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Store with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        CacheHelper::instance()->ResetTopStore();

        return redirect()->route('admin.store.index')
            ->with('success', 'Store created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('StoreId'));

        $storeCategories = StoreCategory::whereIn('StoreId', $ids);
        $storeCategories->delete();

        $storeCountries = StoreCountry::whereIn('StoreId', $ids);
        $storeCountries->delete();

        $storeExcludeCountries = StoreExcludeCountry::whereIn('StoreId', $ids);
        $storeExcludeCountries->delete();

        $storeSimilar = StoreSimilar::whereIn('StoreId', $ids);
        $storeSimilar->delete();


        $store = Store::whereIn('StoreId', $ids);

        $store->delete();
        CacheHelper::instance()->ResetTopStore();
        return redirect()->route('admin.store.index')
            ->with('success', 'Store deleted successfully');
    }

    public function edit($id)
    {
        $where = array('StoreId' => $id);
        $store = Store::where($where)->first();

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();
        $storecategories = StoreCategory::where($where)->pluck('CategoryId')->toArray();
        $storeExcludeCountries = StoreExcludeCountry::where($where)->pluck('CountryId')->toArray();
        $storeCountries = StoreCountry::where($where)->pluck('CountryId')->toArray();
        $networks = Network::all()->pluck('Name', 'NetworkId')->toArray();
        $storeSettings = StoreSetting::all()->pluck('RegionName', 'StoreSettingId')->toArray();
        $revenueModels = RevenueModel::all()->pluck('Name', 'RevenueModelID')->toArray();
        $users = User::all()->pluck('name', 'id')->toArray();
        $storesList = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $similarstores = StoreSimilar::where($where)->pluck('SimilarStoreId')->toArray();

        return view('Admin.Store.edit', [
            'categories' => $categories,
            'countries' => $countries,
            'Model' => $store,
            'storecategories' => $storecategories,
            'storeCountries' => $storeCountries,
            'networks' => $networks,
            'storeSettings' => $storeSettings,
            'storeExcludeCountries' => $storeExcludeCountries,
            'revenueModels' => $revenueModels,
            'users' => $users,
            'storesList' => $storesList,
            'similarstores' => $similarstores
        ]);
    }

    public function storeInfo($id)
    {
        $where = array('StoreId' => $id);
        $store = Store::where($where)->first();

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();
        $storecategories = StoreCategory::where($where)->pluck('CategoryId')->toArray();
        $storeCountries = StoreCountry::where($where)->pluck('CountryId')->toArray();

        return view('Admin.Store.storeInfo', [
            'categories' => $categories,
            'countries' => $countries,
            'Model' => $store,
            'storeCountries' => $storeCountries,
            'storecategories' => $storecategories
        ]);
    }


    public function updatepost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Keyword' => 'required',
                'SiteUrl' => 'required',
                'StoreNetworkLink' => 'required',
                'CategoryId' => 'required'
            ]);


            $model = Store::find($request->get('StoreId'));

            $model->Name =  $request->get('Name');
            $model->SEOStoreName = $request->get('SEOStoreName');
            $model->SiteUrl =  $request->get('SiteUrl');
            $model->StoreNetworkLink =  $request->get('StoreNetworkLink');
            $model->Enabled =  $request->get('Enabled');
            $model->IsTopStore =  $request->get('IsTopStore');
            $model->IsShowAdd =  $request->get('IsShowAdd');
            $model->IsHomeStore =  $request->get('IsHomeStore');

            $model->Header1 =  $request->get('Header1');
            $model->Description1 =  $request->get('Description1');
            $model->Header2 =  $request->get('Header2');
            $model->Description2 =  $request->get('Description2');
            $model->Header3 =  $request->get('Header3');
            $model->Description3 =  $request->get('Description3');
            $model->Header4 =  $request->get('Header4');
            $model->Description4 =  $request->get('Description4');
            $model->Header5 =  $request->get('Header5');
            $model->Description5 =  $request->get('Description5');

            $model->Keyword =  $request->get('Keyword');
            $model->MetaTitle =  $request->get('MetaTitle');
            $model->MetaDescription =  $request->get('MetaDescription');
            $model->MetaKeyword =  $request->get('MetaKeyword');
            $model->NetworkId =  $request->get('NetworkId');
            $model->ContentLinkText =  $request->get('ContentLinkText');
            $model->RelatedSearches =  $request->get('RelatedSearches');
            $model->StoreSettingID =  $request->get('StoreSettingID');
            $model->RegionalName =  $request->get('RegionalName');
            $model->RelatedStoresText =  $request->get('RelatedStoresText');
            $model->FooterText =  $request->get('FooterText');

            $model->DefaultContentKeywords =  $request->get('DefaultContentKeywords');
            $model->RelatedStoreKeywords =  $request->get('RelatedStoreKeywords');
            $model->FooterKeywords =  $request->get('FooterKeywords');
            $model->RevenueModelID =  $request->get('RevenueModelID');
            $model->StoreUpdateFrequency = $request->get('StoreUpdateFrequency');
            $model->UserAssignedID = $request->get('UserAssignedID');
            $model->StoreNetworkName = $request->get('StoreNetworkName');
            $model->MerchantID = $request->get('MerchantID');
            $model->QAKeywords = $request->get('QAKeywords');

            $model->SetSearchName();

            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {

                $md5Name = md5_file($fileLogoUrl->getRealPath());
                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl->storeAs('/storelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('storelogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $fileLogoUrl600X400 = $request->file('LogoUrl600X400');
            if (isset($fileLogoUrl600X400)) {

                $md5Name = md5_file($fileLogoUrl600X400->getRealPath());
                $guessExtension =  $fileLogoUrl600X400->guessExtension();

                $saveNameLogoUrl600X400 = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl600X400->storeAs('/storelogo', $saveNameLogoUrl600X400);
                AppHelper::instance()->MoveToPublicFolder('storelogo', $saveNameLogoUrl600X400);
                $model->LogoUrl600X400 = $saveNameLogoUrl600X400;
            }

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();



            if ($request->input('SimilarStoreId') !== null && count($request->input('SimilarStoreId')) > 0) {
                $model->IsHasSimilarStore = 1;
            } else {
                $model->IsHasSimilarStore = 0;
            }
            if ($model->save()) {
                $model->Category()->sync($request->input('CategoryId'));
                $model->Country()->sync($request->input('CountryId'));
                $model->ExludeCountry()->sync($request->input('ExcludeCountryId'));
                $model->StoreSimilar()->sync($request->input('SimilarStoreId'));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Store with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Store with this Name already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        CacheHelper::instance()->ResetTopStore();
        return redirect()->route('admin.store.index')
            ->with('success', 'Store updated successfully.');
    }
}
