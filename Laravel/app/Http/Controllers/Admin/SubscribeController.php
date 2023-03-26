<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscribe;
use App\Store;
use Illuminate\Http\Request;
use DataTables;
use Redirect;
use DateTime;

class SubscribeController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:Subscribed Users', ['only' => ['index', 'delete']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscribe::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.Subscribe.index');
    }


    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('SubscribeId'));
        $category = Subscribe::whereIn('SubscribeId', $ids);
        $category->delete();
        return redirect()->route('admin.subscribe.index')
            ->with('success', 'Subscribed User deleted successfully');
    }
}
