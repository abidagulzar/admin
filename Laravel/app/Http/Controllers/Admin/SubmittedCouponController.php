<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubmittedCoupon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class SubmittedCouponController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Submitted Coupon View|SubmittedCoupon Create|Submitted Coupon Edit|Submitted Coupon Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Submitted Coupon Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Submitted Coupon Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Submitted Coupon Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('SubmittedCoupon')->select('SubmittedCoupon.*', 'Store.Name As StoreName')->leftJoin('Store', 'SubmittedCoupon.StoreId', '=', 'Store.StoreId')->orderBy('SubmittedCoupon.CreateDate', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.SubmittedCoupon.index');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('SubmittedCouponId'));

        $SubmittedCoupon = SubmittedCoupon::whereIn('SubmittedCouponId', $ids);

        $SubmittedCoupon->delete();
        return redirect()->route('admin.submittedcoupon.index')
            ->with('success', 'Submitted Coupon deleted successfully');
    }
}
