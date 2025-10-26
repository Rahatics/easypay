<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\GatewaysController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SetupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Test Menu Route
Route::get('/test-menu', function () {
    return view('test-menu');
})->name('test-menu');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Checkout Routes (public - no auth required)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/payment/bkash', [CheckoutController::class, 'showBkashPage'])->name('payment.bkash');
Route::get('/payment/nagad', [CheckoutController::class, 'showNagadPage'])->name('payment.nagad');
Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
Route::post('/checkout/callback', [CheckoutController::class, 'paymentCallback'])->name('checkout.callback');
Route::post('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

// Documentation Routes
Route::get('/docs/integration', function () {
    return view('docs.integration');
})->name('docs.integration');

// Integration Demo Route
Route::get('/integration-demo', function () {
    return view('integration-demo');
})->name('integration.demo');

// Test Routes
Route::get('/test-payment-pages', function () {
    return '<h1>Payment Pages Test</h1>
            <p><a href="'.route('payment.bkash').'">Bkash Payment Page</a></p>
            <p><a href="'.route('payment.nagad').'">Nagad Payment Page</a></p>
            <p><a href="'.route('checkout').'">Main Checkout Page</a></p>';
});

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::put('/setup', [SetupController::class, 'update'])->name('setup.update');
    Route::post('/setup/generate-credentials', [SetupController::class, 'generateCredentials'])->name('setup.generate.credentials');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('/gateways', [GatewaysController::class, 'index'])->name('gateways');
    Route::put('/gateways/{id}', [GatewaysController::class, 'update'])->name('gateways.update');
    Route::post('/gateways/{id}/toggle', [GatewaysController::class, 'toggleStatus'])->name('gateways.toggle');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Minimal UI Routes
    Route::get('/dashboard-minimal', function () {
        return view('dashboard_minimal');
    })->name('dashboard.minimal');

    Route::get('/setup-minimal', function () {
        return view('setup_minimal');
    })->name('setup.minimal');

    Route::get('/orders-minimal', function () {
        return view('orders_minimal');
    })->name('orders.minimal');

    Route::get('/gateways-minimal', function () {
        return view('gateways_minimal');
    })->name('gateways.minimal');

    Route::get('/settings-minimal', function () {
        return view('settings_minimal');
    })->name('settings.minimal');
});
