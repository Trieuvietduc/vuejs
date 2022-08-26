<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

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



Route::middleware('auth')->group(function () {
    Route::resource('company', CompanyController::class);
    Route::resource('user', UserController::class);
    Route::get('/', function () {
        return redirect()->route('company.index');
    });
    Route::get('companys/onlyTrashed', [CompanyController::class, 'onlyTrashed'])->name('company_onlyTrashed');
    Route::get('users/onlyTrashed', [UserController::class, 'UseronlyTrashed'])->name('user_onlyTrashed');
    //
    Route::get('companys/restore/{id}', [CompanyController::class, 'restore'])->name('companys.restore');
    Route::get('users/restore/{id}', [UserController::class, 'Userrestore'])->name('users.restore');
});
Route::post('check-email', [UserController::class, 'checkEmail'])->name('user.checkEmail');
Route::resource('login', LoginController::class);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
