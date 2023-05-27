<?php

use App\Infrastructure\Controllers\BuyCoinController;
use App\Infrastructure\Controllers\OpenNewWalletController;
//use App\Infrastructure\Controllers\SellCoinController;
use App\Infrastructure\Controllers\GetStatusController;
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
Route::post('coin/buy', BuyCoinController::class);

//Route::get('/wallet/{wallet_id}', GetsWalletCryptocurrenciesController::class);

Route::get('/status', GetStatusController::class);

//Route::post('coin/sell', SellCoinController::class);

Route::post('wallet/open', OpenNewWalletController::class);


