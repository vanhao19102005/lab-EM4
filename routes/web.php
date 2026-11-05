<?php
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
Route::middleware(App\Http\Middleware\SetLocale::class)->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}/complete', OrderCompleteController::class)->name('orders.complete');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/locale/{locale}', function (string $locale) { abort_unless(in_array($locale, ['en','vi','ja'], true), 404); session(['locale'=>$locale]); return back(); })->name('locale');
});
