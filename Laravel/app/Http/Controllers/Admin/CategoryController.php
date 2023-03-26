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

class CategoryController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Category View|Category Create|Category Edit|Category Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Category Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Category Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Category Delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Category::orderBy('Category.CreateDate', 'DESC')->orderBy('Category.CreateDate', 'DESC')->get();

            $data = DB::table('Category')->select('Category.CategoryId', 'Category.Name', 'Category.Header', 'Category.Description', 'Category.LogoUrl', 'Category.IsHomeCategory', 'Category.Enabled', 'Category.CreateDate', 'Category.UpdateDate', 'UpdatedBy.Name As UpdatedByUser', 'CreatedBy.Name As CreatedByUser')->leftJoin('users as UpdatedBy', 'Category.UpdatedByUserId', '=', 'UpdatedBy.id')->leftJoin('users as CreatedBy', 'Category.CreatedByUserId', '=', 'CreatedBy.id')->orderBy('Category.CreateDate', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.Category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();


        return view('Admin.Category.create', [
            'categories' => $categories
        ]);
    }


    public function createpost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Keyword' => 'required',
                'Header' => 'required'
            ]);

            $data = $request->all();
            $model = new Category($data);

            $model->SetSearchName();

            $file = $request->file('LogoUrl');
            if (isset($file)) {

                $md5Name = md5_file($file->getRealPath());
                $guessExtension =  $file->guessExtension();

                $saveName = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $file->storeAs('/categorylogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('categorylogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $model->CreatedByUserId = Auth::user()->id;
            $model->CreateDate = new DateTime();

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Category with this Name or Header already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Category with this Name or Header already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        CacheHelper::instance()->ResetTopCategory();
        return redirect()->route('admin.category.index')
            ->with('success', 'Category created successfully.');
    }

    public function delete(Request $request)
    {

        $ids = explode(",", $request->get('CategoryId'));
        $category = Category::whereIn('CategoryId', $ids);
        $category->delete();
        CacheHelper::instance()->ResetTopCategory();
        return redirect()->route('admin.category.index')
            ->with('success', 'Category deleted successfully');
    }

    public function edit($id)
    {
        $where = array('CategoryId' => $id);
        $category = Category::where($where)->first();

        $categories = Category::all()->pluck('Name', 'CategoryId')->toArray();

        return view('Admin.Category.edit', [
            'categories' => $categories,
            'Model' => $category
        ]);
    }

    public function updatepost(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Keyword' => 'required',
                'Header' => 'required'
            ]);


            $model = Category::find($request->get('CategoryId'));

            $model->Name =  $request->get('Name');
            $model->MotherCategory =  $request->get('MotherCategory');
            $model->Header =  $request->get('Header');
            $model->Description =  $request->get('Description');
            $model->Keyword =  $request->get('Keyword');
            $model->Enabled =  $request->get('Enabled');
            $model->IsTopCategory =  $request->get('IsTopCategory');
            $model->IsHomeCategory =  $request->get('IsHomeCategory');
            $model->MetaTitle =  $request->get('MetaTitle');
            $model->MetaDescription =  $request->get('MetaDescription');
            $model->MetaKeyword =  $request->get('MetaKeyword');
            $model->IconClass =  $request->get('IconClass');

            $model->SetSearchName();

            $file = $request->file('LogoUrl');
            if (isset($file)) {

                $md5Name = md5_file($file->getRealPath());
                $guessExtension =  $file->guessExtension();

                $saveName = $model->SearchName . '-' . time() . '.' . $guessExtension;
                $file->storeAs('/categorylogo', $saveName);
                AppHelper::instance()->MoveToPublicFolder('categorylogo', $saveName);
                $model->LogoUrl = $saveName;
            }

            $model->UpdatedByUserId = Auth::user()->id;
            $model->UpdateDate = new DateTime();

            $model->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode =  $e->errorInfo[1];
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Category with this Name or Header already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        } catch (\Exception $e) {

            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                return  \Redirect::back()->withInput($request->input())->withErrors(['Category with this Name or Header already exist']);
            } else {
                return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
            }
        }

        CacheHelper::instance()->ResetTopCategory();
        return redirect()->route('admin.category.index')
            ->with('success', 'Category updated successfully.');
    }
}
