<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Store;
use App\Category;
use App\Country;
use App\CPCStore;
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

class CPCStoreController extends Controller
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

            $countryIds = $request->get('CountryId');
            $filter = "";
            if (!is_null($countryIds))
                $filter = " where cpcStore.CountryId in (" . $countryIds . ")";


            $data = DB::select("select cpcStore.CPCStoreId, cpcStore.Commission, store.RegionalName,country.Name as CountryName,
            cpcStore.TrackURL
            from CPCStore cpcStore 
            left join Store store on cpcStore.StoreId = store.StoreId
            left join Country country on cpcStore.CountryId = country.CountryId" . $filter);

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();
        return view('Admin.CPCStore.index', [
            'countries' => $countries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();

        return view('Admin.CPCStore.create', [
            'stores' => $stores,
            'countries' => $countries
        ]);
    }

    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'StoreId' => 'required',
                'CountryId' => 'required'
            ]);

            $storeId = $request->get('StoreId');
            $countries =  $request->get('CountryId');
            $commission = $request->get('Commission');
            $trackURL = $request->get('TrackURL');

            $cpcstore = CPCStore::where('StoreId', $storeId)->whereIn('CountryId', $countries);
            $cpcstore->delete();

            foreach ($countries as $country) {

                $model = new CPCStore();

                $model->StoreId = $storeId;
                $model->CountryId = $country;
                $model->TrackURL =  $trackURL;
                $model->Commission = $commission;

                $model->save();
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

        return redirect()->route('admin.cpcstore.index')
            ->with('success', 'Store created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('CPCStoreId'));

        $store = CPCStore::whereIn('CPCStoreId', $ids);

        $store->delete();

        return redirect()->route('admin.cpcstore.index')
            ->with('success', 'CPC Store deleted successfully');
    }

    public function edit($id)
    {
        $where = array('CPCStoreId' => $id);
        $cpcStore = CPCStore::where($where)->first();

        $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();



        return view('Admin.CPCStore.edit', [
            'stores' => $stores,
            'countries' => $countries,
            'Model' => $cpcStore
        ]);
    }



    public function updatepost(Request $request)
    {
        try {
            $request->validate([
                'CPCStoreId' => 'required',
                'Commission' => 'required',
                'TrackURL' => 'required'
            ]);


            $id = $request->get('CPCStoreId');

            $where = array('CPCStoreId' => $id);
            $model = CPCStore::where($where)->first();


            $model->TrackURL =  $request->get('TrackURL');
            $model->Commission = $request->get('Commission');

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {

            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {

            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }

        CacheHelper::instance()->ResetTopStore();
        return redirect()->route('admin.cpcstore.index')
            ->with('success', 'CPC Store updated successfully.');
    }
}
