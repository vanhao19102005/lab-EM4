<?php
namespace App\Livewire\Checkout;
use App\Events\BrowserEvent;
use App\Events\LivewireEvent;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;
class AddCartItemPopup extends Component
{
    public ?Product $product = null;
    public int $quantity = 1;
    public string $notes = '';

    #[On(LivewireEvent::USER_SELECT_PRODUCT)]
    public function displayAddCartItem(int $product_id, CartService $cart): void
    {
        $this->product = Product::findOrFail($product_id);
        $this->resetValidation();
        $this->quantity = 1;
        $this->notes = '';
        if ($item = $cart->getCart()->items()->where('product_id', $product_id)->first()) {
            $this->quantity = $item->quantity;
            $this->notes = $item->notes ?? '';
        }
        $this->dispatch(BrowserEvent::DISPLAY_OFFCANVAS);
    }

    public function increment(): void { $this->quantity = min(99, $this->quantity + 1); }
    public function decrement(): void { $this->quantity = max(1, $this->quantity - 1); }

    public function addCartItem(CartService $cart): void
    {
        $this->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99'], 'notes' => ['nullable', 'string', 'max:500']]);
        abort_if(! $this->product, 404);
        $cart->addCartItem([
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'notes' => $this->notes,
        ]);
        $this->dispatch(LivewireEvent::CART_UPDATED_EVENT);
        $this->dispatch(BrowserEvent::CLOSE_OFFCANVAS);
    }

    public function render() { return view('livewire.checkout.add-cart-item-popup'); }
}
