<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Store;
use Illuminate\Http\Request;
use DataTables;
use Redirect;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;

class StoreStatsController extends Controller
{
    public function index(Request $request)
    {
        return view('Admin.StoreStats.index');
    }
}
