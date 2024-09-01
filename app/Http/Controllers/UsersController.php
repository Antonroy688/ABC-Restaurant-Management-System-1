<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityPermission;
use App\Models\Country;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Brian2694\Toastr\Toastr as ToastrToastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:Users Delete')->only('destroy');
        $this->middleware('permission:Users Edit')->only(['edit','update']);
        $this->middleware('permission:Users View')->only('index');
        $this->middleware('permission:Users Create')->only(['store','create']);
        $this->middleware('permission:Zone Permission Management')->only(['citypermissionUpdate','citypermission']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->get('query')?$request->get('query'):'';
            $users = User::whereHas('roles', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');     
            })->orWhere('name','like', '%' . $search . '%')
            ->orWhere('email', $search )
            ->orWhereHas('cityPermissions.city', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orderBy('name','Asc')->paginate(10);  
        
            return view('users.filter', compact('users')) ;
        }else{
            $users=User::paginate(10);
            return view('users.index',compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles=Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $role=Role::findById($request->role)->name;
            $user=new User;
            $user->name=$request->first_name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();

            $user->assignRole($role);
            DB::commit();

            Toastr::success('Employee created Successfuly.');
            activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
            ->log($user->name.' Employee created.');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('something went wrong!');
            return back()->withInput();
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $user=User::find($id);
        $roles=Role::all();
        return view('users.edit',compact('user','roles'));
    }

    public function show(string $id)
    {
        dd('show');
    }
    public function profile(Request $request)
    {
        $user=Auth::user();
        return view('auth.profile',compact('user'));
    }

    public function ActiveUsers(Request $request)
    {
    $activeUsers = User::where('last_login', '>=', Carbon::now()->subDays(30))
    ->where(function ($query) {
        $query->whereNull('last_logout')
              ->orWhereColumn('last_login', '>', 'last_logout');
    })
    ->where('last_activity', '>=', Carbon::now()->subMinutes(5))
    ->get();
    return view('users.activeUsers',compact('activeUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function citypermission(string $id)
    {
        $countries = Country::where('status',1)->with('cities.state')->paginate(10);
        $user=User::with('CityPermissions')->find($id);
        return view('users.city-index',compact('user','countries'));
    }
    public function citypermissionUpdate(Request $request, string $id)
    {
        $request->validate([
            'city_ids' => 'required|array',
            // 'city_ids.*' => 'exists:cities,id',
        ]);

        try {
            DB::beginTransaction();
            $user = User::find($id);
            
            $user->cityPermissions()->delete();
            foreach ($request->city_ids as $cityId) {
                CityPermission::create([
                    'user_id' => $user->id,
                    'city_id' => $cityId,
                ]);
            }
            
            DB::commit();
            Toastr::success('City Permissions Updated Successfully');
            activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
            ->log($user->name.' City Permissions Updated.');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Something went wrong!');
            return back()->withInput();
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user=User::find($id);
            $userRole=$user->roles->pluck('name')[0];
            $new_role=Role::findById($request->role)->name;
            $user->name=$request->first_name;
            $user->email=$request->email;
            $user->save();
            $user->removeRole($userRole);
            $user->assignRole($new_role);
            DB::commit();

            Toastr::success('Employee Updated Successfuly.');
            activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
            ->log($user->name.' Employee Updated.');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('something went wrong!');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find($id);
        $deletedUser=$user;
        $user->delete();
        Toastr::success('Employee Deleted Successfuly.');
        activity()
        ->causedBy(Auth::user())
        ->performedOn($deletedUser)
        ->withProperties(["attributes"=>['ip_address' => request()->ip()]])
        ->log($user->name.' Employee Updated.');
        return back();
    }
}
