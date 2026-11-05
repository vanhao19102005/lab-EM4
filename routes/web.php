<?php
use App\Http\Controllers\OrderController;
use App\Livewire\Checkout\CheckoutScreen;
use App\Livewire\Storefront;
use Illuminate\Support\Facades\Route;
Route::middleware(\App\Http\Middleware\SetLocale::class)->group(function () {
 Route::get('/', Storefront::class)->name('home');
 Route::get('/checkout', CheckoutScreen::class)->name('checkout');
 Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
 Route::get('/locale/{locale}', function (string $locale) { abort_unless(in_array($locale, ['en','vi','ja'], true), 404); session(['locale'=>$locale]); return redirect()->back(); })->name('locale');
});
