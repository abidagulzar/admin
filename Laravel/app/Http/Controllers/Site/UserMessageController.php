<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Subscribe;
use App\UserMessage;
use Auth;
use DateTime;

class UserMessageController extends Controller
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



        $siteInfo = DB::table('SiteInfo')->select('SiteInfo.*')->first();

        return view('Site.UserMessage.create', compact('homeSetting', 'relatedSearch', 'specialPage', 'siteInfo'));
    }

    public function contactuspost(Request $request)
    {
        try {

            $data = $request->all();
            $model = new UserMessage($data);
            $model->IPAddress = geoip()->getClientIP();
            $model->CreateDate = new DateTime();

            $model->save();
        } catch (\Exception $e) {
            return redirect()->route('site.home');
        }

        if ($request->get('IsSuggestion') == 1) {
            return    redirect()->route('site.suggestion')
                ->with('message', 'Thank you for your feedback!');
        }
        return redirect()->route('site.contactus')
            ->with('message', 'Thank you for your message.We will Get back to you soon!');
    }



    public function subscribe(Request $request)
    {
        try {

            $data = $request->all();
            $model = new Subscribe($data);

            $model->CreateDate = new DateTime();
            $model->IsActive = 1;
            $model->IPAddress = geoip()->getClientIP();
            $model->save();
        } catch (\Exception $e) {
        }
    }
}
