<?php

namespace App\Http\Controllers;

// use App\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('view permissions')) {
        if (request()->ajax()) {

            $data = Permission::orderBy('id', 'desc')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('roles', function ($data) {
                $roles = $this->getRolesByPermission($data->name);
                return $roles;
            })
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-m-Y h:i A');
                return $formatedDate;
            })
            ->make(true);
        }
        return view('user.permission.index');
        } else {
        return response()->view('errors.403', [], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $permission = Permission::make(["name" => $request->name]);
            $permission->saveOrFail();
            return response()->json([
              'status' => 'success',
              'message' => $request->name . ' created successfully',
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function getRolesByPermission($permission)
    {
        $roles = Role::all();
        foreach ($roles as $role) {
        $data[] = $role->hasPermissionTo($permission) ? $role->name : '';
        }

        return array_filter($data);
    }
}
