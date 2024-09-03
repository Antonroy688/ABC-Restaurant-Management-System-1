<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\PermissionGroup;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:Roles Delete')->only('destroy');
        $this->middleware('permission:Roles Edit')->only(['edit','update']);
        $this->middleware('permission:Roles View')->only('index');
        $this->middleware('permission:Roles Create')->only('store');
    }
    public function index()
    {
        $roles=Role::with('permissions')->get();
        $permissionGroups=PermissionGroup::all();
        return view('admin.roles.index',compact('roles','permissionGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rolename' => 'required|string|max:255',
            'permission_id' => 'required|array',
            'permission_id.*' => 'exists:permissions,name',
        ]);
        try {
            DB::beginTransaction();
            $role=new Role();
            $role->name=$request->rolename;
            $role->save();

            $role->syncPermissions($request->permission_id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Something went wrong!');
            return back()->withInput();
        }
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log($role->name.' - Roles and Permission Created.');
        Toastr::success('Roles and Permission Added Successfully');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role=Role::with('permissions')->find($id);
        $permissionGroups=PermissionGroup::all();
        return view('admin.roles.edit',compact('role','permissionGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'rolename' => 'required|string|max:255',
            // 'permission_id' => 'required|array',
            // 'permission_id.*' => 'exists:permissions,name',
        ]);
        try {
            DB::beginTransaction();
            $role=Role::find($id);
            $role->name=$request->rolename;
            $role->save();

            $role->syncPermissions($request->permission_id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Something went wrong!');
            return back()->withInput();
        }
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log($role->name.' - Roles and Permission Updated.');
        Toastr::success('Roles and Permission Updated Successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role=Role::findById($id);
        $deletedRole=Role::findById($id);
        // $role->delete();
        Toastr::success('Roles and Permission Deleted Successfully');
        activity()
        ->causedBy(Auth::user())
        ->performedOn(Auth::user())
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log($deletedRole->name.' - Roles and Permission deleted.');
        return redirect()->route('roles.index');
    }
    public function citypermission()
    {
        $users=User::with('CityPermissions')->get();
        $countries=Country::all();
        return view('admin.citypermission.index',compact('users','countries'));
    }
}
