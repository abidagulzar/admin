<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Store;
use Illuminate\Http\Request;
use DataTables;
use Redirect;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {


        return view('Admin.Dashboard.index');
    }

    public function loadVisitorsMap(Request $request)
    {

        DB::update('Update `StoreVisitor` set `Location` = GetCountry(IP),`CountryCode` = GetCountryCode(IP) where `CountryCode` is null or `Location` is NULL;');
        DB::update('Update `CouponVisitor` set `Location` = GetCountry(IP),`CountryCode` = GetCountryCode(IP) where `CountryCode` is null or `Location` is NULL;');

        DB::update('Update `StoreVisitor` set IsProcessed = 2 where IsProcessed = 0 and IP in ( select IP from ExcludeTrafficIP where 1=1 )');
        DB::delete('Delete from StoreVisitor Where IsProcessed = 2');

        DB::update('Update `CouponVisitor` set IsProcessed = 2 where IsProcessed = 0 and IP in ( select IP from ExcludeTrafficIP where 1=1 )');
        DB::delete('Delete from CouponVisitor Where IsProcessed = 2');

        $startDate = $request->get('StartDate');
        $endDate = $request->get('EndDate');
        $data = DB::select("Select count(*) As Visitors, 
            GetCountryUserActivity(CountryCode,DATE('" . $startDate . "'),DATE('" . $endDate . "')) As UserActivity , 
            `Location`,`CountryCode` FROM `StoreVisitor` where DATE(StoreVisitor.CreateDate) between DATE('" . $startDate . "') AND DATE('" . $endDate . "') GROUP by `Location`,`CountryCode` order by Visitors desc", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate')]);

        return $data;
    }

    public function loadVisitorsTable(Request $request)
    {
        $startDate = $request->get('StartDate');
        $endDate = $request->get('EndDate');
        $data = DB::select("Select count(*) As Visitors, 
        GetCountryUserActivity(CountryCode,DATE('" . $startDate . "'),DATE('" . $endDate . "')) As UserActivity , 
        `Location`,`CountryCode` FROM `StoreVisitor` where DATE(StoreVisitor.CreateDate) between DATE('" . $startDate . "') AND DATE('" . $endDate . "') GROUP by `Location`,`CountryCode` order by Visitors desc LIMIT 10", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate')]);

        return view('Admin.Dashboard.dashboardTablePartial', [
            'Visitorsdata' => $data
        ]);
    }
}
