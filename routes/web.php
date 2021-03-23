<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Departments;
use App\Http\Livewire\Users;
use App\Http\Livewire\Permissions;
use App\Http\Controllers\Admin\RoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('sercop/admin/')->name('admin.')->middleware('auth:web')->group(function () {
    Route::get('/departments', Departments::class)->name('departments');

    Route::get('/users', Users::class)->name('users');

    Route::resource('roles', RoleController::class);

    Route::get('/permissions', Permissions::class)->name('permissions');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
