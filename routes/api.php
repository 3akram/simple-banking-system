<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/getAccountBalance', [ApiController::class, 'getAccountBalance']);
Route::post('/withdrawMoney'    , [ApiController::class, 'withDrawMoney']);
Route::post('/depositMoney'     , [ApiController::class, 'depositMoney']);
Route::post('/transferMoney'    , [ApiController::class, 'transferMoney']);
