<?php

use App\Http\Controllers\Api\AnalyticController;
use App\Http\Controllers\Api\FaqsController;
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


Route::get('/fetch/all/faqs', [FaqsController::class, 'fetchAllFaqs']);
Route::post('/store/analytic', [AnalyticController::class, 'index']);
