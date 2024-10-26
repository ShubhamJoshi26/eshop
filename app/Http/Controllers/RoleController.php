<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('view roles')) {
            if (request()->ajax()) {

                $data = Role::orderBy('id', 'desc')->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('editUrl', function ($data) {
                        return Auth::user()->hasPermissionTo('edit roles') ? route('role.edit', $data->id) : '';
                    })
                    ->make(true);
            }
            return view('user.role.index');
          } else {
            return response()->view('errors.403', [], 403);
          }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('create roles')) {
            $permissions = Permission::orderBy('id', 'asc')->get();
            $permissionData = array();
      
            foreach ($permissions as $permission) {
              $permissionName = explode(" ", $permission->name);
              $permissionData[$permissionName[1]][$permission->id] = ucwords($permissionName[0]);
            }
      
            return view('user.role.create', compact('permissionData'));
          } else {
            return response()->view('errors.403', [], 403);
          }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('create roles')) {
            try {
              $role = Role::create(['name' => $request->name]);
      
              $permissions = Permission::whereIn('id', $request->permissions)->get();
              $role->syncPermissions($permissions);
      
              return response()->json([
                'status' => 'success',
                'message' => $request->name . ' created successfully!',
              ]);
            } catch (\Exception $e) {
              $message = strpos($e->getMessage(), 'Duplicate') !== false
                ? $request->name . ' already exists'
                : $e->getMessage();
              return response()->json([
                'status' => 'error',
                'message' => $message,
              ]);
            }
          } else {
            return response()->view('errors.403', [], 403);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        if (Auth::check() && Auth::user()->hasPermissionTo('edit roles')) {
            // $permissions = Permission::whereNotIn('name', ['view permissions', 'create permissions', 'edit permissions', 'delete permissions'])->orderBy('id', 'asc')->get();
            $permissions = Permission::orderBy('id', 'asc')->get();
            $permissionData = array();
      
            foreach ($permissions as $permission) {
              $permissionName = explode(" ", $permission->name);
              $permissionData[$permissionName[1]][$permission->id] = ucwords($permissionName[0]);
            }
      
            $role = Role::find($id);
            $allotedPermissions = $role->permissions->pluck('id')->toArray();
            return view('user.role.edit', compact(['role', 'allotedPermissions', 'permissionData']));
          }else {
            return response()->view('errors.403', [], 403);
          }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('edit roles')) {
          try {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
    
            $alreadyAssinedPermissions = $role->permissions;
            foreach($alreadyAssinedPermissions as $alreadyAssinedPermission){
              $role->revokePermissionTo($alreadyAssinedPermission);
            }
    
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
    
            return response()->json([
             'status' =>'success',
             'message' => $request->name .' updated successfully!',
            ]);
          } catch (\Exception $e) {
            $message = strpos($e->getMessage(), 'Duplicate')!== false
             ? $request->name .' already exists'
              : $e->getMessage();
            return response()->json([
             'status' => 'error',
             'message' => $message,
            ]);
          }
        }else {
          return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
