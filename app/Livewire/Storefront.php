<?php
namespace App\Livewire;
use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
class Storefront extends Component {
 public ?int $categoryId = null; public ?int $selectedProductId = null; public int $quantity = 1; public string $notes = '';
 public function getCategoriesProperty() { return Category::withCount('products')->orderBy('name')->get(); }
 public function getProductsProperty() { return Product::with('category')->when($this->categoryId, fn ($q) => $q->where('category_id', $this->categoryId))->orderBy('name')->get(); }
 public function getCartProperty() { return app(CartService::class)->getCart()->load('items.product'); }
 public function chooseProduct(int $id): void { $this->selectedProductId = $id; $this->quantity = 1; $this->notes = ''; $this->dispatch('open-product'); }
 public function increment(): void { $this->quantity = min(99, $this->quantity + 1); }
 public function decrement(): void { $this->quantity = max(1, $this->quantity - 1); }
 public function addToCart(CartService $cart): void { $this->validate(['quantity' => 'required|integer|min:1|max:99', 'notes' => 'nullable|string|max:500']); $product = Product::findOrFail($this->selectedProductId); $existing = $cart->getCart()->items()->where('product_id', $product->id)->first(); $cart->addCartItem(['product_id' => $product->id, 'quantity' => $this->quantity + ($existing?->quantity ?? 0), 'notes' => $this->notes]); Log::info('Cart item added', ['product_id' => $product->id]); $this->selectedProductId = null; $this->dispatch('close-product'); $this->dispatch('cart-updated'); session()->flash('notice', __('Added to cart')); }
 public function removeItem(int $id, CartService $cart): void { $cart->removeCartItem($id); $this->dispatch('cart-updated'); }
 public function updateQuantity(int $id, int $quantity, CartService $cart): void { $cart->getCart()->items()->whereKey($id)->update(['quantity' => max(1, min(99, $quantity))]); $this->dispatch('cart-updated'); }
 public function render() { return view('livewire.storefront')->layout('layouts.app', ['title' => __('Coffee Shop')]); }
}
