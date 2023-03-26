<?php

namespace App\Http\Controllers\API;

use App\AdmitadSale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReportController extends Controller
{

    public function admitadPostBack(Request $request)
    {

        $admitadSale = new AdmitadSale();
        $admitadSale->offer_id = $request->get('offer_id');
        $admitadSale->offer_name = $request->get('offer_name');
        $admitadSale->admitad_id =  $request->get('admitad_id');
        $admitadSale->website_name =  $request->get('website_name');
        $admitadSale->website_id =  $request->get('website_id');
        $admitadSale->CreateDate = new DateTime();

        $admitadSale->save();

        return response()->json(['result' => '1']);
    }
}
