<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\SocialMedia;
use App\Store;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;




class SocialMediaController extends Controller
{


    function __construct()
    {
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::select("SELECT 
            socialMedia.*, store.RegionalName as StoreName, store.SearchName, network.Name as NetworkName, UpdatedBy.Name As UpdatedByUser, CreatedBy.Name As CreatedByUser
             FROM SocialMedia socialMedia
            left join Store store on socialMedia.StoreId = store.StoreId
            left join Network network on store.NetworkId = network.NetworkId 
            left join users as CreatedBy on socialMedia.CreatedByUserId = CreatedBy.id
            left join users as UpdatedBy on socialMedia.UpdatedByUserId = UpdatedBy.id
            order by socialMedia.SocialMediaId desc");

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.SocialMedia.index');
    }

    public function create()
    {
        $storesList = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        return view('Admin.SocialMedia.create', ['stores' => $storesList]);
    }

    public function createpost(Request $request)
    {
        try {
            $data = $request->all();
            $SocialMedia = new SocialMedia($data);

            $SocialMedia->CreatedByUserId = Auth::user()->id;
            $SocialMedia->CreateDate = new DateTime();

            $fileLogoUrl = $request->file('SocialImage');
            if (isset($fileLogoUrl)) {

                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = 'coupon-code-' . time() . '.' . $guessExtension;
                $fileLogoUrl->storeAs('/socialmedia', $saveName);
                AppHelper::instance()->MoveToPublicFolder('socialmedia', $saveName);
                $SocialMedia->SocialImage = $saveName;
            }

            $SocialMedia->save();
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Store with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        CacheHelper::instance()->ResetTopStore();

        return redirect()->route('admin.socialmedia.index')
            ->with('success', 'Social Media Entity created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('SocialMediaId'));
        $SocialMedias = SocialMedia::whereIn('SocialMediaId', $ids);

        $SocialMedias->delete();
        CacheHelper::instance()->ResetTopStore();
        return redirect()->route('admin.socialmedia.index')
            ->with('success', 'Social Media deleted successfully');
    }

    public function edit($id)
    {
        $storesList = Store::all()->pluck('RegionalName', 'StoreId')->toArray();
        $where = array('SocialMediaId' => $id);
        $SocialMedia = SocialMedia::where($where)->first();

        return view('Admin.SocialMedia.edit', [
            'Model' => $SocialMedia,
            'stores' => $storesList
        ]);
    }

    public function updatepost(Request $request)
    {
        try {

            $model = SocialMedia::find($request->get('SocialMediaId'));

            $model->AffiliateUrlToRedirect =  $request->get('AffiliateUrlToRedirect');
            $model->Title =  $request->get('Title');
            $model->SocialMediaSharedURL =  $request->get('SocialMediaSharedURL');
            $model->Description =  $request->get('Description');

            $fileLogoUrl = $request->file('SocialImage');
            if (isset($fileLogoUrl)) {

                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = 'coupon-code-' . time() . '.' . $guessExtension;
                $fileLogoUrl->storeAs('/socialmedia', $saveName);
                AppHelper::instance()->MoveToPublicFolder('socialmedia', $saveName);
                $model->SocialImage = $saveName;
            }

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }


        return redirect()->route('admin.socialmedia.index')
            ->with('success', 'Social Media Entity updated successfully.');
    }
}
