<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard',[MenuController::class,'dashboard']);

    //Role Routes
    Route::get('role', [RoleController::class,'index'])->name('role');
    Route::post('role', [RoleController::class,'store'])->name('role');
    Route::get('role/create', [RoleController::class,'create'])->name('role.create');
    Route::get('role/edit/{id}', [RoleController::class,'edit'])->name('role.edit');
    Route::post('role/update', [RoleController::class,'update'])->name('role.update');

    //User Routes
    Route::get('users',[UserController::class,'index'])->name('users');
    Route::post('users',[UserController::class,'store'])->name('users');
    Route::get('users/create',[UserController::class,'create'])->name('users.create');
    Route::get('users/edit/{id}',[UserController::class,'edit'])->name('users.edit');
    Route::put('users/update',[UserController::class,'update'])->name('users.update');

    //Permmission Routes
    Route::get('permissions',[PermissionController::class,'index'])->name('permissions');
    Route::post('permissions',[PermissionController::class,'store'])->name('permissions');
    Route::get('permissions/create',[PermissionController::class,'create'])->name('permissions.create');
    Route::get('permissions/edit/{id}',[PermissionController::class,'edit'])->name('permissions.edit');
    Route::put('permissions/update',[PermissionController::class,'update'])->name('permissions.update');
});