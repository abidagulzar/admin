<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\StoreSetting;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class StoreSettingController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:Store Settings View|Store Settings Create|Store Settings Edit|Store Settings Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Store Settings Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Store Settings Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Store Settings Delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {

        // $storeSetting = DB::table('StoreSetting')->select('StoreSetting.*', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')
        //     ->leftJoin('users as UpdatedBy', 'StoreSetting.UpdatedByUserId', '=', 'UpdatedBy.id')
        //     ->leftJoin('users as CreatedBy', 'StoreSetting.CreatedByUserId', '=', 'CreatedBy.id')
        //     ->first();

        // if (!isset($storeSetting))
        //     $storeSetting = new StoreSetting();
        // return view('Admin.StoreSetting.index', [
        //     'Model' => $storeSetting
        // ]);

        if ($request->ajax()) {

            $data = DB::table('StoreSetting')->select('StoreSetting.*', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('users as UpdatedBy', 'StoreSetting.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'StoreSetting.CreatedByUserId', '=', 'CreatedBy.id')->orderBy('StoreSetting.CreateDate', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.StoreSetting.index');
    }

    public function create()
    {
        return view('Admin.StoreSetting.create', []);
    }

    public function createpost(Request $request)
    {
        try {
            $data = $request->all();
            $storeSetting = new StoreSetting($data);

            $storeSetting->CreatedByUserId = Auth::user()->id;
            $storeSetting->CreateDate = new DateTime();

            $storeSetting->save();
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

        return redirect()->route('admin.storesetting.index')
            ->with('success', 'Store created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('StoreSettingId'));
        $storeSettings = StoreSetting::whereIn('StoreSettingId', $ids);

        $storeSettings->delete();
        CacheHelper::instance()->ResetTopStore();
        return redirect()->route('admin.storesetting.index')
            ->with('success', 'Store Settings deleted successfully');
    }

    public function edit($id)
    {
        $where = array('StoreSettingId' => $id);
        $storeSettings = StoreSetting::where($where)->first();

        return view('Admin.StoreSetting.edit', [
            'Model' => $storeSettings
        ]);
    }

    public function updatepost(Request $request)
    {
        try {

            $storeSetting = StoreSetting::find($request->get('StoreSettingId'));

            if (isset($storeSetting)) {

                if (Auth::user()->isAdmin()) {
                    $storeSetting->Title =  $request->get('Title');
                    $storeSetting->Description =  $request->get('Description');
                    $storeSetting->Keywords =  $request->get('Keywords');
                    $storeSetting->Footer =  $request->get('Footer');
                    $storeSetting->DefaultContent =  $request->get('DefaultContent');
                    $storeSetting->RegionName =  $request->get('RegionName');
                    $storeSetting->RelatedSearches =  $request->get('RelatedSearches');
                    $storeSetting->RelatedStoresText =  $request->get('RelatedStoresText');
                    $storeSetting->MonthsFull =  $request->get('MonthsFull');
                    $storeSetting->MonthsShort =  $request->get('MonthsShort');


                    $storeSetting->RelatedStoreHeading = $request->get('RelatedStoreHeading');
                    $storeSetting->SubscribeToEmailHeading = $request->get('SubscribeToEmailHeading');
                    $storeSetting->SubscribeToEmailText = $request->get('SubscribeToEmailText');
                    $storeSetting->SubscribeToEmailFooter = $request->get('SubscribeToEmailFooter');
                    $storeSetting->SubscribeTranslate = $request->get('SubscribeTranslate');
                    $storeSetting->EmailAddressTranslate = $request->get('EmailAddressTranslate');
                    $storeSetting->GotQuestionHeading = $request->get('GotQuestionHeading');
                    $storeSetting->GotQuestionText = $request->get('GotQuestionText');
                    $storeSetting->DropLineTranslate = $request->get('DropLineTranslate');
                    $storeSetting->RelatedSearchesTranslate = $request->get('RelatedSearchesTranslate');
                    $storeSetting->GeneralTranslate = $request->get('GeneralTranslate');
                    $storeSetting->ConnectTranslate = $request->get('ConnectTranslate');
                    $storeSetting->SpecialPagesHeading = $request->get('SpecialPagesHeading');
                    $storeSetting->GetDeal = $request->get('GetDeal');
                    $storeSetting->ShowCode = $request->get('ShowCode');
                    $storeSetting->ClickBelowTextAndPast = $request->get('ClickBelowTextAndPast');
                    $storeSetting->ExpiresOn = $request->get('ExpiresOn');
                    $storeSetting->UnknownOutGoing = $request->get('UnknownOutGoing');
                    $storeSetting->VisitOurStore = $request->get('VisitOurStore');

                    $storeSetting->Exclusive = $request->get('Exclusive');
                    $storeSetting->Coupon = $request->get('Coupon');
                    $storeSetting->Deal = $request->get('Deal');
                    $storeSetting->ContinueToStore = $request->get('ContinueToStore');
                    $storeSetting->NoCodeNeeded = $request->get('NoCodeNeeded');

                    $storeSetting->DefaultContentKeywords =  $request->get('DefaultContentKeywords');
                    $storeSetting->RelatedStoreKeywords =  $request->get('RelatedStoreKeywords');
                    $storeSetting->FooterKeywords =  $request->get('FooterKeywords');
                    $storeSetting->Lang =  $request->get('Lang');
                    $storeSetting->DefaultDealText =  $request->get('DefaultDealText');
                    $storeSetting->DefaultQA =  $request->get('DefaultQA');
                    $storeSetting->QAKeywords = $request->get('QAKeywords');
                    $storeSetting->Header1 = $request->get('Header1');
                }

                $storeSetting->UpdatedByUserId = Auth::user()->id;
                $storeSetting->UpdateDate = new DateTime();
            } else {
            }

            $storeSetting->save();
            CacheHelper::instance()->ClearStoreSetting();
        } catch (\Illuminate\Database\QueryException $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }



        return redirect()->route('admin.storesetting.index')
            ->with('success', 'Store Settings updated successfully.');
    }
}
