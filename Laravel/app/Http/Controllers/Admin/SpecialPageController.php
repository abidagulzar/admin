<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SpecialPage;
use App\Category;
use App\Coupon;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\SpecialPageCouponRank;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class SpecialPageController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:SpecialPage View|SpecialPage Create|SpecialPage Edit|SpecialPage Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:SpecialPage Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:SpecialPage Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:SpecialPage Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('SpecialPage')->select('SpecialPage.*', 'Category.Name As CategoryName', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('users as UpdatedBy', 'SpecialPage.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'SpecialPage.CreatedByUserId', '=', 'CreatedBy.id')->leftJoin('Category', 'Category.CategoryId', '=', 'SpecialPage.CategoryId')->orderBy('SpecialPage.CreateDate', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.SpecialPage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();

        return view('Admin.SpecialPage.create', [
            'categories' => $categories
        ]);
    }

    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',

                'CategoryId' => 'required',
                'URL' => 'required'
            ]);

            $data = $request->all();
            $model = new SpecialPage($data);

            //  $model->SetSearchName();

            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {

                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = $model->URL . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl->StoreAs('/specialpagelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('specialpagelogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $fileLogoUrl1 = $request->file('BannerUrl');
            if (isset($fileLogoUrl1)) {

                $guessExtension =  $fileLogoUrl1->guessExtension();

                $saveName = $model->URL . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl1->StoreAs('/specialpagelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('specialpagelogo', $saveName);
                $model->BannerUrl = $saveName;
            }

            $model->CreatedByUserId = Auth::user()->id;
            $model->CreateDate = new DateTime();

            $model->save();
            CacheHelper::instance()->ResetSpecialPage();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['SpecialPage with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['SpecialPage with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }


        return redirect()->route('admin.specialpage.index')
            ->with('success', 'Special Page created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('SpecialPageId'));

        $SpecialPage = SpecialPage::whereIn('SpecialPageId', $ids);

        $SpecialPage->delete();
        return redirect()->route('admin.specialpage.index')
            ->with('success', 'Special Page deleted successfully');
    }

    public function edit($id)
    {
        $where = array('SpecialPageId' => $id);
        $SpecialPage = SpecialPage::where($where)->first();

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();

        return view('Admin.SpecialPage.edit', [
            'categories' => $categories,
            'Model' => $SpecialPage
        ]);
    }



    public function updatepost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'CategoryId' => 'required',
                'URL' => 'required',
            ]);


            $model = SpecialPage::find($request->get('SpecialPageId'));


            $model->Title =  $request->get('Title');
            $model->SubTitle =  $request->get('SubTitle');

            $model->Name =  $request->get('Name');
            $model->URL =  $request->get('URL');
            $model->CategoryId =  $request->get('CategoryId');

            $model->IsCurrentEventPage =  $request->get('IsCurrentEventPage');
            $model->IsActive =  $request->get('IsActive');


            $model->Keyword =  $request->get('Keyword');
            $model->MetaTitle =  $request->get('MetaTitle');
            $model->MetaDescription =  $request->get('MetaDescription');
            $model->MetaKeyword =  $request->get('MetaKeyword');
            $model->BigTitle =  $request->get('BigTitle');
            $model->FilterKeywords =  $request->get('FilterKeywords');


            //  $model->SetSearchName();

            $fileLogoUrl = $request->file('LogoUrl');
            if (isset($fileLogoUrl)) {

                $md5Name = md5_file($fileLogoUrl->getRealPath());
                $guessExtension =  $fileLogoUrl->guessExtension();

                $saveName = $model->URL . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl->StoreAs('/specialpagelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('specialpagelogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $fileLogoUrl1 = $request->file('BannerUrl');
            if (isset($fileLogoUrl1)) {

                $guessExtension =  $fileLogoUrl1->guessExtension();

                $saveName = $model->URL . '-' . time() . '.' . $guessExtension;
                $fileLogoUrl1->StoreAs('/specialpagelogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('specialpagelogo', $saveName);
                $model->BannerUrl = $saveName;
            }

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();

            $model->save();
            CacheHelper::instance()->ResetSpecialPage();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['SpecialPage with this Name or Header 1 already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['SpecialPage with this Name already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }


        return redirect()->route('admin.specialpage.index')
            ->with('success', 'Special Page updated successfully.');
    }


    public function couponrank(Request $request)
    {
        $specialPages = SpecialPage::all()->pluck('Name', 'SpecialPageId')->toArray();

        return view('Admin.SpecialPage.couponrank', [
            'specialPages' => $specialPages
        ]);
    }


    public function GetCouponForRank($id)
    {

        $selectedSpecialPage = DB::table('SpecialPage')->select('SpecialPage.*')->where('SpecialPageId', $id)->first();

        $where = '';
        $unionWithWhere = '';
        if ($selectedSpecialPage->FilterKeywords != null && $selectedSpecialPage->FilterKeywords != '') {

            $filters = explode(',', $selectedSpecialPage->FilterKeywords);

            $ct = count($filters);
            for ($i = 0; $i < $ct; $i++) {
                if ($i > 0) {
                    $where = $where . ' or';
                }
                $where  = $where . ' Header like \'%' . $filters[$i] . '%\' or Description like \'%' . $filters[$i] . '%\'';
            }

            $unionWithWhere = "union select CouponId from Coupon where " . $where;
        }

        $selectedSpecialPageCoupons = DB::select(
            "Select s.SearchName As StoreSearchName,s.LogoUrl As StoreLogoUrl, s.SEOStoreName As StoreName,c.*,specialPageCouponRank.Rank
        from Coupon c left join Store s on c.StoreId = s.StoreId left join SpecialPageCouponRank specialPageCouponRank on specialPageCouponRank.CouponId = c.CouponId
        and specialPageCouponRank.SpecialPageId = :SpecialPageId where c.CouponId in 
        (
         Select CouponId from CouponCategory where CategoryId = :CategoryId " . $unionWithWhere . ")
        and s.NetworkId in(1,2,3) order by specialPageCouponRank.Rank asc ",
            ["SpecialPageId" => $selectedSpecialPage->SpecialPageId, "CategoryId" => $selectedSpecialPage->CategoryId]
        );

        return view('Admin.SpecialPage.couponrankpartial', [
            'copouns' => $selectedSpecialPageCoupons
        ]);
    }
    public function updaterank(Request $request)
    {

        $specialPageId =  $request->get('specialPageId');
        $couponlist = json_decode($request->list, true);

        $specialPageCouponRanks = SpecialPageCouponRank::where('SpecialPageId', $specialPageId);
        $specialPageCouponRanks->delete();


        if (isset($couponlist)) {
            $length = count($couponlist);
            for ($i = 0; $i < $length; $i++) {
                $model = new SpecialPageCouponRank();
                $model->Rank = ($i + 1);
                $model->CouponId = $couponlist[$i];
                $model->SpecialPageId = $specialPageId;
                $model->save();
            }
            return "1";
        }

        return "0";
    }
}
