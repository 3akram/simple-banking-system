<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::resource('accounts', 'App\Http\Controllers\AccountsController');
Route::PUT('/accounts/{id}/status', [App\Http\Controllers\AccountsController::class, 'flipStatus'])->name('accounts.status');
Route::POST('/accounts/filter/by-bank', [App\Http\Controllers\AccountsController::class, 'applyFilter'])->name('accounts.applyFilter');

Route::get('/test', function(){
    return 'test works !!!';
});
