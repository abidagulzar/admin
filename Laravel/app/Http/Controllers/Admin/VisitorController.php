<?php

namespace App\Http\Controllers\Admin;

use App\CouponVisitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Network;
use App\StoreVisitor;
use App\Store;


use DataTables;
use DateTime;
use DB;
use Hash;


class VisitorController extends Controller
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

            if ($request->get('NetworkId') != '0') {

                $data = DB::select("select StoreVisitor.*,Store.StoreNetworkLink As StoreNetworkLink, Store.RegionalName As StoreName,Network.Name As NetworkName,GetCountry(StoreVisitor.IP) As Country, Store.LastCouponAdded from StoreVisitor left join Store on
                StoreVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId = Network.NetworkId
                where (DATE(StoreVisitor.CreateDate) BETWEEN :StartDate AND :EndDate ) and Store.NetworkId = :NetworkId and StoreVisitor.IP not in (:IP) and StoreVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by StoreVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "NetworkId" => $request->get('NetworkId'), "IP" => $request->get('IP')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            } else {

                $data = DB::select("select StoreVisitor.*,Store.StoreNetworkLink As StoreNetworkLink, Store.RegionalName As StoreName,Network.Name As NetworkName,GetCountry(StoreVisitor.IP) As Country, Store.LastCouponAdded from StoreVisitor left join Store on
                StoreVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId =Network.NetworkId
                where (DATE(StoreVisitor.CreateDate) BETWEEN :StartDate AND :EndDate) and StoreVisitor.IP not in (:IP) and StoreVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by StoreVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "IP" => $request->get('IP')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $network = Network::all()->pluck('Name', 'NetworkId')->toArray();
        $ips = DB::select("select distinct IP As IP from StoreVisitor");

        $ips = StoreVisitor::select('IP')->distinct()->get();
        return view('Admin.Visitor.index', [
            'network' => $network,
            'ips' => $ips
        ]);
    }

    public function coupon(Request $request)
    {
        if ($request->ajax()) {

            if ($request->get('NetworkId') != '0') {

                $data = DB::select("select CouponVisitor.*,Store.StoreNetworkLink As StoreNetworkLink, Store.RegionalName As StoreName,Network.Name As NetworkName,GetCountry(CouponVisitor.IP) As Country, Store.LastCouponAdded from CouponVisitor left join Store on
                CouponVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId = Network.NetworkId
                where (DATE(CouponVisitor.CreateDate) BETWEEN :StartDate AND :EndDate ) and Store.NetworkId = :NetworkId and CouponVisitor.IP not in (:IP) and CouponVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by CouponVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "NetworkId" => $request->get('NetworkId'), "IP" => $request->get('IP')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            } else {

                $data = DB::select("select CouponVisitor.*,Store.StoreNetworkLink As StoreNetworkLink, Store.RegionalName As StoreName,Network.Name As NetworkName,GetCountry(CouponVisitor.IP) As Country, Store.LastCouponAdded from CouponVisitor left join Store on
                CouponVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId = Network.NetworkId
                where (DATE(CouponVisitor.CreateDate) BETWEEN :StartDate AND :EndDate) and CouponVisitor.IP not in (:IP) and CouponVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by CouponVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "IP" => $request->get('IP')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $network = Network::all()->pluck('Name', 'NetworkId')->toArray();
        $ips = DB::select("select distinct IP As IP from CouponVisitor");

        $ips = CouponVisitor::select('IP')->distinct()->get();
        return view('Admin.Visitor.coupon', [
            'network' => $network,
            'ips' => $ips
        ]);
    }

    public function storeRegions(Request $request)
    {
        if ($request->ajax()) {

            if ($request->get('StoreId') != '0') {

                $data = DB::select("select StoreVisitor.*,Store.StoreNetworkLink As StoreNetworkLink, Store.RegionalName As StoreName,Network.Name As NetworkName,GetCountry(StoreVisitor.IP) As Country, Store.LastCouponAdded from StoreVisitor left join Store on
                StoreVisitor.StoreId = Store.StoreId left join Network on Store.NetworkId = Network.NetworkId
                where (DATE(StoreVisitor.CreateDate) BETWEEN :StartDate AND :EndDate ) and Store.NetworkId = :NetworkId and StoreVisitor.IP not in (:IP) and StoreVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by StoreVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "NetworkId" => $request->get('NetworkId'), "IP" => $request->get('IP')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $stores = Store::all()->pluck('Name', 'StoreId')->toArray();


        $ips = StoreVisitor::select('IP')->distinct()->get();
        return view('Admin.Visitor.index', [
            'network' => $network,
            'ips' => $ips
        ]);
    }

    public function cpcOfflineVisitors(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::select("SELECT GetCountry(IP) Location,sourceStore.Name As Source,targetStore.Name As Target, CPCStoreVisitor.CreateDate FROM CPCStoreVisitor left join Store sourceStore on CPCStoreVisitor.SourceStoreId = sourceStore.StoreId left join Store targetStore on CPCStoreVisitor.TargetStoreId = targetStore.StoreId
            where (DATE(CPCStoreVisitor.CreateDate) BETWEEN :StartDate AND :EndDate) and CPCStoreVisitor.IP not in (:IP) and CPCStoreVisitor.IP not in (SELECT distinct IP FROM ExcludeTrafficIP) order by CPCStoreVisitor.CReateDate desc
                ", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "IP" => $request->get('IP')]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        $ips = DB::select("select distinct IP As IP from CouponVisitor");

        $ips = CouponVisitor::select('IP')->distinct()->get();
        return view('Admin.Visitor.cpcVisitor', [
            'ips' => $ips
        ]);
    }
}
