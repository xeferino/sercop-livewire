<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Departments;
use App\Http\Livewire\Procedures;
use App\Http\Livewire\TypeProcedures;
use App\Http\Livewire\Stages;
use App\Http\Livewire\Sections;
use App\Http\Livewire\Users;
use App\Http\Livewire\Permissions;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProcedureController;
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

    Route::get('/types-procedures', TypeProcedures::class)->name('types');

    Route::get('/stages', Stages::class)->name('stages');

    Route::get('/sections', Sections::class)->name('sections');

    Route::get('/users', Users::class)->name('users.index');

    Route::resource('users', UserController::class)->except(['index']);

    Route::get('/procedures/download/{file}', 'App\Http\Controllers\Admin\ProcedureController@downloadFile')->name('procedures.download.file');

    Route::get('/procedures', Procedures::class)->name('procedures.index');

    Route::post('/procedures/type', 'App\Http\Controllers\Admin\ProcedureController@type')->name('procedures.type');

    Route::put('/procedures/update/{procedure}', 'App\Http\Controllers\Admin\ProcedureController@updateProcedure')->name('procedures.update.single');

    Route::resource('procedures', ProcedureController::class)->except(['index']);

    Route::resource('roles', RoleController::class);

    Route::get('/permissions', Permissions::class)->name('permissions');

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});
