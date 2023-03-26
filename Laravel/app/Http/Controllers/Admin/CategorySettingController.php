<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\CategorySetting;
use App\Helpers\CacheHelper;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class CategorySettingController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:Category Settings View|Category Settings Create|Category Settings Edit|Category Settings Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Category Settings Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Category Settings Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Category Settings Delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $categorySetting = DB::table('CategorySetting')->select('CategorySetting.*', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')
            ->leftJoin('users as UpdatedBy', 'CategorySetting.UpdatedByUserId', '=', 'UpdatedBy.id')
            ->leftJoin('users as CreatedBy', 'CategorySetting.CreatedByUserId', '=', 'CreatedBy.id')
            ->first();

        if (!isset($categorySetting))
            $categorySetting = new CategorySetting();
        return view('Admin.CategorySetting.index', [
            'Model' => $categorySetting
        ]);
    }

    public function updatepost(Request $request)
    {
        try {

            $categorySetting = CategorySetting::take(1)->first();

            if (isset($categorySetting)) {

                if (Auth::user()->isAdmin()) {
                    $categorySetting->Title =  $request->get('Title');
                    $categorySetting->Description =  $request->get('Description');
                    $categorySetting->Keywords =  $request->get('Keywords');
                    $categorySetting->Footer =  $request->get('Footer');
                }

                $categorySetting->UpdatedByUserId = Auth::user()->id;
                $categorySetting->UpdateDate = new DateTime();
            } else {
                $data = $request->all();
                $categorySetting = new CategorySetting($data);

                $categorySetting->CreatedByUserId = Auth::user()->id;
                $categorySetting->CreateDate = new DateTime();
            }

            $categorySetting->save();
            CacheHelper::instance()->ResetCategorySetting();
        } catch (\Illuminate\Database\QueryException $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }



        return redirect()->route('admin.categorysetting.index')
            ->with('success', 'Category Settings updated successfully.');
    }
}
