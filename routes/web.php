<?php

use App\Http\Controllers\ApiTokenManagerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(App\Http\Middleware\SetLocale::class)->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}/complete', OrderCompleteController::class)->name('orders.complete');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/locale/{locale}', function (string $locale) {
        abort_unless(in_array($locale, ['en', 'vi', 'ja'], true), 404);
        session(['locale' => $locale]);

        return back();
    })->name('locale');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/api-tokens', [ApiTokenManagerController::class, 'index'])->name('apiTokens.index');
    });
});
