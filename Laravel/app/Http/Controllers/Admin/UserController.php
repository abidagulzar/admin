<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;

use DataTables;
use DateTime;
use DB;
use Hash;


class UserController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:User View|User Create|User Edit|User Delete', ['only' => ['index', 'createpost']]);
        // $this->middleware('permission:User Create', ['only' => ['create', 'createpost']]);
        // $this->middleware('permission:User Edit', ['only' => ['edit', 'updatepost']]);
        // $this->middleware('permission:User Delete', ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = User::orderBy('id', 'DESC')->paginate(5);
        // return view('Admin.User.index', compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.User.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('Admin.User.create', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createpost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('Admin.User.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles->pluck('id')->toArray();


        return view('Admin.User.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($id)
    {
        $user = User::find($id);

        return view('Admin.User.resetPassword', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatepassword(Request $request)
    {
        $id = $request->input('UserId');

        $this->validate($request, [
            'password' => 'required|same:confirm-password'
        ]);

        $input = $request->all();

        $user = User::find($id);
        //$user->password = Hash::make($input['password']);
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect()->route('admin.user.index')
            ->with('success', 'User updated successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatepost(Request $request)
    {
        $id = $request->input('UserId');
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required'
        ]);


        $input = $request->all();
        // if (!empty($input['password'])) {
        //     $input['password'] = Hash::make($input['password']);
        // } else {
        //     $input = array_except($input, array('password'));
        // }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_roles')->where('model_id', $id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('admin.user.index')
            ->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete(Request $request)
    {
        $ids = explode(",", $request->get('UserId'));

        DB::table("users")->whereIn('id', $ids)->delete();
        DB::table("model_roles")->whereIn('model_id', $ids)->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User deleted successfully');
    }
}
