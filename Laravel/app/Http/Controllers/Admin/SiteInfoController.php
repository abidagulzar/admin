<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\SiteInfo;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class SiteInfoController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Site Info View|Site Info Create|Site Info Edit|Site Info Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Site Info Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Site Info Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Site Info Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {

        $siteInfo = DB::table('SiteInfo')->select('SiteInfo.*', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')
            ->leftJoin('users as UpdatedBy', 'SiteInfo.UpdatedByUserId', '=', 'UpdatedBy.id')
            ->leftJoin('users as CreatedBy', 'SiteInfo.CreatedByUserId', '=', 'CreatedBy.id')
            ->first();

        if (!isset($siteInfo))
            $siteInfo = new SiteInfo();
        return view('Admin.SiteInfo.index', [
            'Model' => $siteInfo
        ]);
    }

    public function updatepost(Request $request)
    {
        try {
            if (Auth::user()->isAdmin()) {
                $siteInfo = SiteInfo::take(1)->first();

                if (isset($siteInfo)) {

                    $siteInfo->AboutUs =  $request->get('AboutUs');
                    $siteInfo->ContactUs =  $request->get('ContactUs');
                    $siteInfo->PrivacyPolicy =  $request->get('PrivacyPolicy');
                    $siteInfo->TermsOfUse =  $request->get('TermsOfUse');
                    $siteInfo->SuggestionText =  $request->get('SuggestionText');

                    $siteInfo->UpdatedByUserId = Auth::user()->id;
                    $siteInfo->UpdateDate = new DateTime();
                    $siteInfo->save();
                } else {
                    $data = $request->all();
                    $siteInfo = new SiteInfo($data);
                    $siteInfo->CreatedByUserId = Auth::user()->id;
                    $siteInfo->CreateDate = new DateTime();
                    $siteInfo->save();
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }



        return redirect()->route('admin.siteinfo.index')
            ->with('success', 'Site Info updated successfully.');
    }
}
