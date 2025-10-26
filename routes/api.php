<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\VerificationController;

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

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Payment API Routes
Route::prefix('payment')->group(function () {
    Route::post('/process', [PaymentController::class, 'process'])->name('api.payment.process')->middleware(['auth.api_request', 'throttle:60,1']);
    Route::post('/callback', [PaymentController::class, 'callback'])->name('api.payment.callback');
});

// Mobile App API Routes (V1)
Route::prefix('v1')->group(function () {
    // Order Management
    Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
        Route::get('/orders/pending', [OrderController::class, 'getPendingOrders']);
        Route::post('/orders/{order}/approve', [OrderController::class, 'approveOrder']);
        Route::post('/orders/{order}/reject', [OrderController::class, 'rejectOrder']);

        // Auto Verification
        Route::post('/verify-payment/sms', [VerificationController::class, 'verifyPaymentFromSMS']);
    });
});
