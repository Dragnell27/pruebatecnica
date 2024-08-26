<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ParamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API para traer los países
Route::get('/countries',[ParamController::class, 'countries']);

//API para traer las ciudades de un país
Route::get('/cities/{country}',[ParamController::class, 'cities']);

//API para traer el historial
Route::get('/history_show',[HistoryController::class, 'show']);

//API para traer la información referente al clima y moneda
Route::post('/calculator',[HistoryController::class, 'calculator']);

