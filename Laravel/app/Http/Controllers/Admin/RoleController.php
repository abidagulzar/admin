<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DataTables;
use DateTime;
use DB;
use Hash;


class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Role View|Role Create|Role Edit|Role Delete', ['only' => ['index', 'createpost']]);
        $this->middleware('permission:Role Create', ['only' => ['create', 'createpost']]);
        $this->middleware('permission:Role Edit', ['only' => ['edit', 'updatepost']]);
        $this->middleware('permission:Role Delete', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Role::orderBy('id', 'DESC')->paginate(5);
        // return view('Admin.Role.index', compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        if ($request->ajax()) {
            $data = Role::select('id', 'name', 'guard_name', 'created_at', 'updated_at')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.Role.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('Admin.Role.create', compact('permission'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);


        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));


        return redirect()->route('admin.role.index')
            ->with('success', 'Role created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_permissions", "role_permissions.permission_id", "=", "permissions.id")
            ->where("role_permissions.role_id", $id)
            ->get();


        return view('Admin.Role.show', compact('role', 'rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_permissions")->where("role_permissions.role_id", $id)
            ->pluck('role_permissions.permission_id', 'role_permissions.permission_id')
            ->all();

        return view('Admin.Role.edit', compact('role', 'permission', 'rolePermissions'));
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $id = $request->input('RoleId');
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();


        $role->syncPermissions($request->input('permission'));


        return redirect()->route('admin.role.index')
            ->with('success', 'Role updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = explode(",", $request->get('id'));

        DB::table("roles")->whereIn('id', $ids)->delete();
        return redirect()->route('admin.role.index')
            ->with('success', 'Role deleted successfully');
    }
}
