<?php
namespace App\Services;
use App\Models\Cart;
use App\Models\CartItem;
class CartService
{
    public function getCart(): Cart
    {
        $userId = UserService::getUserIdFromSession();
        $cart = Cart::query()->with('items.product')->where('user_id', $userId)->doesntHave('order')->first();
        return $cart ?? Cart::factory()->create(['user_id' => $userId]);
    }

    public function addCartItem(array $item): CartItem
    {
        $cart = $this->getCart();
        return CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $item['product_id']],
            ['quantity' => $item['quantity'], 'notes' => $item['notes'] ?? null],
        );
    }

    public function removeCartItem(int $productId): bool
    {
        return (bool) $this->getCart()->items()->where('product_id', $productId)->delete();
    }

    public function getCartItem(int $productId): ?CartItem
    {
        return $this->getCart()->items()->where('product_id', $productId)->first();
    }
}
