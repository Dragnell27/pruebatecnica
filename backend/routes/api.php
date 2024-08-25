<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ParamController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/countries',[ParamController::class, 'countries']);

Route::get('/cities/{country}',[ParamController::class, 'cities']);

// Route::get('/coin/{country}',[ParamController::class, 'coin']);

Route::post('/history_storage',[HistoryController::class, 'storage']);

Route::get('/history_show',[HistoryController::class, 'show']);

Route::post('/calculator',[HistoryController::class, 'calculator']);

