<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Network;
use App\StoreVisitor;
use App\User;


use DataTables;
use DateTime;
use DB;
use Hash;


class StoreVisitorAnalysisController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Visitor View', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            //$data = DB::select("Select Store.Name As StoreName, StoreVisitor.TotalVisitor, Network.Name As NetworkName, Store.LastCouponAdded from (select count(*) TotalVisitor, StoreId from StoreVisitor where IP not in (select distinct IP from ExcludeTrafficIP) and DATE(StoreVisitor.CreateDate) between '2020-03-12' AND '2020-03-12' group by StoreId) StoreVisitor left join Store on StoreVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId = Network.NetworkId where Store.NetworkId in (1) order by StoreVisitor.TotalVisitor Desc");

            $data = DB::select("Select Store.RegionalName As StoreName,
            Store.StoreNetworkLink As StoreNetworkLink, 
            StoreVisitor.TotalVisitor,
            Network.Name As NetworkName,
            Store.LastCouponAdded 
            from (select count(distinct IP) TotalVisitor, StoreId from StoreVisitor 
            where IP not in (select distinct IP from ExcludeTrafficIP)
            and DATE(StoreVisitor.CreateDate) between :StartDate AND :EndDate
            group by StoreId) StoreVisitor 
            left join Store on StoreVisitor.StoreId = Store.StoreId 
            left join Network on Store.NetworkId = Network.NetworkId
            where Store.NetworkId in (:NetworkId) order by StoreVisitor.TotalVisitor Desc", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "NetworkId" => $request->get('NetworkId')]);



            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        $network = Network::all()->pluck('Name', 'NetworkId')->toArray();

        $ips = StoreVisitor::select('IP')->distinct()->get();
        return view('Admin.StoreVisitorAnalysis.index', [
            'network' => $network
        ]);
    }
}
