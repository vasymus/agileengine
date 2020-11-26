<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get("users/{user_id}/accounts/{account_id}/transactions", [\App\Http\Controllers\UserAccountTransactionsController::class, "index"]);

Route::get("users/{user_id}/accounts/{account_id}/transactions/{transaction_id}", [\App\Http\Controllers\UserAccountTransactionsController::class, "show"]);

Route::post("users/{user_id}/accounts/{account_id}/transactions", [\App\Http\Controllers\UserAccountTransactionsController::class, "store"]);

Route::get("users/{user_id}/accounts/{account_id}/balance", \App\Http\Controllers\UserAccountBalanceController::class);
