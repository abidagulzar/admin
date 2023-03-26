<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\HomeSetting;
use App\Coupon;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class HomeSettingController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:Home Settings View|Home Settings Create|Home Settings Edit|Home Settings Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Home Settings Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Home Settings Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Home Settings Delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        //$homeSetting = HomeSetting::take(1)->first();


        $homeSetting = DB::table('HomeSetting')->select('HomeSetting.*', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')
            ->leftJoin('users as UpdatedBy', 'HomeSetting.UpdatedByUserId', '=', 'UpdatedBy.id')
            ->leftJoin('users as CreatedBy', 'HomeSetting.CreatedByUserId', '=', 'CreatedBy.id')
            ->first();

        if (!isset($homeSetting))
            $homeSetting = new HomeSetting();
        return view('Admin.HomeSetting.index', [
            'Model' => $homeSetting
        ]);
    }

    public function couponrank(Request $request)
    {
        return view('Admin.HomeSetting.homeCouponRank', []);
    }

    public function GetCouponForRank()
    {
        $where = array('IsShowAtHome' => 1);
        $copouns = Coupon::select('CouponId', 'Code', 'Header', 'ExpiryDate', 'CopounTypeText', 'IsUnknownOutGoing', 'GlobalRank')->where($where)->orderBy('GlobalRank', 'ASC')->orderBy('Coupon.CreateDate', 'DESC')->get();
        foreach ($copouns as $coupon) {
            if (isset($coupon->ExpiryDate))
                $coupon->ExpiryDate =  AppHelper::instance()->DateToString($coupon->ExpiryDate);
        }
        return view('Admin.HomeSetting.couponrankpartial', [
            'copouns' => $copouns
        ]);
    }

    public function updaterank(Request $request)
    {
        $couponlist = json_decode($request->list, true);
        if (isset($couponlist)) {
            $length = count($couponlist);
            for ($i = 0; $i < $length; $i++) {
                $coupon = Coupon::find($couponlist[$i]);
                $coupon->GlobalRank = ($i + 1);
                $coupon->save();
            }
            return "1";
        }

        return "0";
    }


    public function updatepost(Request $request)
    {
        try {

            $homeSetting = HomeSetting::take(1)->first();

            if (isset($homeSetting)) {
                $homeSetting->Banner1HeaderText =  $request->get('Banner1HeaderText');
                $homeSetting->Banner2HeaderText =  $request->get('Banner2HeaderText');
                $homeSetting->Banner3HeaderText =  $request->get('Banner3HeaderText');
                $homeSetting->Banner4HeaderText =  $request->get('Banner4HeaderText');

                $homeSetting->AffiliateLink1 =  $request->get('AffiliateLink1');
                $homeSetting->AffiliateLink2 =  $request->get('AffiliateLink2');
                $homeSetting->AffiliateLink3 =  $request->get('AffiliateLink3');
                $homeSetting->AffiliateLink4 =  $request->get('AffiliateLink4');

                if (Auth::user()->isAdmin()) {
                    $homeSetting->SchemaOrg =  $request->get('SchemaOrg');
                    $homeSetting->Title =  $request->get('Title');
                    $homeSetting->Description =  $request->get('Description');
                    $homeSetting->Keywords =  $request->get('Keywords');
                    $homeSetting->Footer =  $request->get('Footer');
                }

                $homeSetting->UpdatedByUserId = Auth::user()->id;
                $homeSetting->UpdateDate = new DateTime();
            } else {
                $data = $request->all();
                $homeSetting = new HomeSetting($data);

                $homeSetting->CreatedByUserId = Auth::user()->id;
                $homeSetting->CreateDate = new DateTime();
            }

            $banner1Url = $request->file('Banner1Url');
            if (isset($banner1Url)) {
                $guessExtension =  $banner1Url->guessExtension();
                $saveName = 'coupon-' . time() . '.' . $guessExtension;
                $banner1Url->storeAs('/bannerlogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveName);
                $homeSetting->Banner1Url = $saveName;
            }

            $banner2Url = $request->file('Banner2Url');
            if (isset($banner2Url)) {
                $guessExtension =  $banner2Url->guessExtension();
                $saveName = 'coupon-code-' . time() . '.' . $guessExtension;
                $banner2Url->storeAs('/bannerlogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveName);
                $homeSetting->Banner2Url = $saveName;
            }

            $banner3Url = $request->file('Banner3Url');
            if (isset($banner3Url)) {
                $guessExtension =  $banner3Url->guessExtension();
                $saveName = 'coupon-deal-' . time() . '.' . $guessExtension;
                $banner3Url->storeAs('/bannerlogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveName);
                $homeSetting->Banner3Url = $saveName;
            }

            $banner4Url = $request->file('Banner4Url');
            if (isset($banner4Url)) {
                $guessExtension =  $banner4Url->guessExtension();
                $saveName = 'offer-deal-' . time() . '.' . $guessExtension;
                $banner4Url->storeAs('/bannerlogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveName);
                $homeSetting->Banner4Url = $saveName;
            }

            $homeSetting->IsBanner1Show =  $request->get('IsBanner1Show');
            $homeSetting->IsBanner2Show =  $request->get('IsBanner2Show');
            $homeSetting->IsBanner3Show =  $request->get('IsBanner3Show');
            $homeSetting->IsBanner4Show =  $request->get('IsBanner4Show');

            $homeSetting->save();
            CacheHelper::instance()->ResetHomeSetting();
        } catch (\Illuminate\Database\QueryException $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }



        return redirect()->route('admin.homesetting.index')
            ->with('success', 'Home Settings updated successfully.');
    }
}
