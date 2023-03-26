<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ExcludeTrafficIP;
use App\Category;
use App\Network;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class ExcludeTrafficIPController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:VisitorIPExclude View|VisitorIPExclude Create|VisitorIPExclude Edit|VisitorIPExclude Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:VisitorIPExclude Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:VisitorIPExclude Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:VisitorIPExclude Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('ExcludeTrafficIP')->select('ExcludeTrafficIP.ExcludeTrafficIPId', 'ExcludeTrafficIP.Title', 'ExcludeTrafficIP.IP', 'ExcludeTrafficIP.CreateDate', 'ExcludeTrafficIP.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('users as UpdatedBy', 'ExcludeTrafficIP.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'ExcludeTrafficIP.CreatedByUserId', '=', 'CreatedBy.id')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.ExcludeTrafficIP.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('Admin.ExcludeTrafficIP.create', []);
    }

    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'Title' => 'required',
                'IP' => 'required'
            ]);

            $data = $request->all();
            $model = new ExcludeTrafficIP($data);
            $model->CreatedByUserId = Auth::user()->id;
            $model->CreateDate = new DateTime();

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Excluded IP with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Excluded IP with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        return redirect()->route('admin.excludetrafficip.index')
            ->with('success', 'Excluded IP created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('ExcludeTrafficIPId'));


        $ExcludeTrafficIP = ExcludeTrafficIP::whereIn('ExcludeTrafficIPId', $ids);

        $ExcludeTrafficIP->delete();

        return redirect()->route('admin.excludetrafficip.index')
            ->with('success', 'Excluded IP deleted successfully');
    }

    public function edit($id)
    {
        $where = array('ExcludeTrafficIPId' => $id);
        $ExcludeTrafficIP = ExcludeTrafficIP::where($where)->first();

        return view('Admin.ExcludeTrafficIP.edit', [
            'Model' => $ExcludeTrafficIP,
        ]);
    }



    public function updatepost(Request $request)
    {
        try {

            $request->validate([
                'Title' => 'required',
                'IP' => 'required'
            ]);


            $model = ExcludeTrafficIP::find($request->get('ExcludeTrafficIPId'));

            $model->Title =  $request->get('Title');
            $model->IP =  $request->get('IP');

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Excluded IP with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Excluded IP with this Name already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        return redirect()->route('admin.excludetrafficip.index')
            ->with('success', 'Excluded IP updated successfully.');
    }
}
