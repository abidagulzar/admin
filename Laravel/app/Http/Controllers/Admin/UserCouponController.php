<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;

use DataTables;
use DateTime;
use DB;
use Hash;


class UserCouponController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = DB::select("select tbl.*,Store.Name As StoreName,users.Name As UserName from (select DATE(CreateDate) CreateDate, CreatedByUserId, StoreId, Count(*) TotalCreated from Coupon where (DATE(CreateDate) BETWEEN ? AND ?) and CreatedByUserId = ? Group by StoreId) tbl left join Store on tbl.StoreId = Store.StoreId left join users on tbl.CreatedByUserId = users.id", ['fromdate' => '2019-02-09', 'todate' => '2019-02-09', 'userid' => 1]);

            if ($request->get('GroupBy') == 'store') {

                $data = DB::select("select tbl.*,Store.Name As StoreName,
                    users.Name As UserName,network.Name as NetworkName
                     from
                    (select DATE(CreateDate) CreateDate, UserId, StoreId, Count(*) TotalCreated from CouponAudit 
                    where (DATE(CreateDate) BETWEEN :StartDate AND :EndDate) 
                    and UserId = :UserId
                    Group by DATE(CreateDate),UserId,StoreId) tbl left join
                    Store on tbl.StoreId = Store.StoreId left join users on tbl.UserId = users.id left join Network as network on Store.NetworkId = network.NetworkId", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "UserId" => $request->get('UserId')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            } else if ($request->get('GroupBy') == 'day') {
                $data = DB::select("select tbl.*,
                users.Name As UserName,'' as NetworkName
                from 
                (select DATE(CreateDate) CreateDate, UserId, Count(*) TotalCreated from CouponAudit 
                where 
                (DATE(CreateDate) BETWEEN :StartDate AND :EndDate) 
                and UserId = :UserId
                Group by DATE(CreateDate),UserId)tbl left join users on tbl.UserId = users.id", ["StartDate" => $request->get('StartDate'), "EndDate" => $request->get('EndDate'), "UserId" => $request->get('UserId')]);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $users = User::all()->pluck('name', 'id')->toArray();
        return view('Admin.UserCoupon.index', [
            'users' => $users
        ]);
    }
}
