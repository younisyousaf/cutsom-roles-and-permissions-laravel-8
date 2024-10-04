<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'loadLogin'])->name('loadLogin');
    Route::post('/', [AuthController::class, 'userLogin'])->name('userLogin');
});

Route::group(['middleware' => ['isAuthenticated']], function () {
    Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->name('loadDashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/manage-roles', [RoleController::class, 'manageRole'])->name('manageRole');
    Route::post('/create-role', [RoleController::class, 'createRole'])->name('createRole');
    Route::post('/delete-role', [RoleController::class, 'deleteRole'])->name('deleteRole');
});
