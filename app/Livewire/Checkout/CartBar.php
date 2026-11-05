<?php

namespace App\Livewire\Checkout;

use App\Events\LivewireEvent;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class CartBar extends Component
{
    public Cart $cart;
    public bool $display = false;

    public function mount(): void { $this->loadingCartData(); }

    #[On(LivewireEvent::CART_UPDATED_EVENT)]
    public function loadingCartData(): void
    {
        $this->cart = app(CartService::class)->getCart()->load('items.product');
        $this->display = $this->cart->items->isNotEmpty();
    }

    public function removeCartItem(int $product_id, CartService $service): void
    {
        $service->removeCartItem($product_id);
        $this->loadingCartData();
        $this->dispatch(LivewireEvent::CART_UPDATED_EVENT);
        Log::channel('user_actions')->info('User removed product from cart', ['product_id' => $product_id]);
    }

    public function checkout() { return redirect()->route('checkout.index'); }
    public function render() { return view('livewire.checkout.cart-bar'); }
}
