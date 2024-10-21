<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'loadLogin'])->name('loadLogin');
    Route::post('/', [AuthController::class, 'userLogin'])->name('userLogin');
    Route::get('/register', [AuthController::class, 'loadRegister'])->name('loadRegister');
    Route::post('/user-register', [AuthController::class, 'userRegister'])->name('userRegister');
});

Route::group(['middleware' => ['isAuthenticated']], function () {
    Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->name('loadDashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Manage Roles Routes
    Route::controller(RoleController::class)->group(function () {
        Route::get('/manage-roles', 'manageRole')->name('manageRole');
        Route::post('/create-role', 'createRole')->name('createRole');
        Route::post('/update-role', 'updateRole')->name('updateRole');
        Route::post('/delete-role', 'deleteRole')->name('deleteRole');
    });

    //Manage Permissions Routes
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/manage-permissions', 'managePermission')->name('managePermission');
        Route::post('/create-permission', 'createPermission')->name('createPermission');
        Route::post('/update-permission', 'updatePermission')->name('updatePermission');
        Route::post('/delete-permission', 'deletePermission')->name('deletePermission');
        // Permission to Roles Assignment Routes
        Route::get('/assign-permission-role', 'assignPermissionRole')->name('assignPermissionRole');
        Route::post('/create-permission-role', 'createPermissionRole')->name('createPermissionRole');
        Route::post('/update-permission-role', 'updatePermissionRole')->name('updatePermissionRole');
        Route::post('/delete-permission-role', 'deletePermissionRole')->name('deletePermissionRole');
    });
});
