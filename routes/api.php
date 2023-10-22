<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\GlobalSearchController;

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
Route::middleware('auth:sanctum')->get('/merchant/monthly', [MerchantController::class, 'getMonthlyTicketCount']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::middleware(['web', 'auth'])->get('/global-search', [GlobalSearchController::class, 'search']);

