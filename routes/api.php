<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;

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

// Payment API Routes
Route::prefix('payment')->group(function () {
    Route::post('/process', [PaymentController::class, 'process'])->name('api.payment.process');
    Route::post('/callback', [PaymentController::class, 'callback'])->name('api.payment.callback');
});
