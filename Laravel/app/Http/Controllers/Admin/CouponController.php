<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Store;
use App\Category;
use App\CouponCategory;
use App\Country;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Auth;
use DateTime;


class CouponController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Coupon View|Coupon Create|Coupon Edit|Coupon Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Coupon Create', ['only' => ['create', 'createpost', 'copycoupon', 'copypost']]);
        $this->middleware('permission:Coupon Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Coupon Delete', ['only' => ['delete']]);
        $this->middleware('permission:Home Banner View', ['only' => ['homebanner']]);
        $this->middleware('permission:Home Coupon/Deals View', ['only' => ['homecoupon']]);
        $this->middleware('permission:Coupon Rank', ['only' => ['couponrank']]);
    }



    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('Coupon')->select('Coupon.DealPageUrl', 'Coupon.CouponId', 'Coupon.CouponUrl', 'Coupon.Description', 'Coupon.IsHomeBanner', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.IsTopDeal', 'Coupon.IsBanner', 'Coupon.HomeCoupon', 'Coupon.IsHeaderDeal', 'Coupon.IsUnknownOutGoing', 'Coupon.IsHomeBanner', 'Coupon.OFF', 'Coupon.StoreRank', 'Coupon.CreateDate', 'Coupon.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser', 'CouponCountry.Name As CouponCountryName')->leftJoin('users as UpdatedBy', 'Coupon.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'Coupon.CreatedByUserId', '=', 'CreatedBy.id')->leftJoin('Country As CouponCountry', 'Coupon.CountryId', '=', 'CouponCountry.CountryId')->where('Coupon.StoreId', $request->get('StoreId'))->orderBy('Coupon.CreateDate', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $users = User::all()->pluck('name', 'id')->toArray();
            $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
            return view('Admin.Coupon.index', [
                'stores' => $stores,
                'users' => $users
            ]);
        }
    }

    public function homebanner(Request $request)
    {

        if ($request->ajax()) {


            //$data = Coupon::select('CouponId', 'Code', 'Header', 'ExpiryDate', 'IsBanner', 'HomeCoupon', 'IsHeaderDeal', 'IsUnknownOutGoing', 'IsHomeBanner', 'BannerUrl')->where('IsBanner', '1')->where('IsHomeBanner', '1')->orderBy('Coupon.CreateDate', 'DESC')->get();

            $data = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.IsBanner', 'Coupon.IsTopDeal', 'Coupon.HomeCoupon', 'Coupon.IsHeaderDeal', 'Coupon.IsUnknownOutGoing', 'Coupon.IsHomeBanner', 'Coupon.BannerUrl', 'Store.Name As StoreName', 'Coupon.CreateDate', 'Coupon.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->leftJoin('users as UpdatedBy', 'Coupon.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'Coupon.CreatedByUserId', '=', 'CreatedBy.id')->where('Coupon.IsBanner', '1')->where('Coupon.IsHomeBanner', '1')->orderBy('Coupon.CreateDate', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {

            return view('Admin.Coupon.homebanner');
        }
    }

    public function homecoupon(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.IsBanner', 'Coupon.IsTopDeal', 'Coupon.HomeCoupon', 'Coupon.IsHeaderDeal', 'Coupon.IsUnknownOutGoing', 'Coupon.IsHomeBanner', 'Coupon.LogoUrl', 'Store.Name As StoreName', 'Coupon.CreateDate', 'Coupon.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->leftJoin('users as UpdatedBy', 'Coupon.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'Coupon.CreatedByUserId', '=', 'CreatedBy.id')->where('Coupon.HomeCoupon', '1')->orderBy('Coupon.CreateDate', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {

            return view('Admin.Coupon.homecoupon');
        }
    }

    public function globalOffers(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('Coupon')->select('Coupon.CouponId', 'Coupon.Code', 'Coupon.Header', 'Coupon.ExpiryDate', 'Coupon.IsBanner', 'Coupon.IsTopDeal', 'Coupon.HomeCoupon', 'Coupon.IsHeaderDeal', 'Coupon.IsUnknownOutGoing', 'Coupon.IsHomeBanner', 'Coupon.LogoUrl', 'Store.Name As StoreName', 'Coupon.CreateDate', 'Coupon.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('Store', 'Coupon.StoreId', '=', 'Store.StoreId')->leftJoin('users as UpdatedBy', 'Coupon.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'Coupon.CreatedByUserId', '=', 'CreatedBy.id')->where('Coupon.IsGlobalOffer', '1')->orderBy('Coupon.CreateDate', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {

            return view('Admin.Coupon.globalOffers');
        }
    }


    public function couponrank(Request $request)
    {
        if ($request->ajax()) {
            $data = Store::select('StoreId', 'Name', 'Header1', 'LogoUrl', 'SearchName')->orderBy('Coupon.CreateDate', 'DESC')->orderBy('Coupon.CreateDate', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $stores = Store::all()->pluck('Name', 'StoreId')->toArray();
            return view('Admin.Coupon.couponrank', [
                'stores' => $stores

            ]);
        }
    }

    public function GetCouponForRank($id)
    {
        $where = array('StoreId' => $id);
        $copouns = Coupon::select('CouponId', 'Code', 'Header', 'ExpiryDate', 'CopounTypeText', 'IsUnknownOutGoing', 'StoreRank')->Where('Coupon.Enabled', 1)->where($where)
            //->orderBy('StoreRank', 'ASC')->orderBy('Coupon.CreateDate', 'DESC')->get();
            ->orderBy('Coupon.StoreRank', 'ASC')->orderBy('Coupon.CouponId', 'DESC')->get();
        foreach ($copouns as $coupon) {
            if (isset($coupon->ExpiryDate))
                $coupon->ExpiryDate =  AppHelper::instance()->DateToString($coupon->ExpiryDate);
        }
        return view('Admin.Coupon.couponrankpartial', [
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
                $coupon->StoreRank = ($i + 1);
                $coupon->save();
            }
            return "1";
        }

        return "0";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();
        $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();

        return view('Admin.Coupon.create', [
            'categories' => $categories,
            'stores' => $stores,
            'countries' => $countries
        ]);
    }

    public function deletebyuser(Request $request)
    {

        try {
            $request->validate([
                'DeleteUserStoreId' => 'required',
                'UserId' => 'required',
            ]);

            DB::delete('Delete FROM CouponCategory where CouponId in (Select CouponId from Coupon where CreatedByUserId = ? and StoreId = ?)', [$request->get('UserId'), $request->get('DeleteUserStoreId')]);
            $res = DB::delete('Delete FROM Coupon where `CreatedByUserId` = ? and `StoreId` = ?', [$request->get('UserId'), $request->get('DeleteUserStoreId')]);

            return redirect()->route('admin.coupon.index')
                ->with('success', $res . ' Coupon deleted successfully');
        } catch (\Exception $e) {

            $errorCode = $e->getCode();

            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }


        return redirect()->route('admin.coupon.index')
            ->with('success', 'Coupon deleted successfully');
    }

    public function copycoupon()
    {
        $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();

        return view('Admin.Coupon.copycoupon', [
            'stores' => $stores
        ]);
    }

    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'StoreId' => 'required',
                'CouponUrl' => 'required',
                'Header' => 'required',
                'CategoryId' => 'required',
                'CopounTypeText' => 'required',
            ]);

            if ($request->get('IsHeaderDeal') == 1) {
                DB::update('Update Coupon set IsHeaderDeal = 0 where StoreId = ?', [$request->get('StoreId')]);
            }

            $data = $request->all();
            $model = new Coupon($data);
            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {
                $guessExtension =  $fileLogoUrl->guessExtension();
                $saveName = AppHelper::instance()->RemoveSpaces($request->get('StoreName')) . '-coupon-deal-' . time() . '.' . $guessExtension;
                $fileLogoUrl->storeAs('/couponlogo', $saveName);

                AppHelper::instance()->MoveToPublicFolder('couponlogo', $saveName);

                $model->LogoUrl = $saveName;
            }

            $bannerUrl = $request->file('BannerUrl');
            if (isset($bannerUrl)) {
                $guessExtension =  $bannerUrl->guessExtension();
                $saveNameBannerUrl = AppHelper::instance()->RemoveSpaces($request->get('StoreName')) . '-coupon-deal-' . time() . '.' . $guessExtension;
                $bannerUrl->storeAs('/bannerlogo', $saveNameBannerUrl);

                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveNameBannerUrl);

                $model->BannerUrl = $saveNameBannerUrl;
            }

            $model->ExpiryDate = AppHelper::instance()->StringToDate($request->input('ExpiryDate'));
            $model->StartDate = AppHelper::instance()->StringToDate($request->input('StartDate'));
            $model->StoreRank = 0;
            $model->GLobalRank = 0;


            $model->CreatedByUserId = Auth::user()->id;
            $model->CreateDate = new DateTime();

            if ($model->save()) {
                $model->Category()->syncWithoutDetaching($request->input('CategoryId'));
            }

            Coupon::whereIn('StoreId', [$model->StoreId])->update([
                'StoreRank' => DB::raw('StoreRank+1'),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Coupon with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Coupon with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }


        return redirect()->route('admin.coupon.create')
            ->with('success', 'Coupon created successfully.');
    }

    public function copypost(Request $request)
    {
        try {
            $request->validate([
                'FromStoreId' => 'required',
                'ToStoreId' => 'required',
            ]);

            //   DB::delete('Delete FROM CouponCategory where CouponId in (select CouponId from FROM Coupon where StoreId = ?)', [$request->get('ToStoreId')]);
            DB::delete('Delete FROM Coupon where StoreId = ?', [$request->get('ToStoreId')]);
            DB::insert('INSERT INTO Coupon (Code, Header, Description, StoreId, CouponUrl, LogoUrl, ExpiryDate, Enabled, Expired, GlobalRank, StoreRank, HomeCoupon, HomeOffer, CopounTypeColour, CopounTypeText, CopounType, BestDeal, OFF, PreviousPrice, NewPrice, IsUnknownOutGoing, CreatedByUserId, UpdatedByUserId, CreateDate, UpdateDate, IsExclusive, IsHeaderDeal, SearchTag, IsHomeBanner, IsBanner, IsFlashDeal, IsTopDeal, BannerUrl, StartDate, CountryId) select 
            Code, Header, Description, ?, CouponUrl, LogoUrl, ExpiryDate, Enabled, Expired, GlobalRank, StoreRank, HomeCoupon, HomeOffer, CopounTypeColour, CopounTypeText, CopounType, BestDeal, OFF, PreviousPrice, NewPrice, IsUnknownOutGoing, CreatedByUserId, UpdatedByUserId, CreateDate, UpdateDate, IsExclusive, IsHeaderDeal, SearchTag, IsHomeBanner, IsBanner, IsFlashDeal, IsTopDeal, BannerUrl, StartDate, CountryId from Coupon where StoreId = ?', [$request->get('ToStoreId'), $request->get('FromStoreId')]);
        } catch (\Exception $e) {

            $errorCode = $e->getCode();

            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }


        return redirect()->route('admin.coupon.copycoupon')
            ->with('success', 'Coupon Copied successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('CouponId'));

        $couponCategories = CouponCategory::whereIn('CouponId', $ids);
        $couponCategories->delete();


        $coupons = Coupon::whereIn('CouponId', $ids);

        $coupons->delete();
        return redirect()->route('admin.coupon.index')
            ->with('success', 'Coupon deleted successfully');
    }

    public function edit($id)
    {
        $where = array('CouponId' => $id);
        $coupon = Coupon::where($where)->first();

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();
        $couponcategories = CouponCategory::where($where)->pluck('CategoryId')->toArray();
        $stores = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $countries = Country::all()->pluck('Name', 'CountryId')->toArray();

        if (isset($coupon->ExpiryDate))
            $coupon->ExpiryDate = AppHelper::instance()->DateToString($coupon->ExpiryDate);
        if (isset($coupon->StartDate))
            $coupon->StartDate = AppHelper::instance()->DateToString($coupon->StartDate);

        return view('Admin.Coupon.edit', [
            'categories' => $categories,
            'Model' => $coupon,
            'couponcategories' => $couponcategories,
            'stores' => $stores,
            'countries' => $countries
        ]);
    }



    public function updatepost(Request $request)
    {
        try {
            $request->validate([
                'StoreId' => 'required',
                'CouponUrl' => 'required',
                'Header' => 'required',
                'CategoryId' => 'required',
                'CopounTypeText' => 'required',
            ]);


            if ($request->get('IsHeaderDeal') == 1) {
                DB::update('Update Coupon set IsHeaderDeal = 0 where StoreId = ?', [$request->get('StoreId')]);
            }

            $model = Coupon::find($request->get('CouponId'));

            $model->Code =  $request->get('Code');
            $model->Header =  $request->get('Header');
            $model->Description =  $request->get('Description');
            $model->CouponUrl =  $request->get('CouponUrl');

            $model->Enabled =  $request->get('Enabled');
            $model->Expired =  $request->get('Expired');
            $model->HomeCoupon =  $request->get('HomeCoupon');
            $model->IsExclusive =  $request->get('IsExclusive');
            $model->IsHeaderDeal =  $request->get('IsHeaderDeal');
            $model->IsFlashDeal =  $request->get('IsFlashDeal');
            $model->IsBanner =  $request->get('IsBanner');
            $model->IsTopDeal =  $request->get('IsTopDeal');
            $model->IsHomeBanner =  $request->get('IsHomeBanner');
            $model->IsUnknownOutGoing =  $request->get('IsUnknownOutGoing');
            $model->IsShowAtHome =  $request->get('IsShowAtHome');
            $model->IsGlobalOffer =  $request->get('IsGlobalOffer');

            $model->CopounTypeColour =  $request->get('CopounTypeColour');
            $model->CopounTypeText =  $request->get('CopounTypeText');
            $model->OFF =  $request->get('OFF');
            $model->DealPageUrl =  $request->get('DealPageUrl');
            $model->CountryId = $request->get('CountryId');
            $model->ExpiryDate = AppHelper::instance()->StringToDate($request->input('ExpiryDate'));
            $model->StartDate = AppHelper::instance()->StringToDate($request->input('StartDate'));

            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {
                $guessExtension =  $fileLogoUrl->guessExtension();
                $saveName = AppHelper::instance()->RemoveSpaces($request->get('StoreName')) . '-coupon-deal-' . time() . '.' . $guessExtension;

                $fileLogoUrl->storeAs('/couponlogo', $saveName);

                AppHelper::instance()->MoveToPublicFolder('couponlogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $bannerUrl = $request->file('BannerUrl');
            if (isset($bannerUrl)) {
                $guessExtension =  $bannerUrl->guessExtension();
                $saveNameBannerUrl = AppHelper::instance()->RemoveSpaces($request->get('StoreName')) . '-coupon-deal-' . time() . '.' . $guessExtension;

                $bannerUrl->storeAs('/bannerlogo', $saveNameBannerUrl);

                AppHelper::instance()->MoveToPublicFolder('bannerlogo', $saveNameBannerUrl);
                $model->BannerUrl = $saveNameBannerUrl;
            }

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();

            if ($model->save()) {
                $model->Category()->sync($request->input('CategoryId'));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Coupon with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Coupon with this Name already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }


        return redirect()->route('admin.coupon.index')
            ->with('success', 'Coupon updated successfully.');
    }
}
