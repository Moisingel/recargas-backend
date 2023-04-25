<?php

use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json(['message' => 'Hello World']);
});

Route::group(['prefix' => 'resources'], function () {
    Route::get('/all-banks', [ResourceController::class, 'allBanks']);
    Route::get('/all-channels', [ResourceController::class, 'allChannels']);
    Route::get('/all-currencies', [ResourceController::class, 'allCurrencies']);
    Route::get('/promoter/{id}', [ResourceController::class, 'findPromoterById']);
    Route::get('/client/{playerId}', [ResourceController::class, 'findClientByPlayerId']);
});

Route::group(['prefix' => 'recharge'], function () {
    Route::post('', [WalletController::class, 'recharge']);
    Route::put('/{transactionId}', [WalletController::class, 'updateRecharge']);
});

Route::group(['prefix' => 'wallet'], function () {
    Route::get('/{walletId}/transactions', [WalletController::class, 'transactionsPaginateFilter']);
});

