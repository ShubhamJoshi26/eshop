<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('view users')) {
            if (request()->ajax()) {

                $data = User::orderBy('id', 'desc')->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('role', function ($data) {
                        $role = $data->getRoleNames();
                        return $role;
                    })
                    ->editColumn('created_at', function ($data) {
                        return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-m-Y h:i A');
                    })
                    ->addColumn('editUrl', function ($data) {
                        return Auth::user()->hasPermissionTo('edit users') ? route('users.edit', $data->id) : '';
                    })
                    ->make(true);
            }
            return view('user.index');
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('create users')) {
            $roles = \Spatie\Permission\Models\Role::all();
            return view('user.create', ['roles' => $roles]);
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('create users')) {
            try {

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->password),
                ]);

                $role = Role::find($request->role_id);
                $user->assignRole([$role->id]);

                if ($request->hasFile('profile_photo_path')) {
                    $path = 'assets/img/avatars';
                    if (!File::exists(public_path($path))) {
                        File::makeDirectory(public_path($path), 0777);
                    }

                    $avatarName = $user->id . '.' . $request->profile_photo_path->extension();
                    $request->profile_photo_path->move(public_path($path), $avatarName);
                    $user->update(['profile_photo_path' => $path . '/' . $avatarName]);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'User created successfully!',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('edit users')) {
            $user = User::find($userId);
            $assignedRole = $user->getRoleNames()->toArray();
            $roles = \Spatie\Permission\Models\Role::all();
            return view('user.edit', ['roles' => $roles, 'user' => $user, 'assignedRole' => $assignedRole]);
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('edit users')) {
            try {
                // dd($request->all());
                $user = User::find($request->id);

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                ]);

                $role = Role::find($request->role_id);
                $user->syncRoles([]);
                $user->assignRole([$role->id]);

                if ($request->hasFile('profile_photo_path')) {
                    $path = 'assets/img/avatars';
                    if (!File::exists(public_path($path))) {
                        File::makeDirectory(public_path($path), 0777);
                    }

                    $avatarName = $user->id . '.' . $request->profile_photo_path->extension();
                    $request->profile_photo_path->move(public_path($path), $avatarName);
                    $user->update(['profile_photo_path' => $path . '/' . $avatarName]);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'User updated successfully!',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
