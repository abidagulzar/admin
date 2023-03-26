<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\SubmittedCoupon;
use Auth;
use App\Store;
use DateTime;

class SubmittedCouponController extends Controller
{
    function __construct()
    {
    }


    public function create()
    {
        // For Master Page Data

        $homeSetting = CacheHelper::instance()->GetHomeSetting();
        $relatedSearch = CacheHelper::instance()->GetStoreLatestSearch();
        $specialPage = CacheHelper::instance()->GetSpecialPage();


        // For Master Page Data

        $stores = Store::all()->pluck('Name', 'StoreId')->toArray();

        return view('Site.SubmittedCoupon.create', compact('homeSetting', 'relatedSearch', 'specialPage', 'stores'));
    }

    public function createpost(Request $request)
    {
        try {

            $data = $request->all();
            $model = new SubmittedCoupon($data);



            $model->StoreId = $request->input('StoreWebsite');
            $model->Code = $request->input('Code');
            $model->Description = $request->input('DiscountDescription');
            $model->ExpiryDate = AppHelper::instance()->StringToDate($request->input('ExpiryDate'));

            $model->CreateDate = new DateTime();

            $model->save();
        } catch (\Exception $e) {
            return redirect()->route('site.home');
        }

        return redirect()->route('site.submittedcoupon')
            ->with('message', 'Coupon Submitted Successfully!');
    }
}
