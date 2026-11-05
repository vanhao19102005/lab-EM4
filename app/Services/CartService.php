<?php
namespace App\Services;
use App\Models\Cart;
use App\Models\CartItem;
class CartService { public function getCart(): Cart { $cart = Cart::query()->with('items.product')->where('user_id', UserService::getUserIdFromSession())->doesntHave('order')->first(); return $cart ?? Cart::create(['user_id' => UserService::getUserIdFromSession()]); } public function addCartItem(array $data): CartItem { $cart = $this->getCart(); return CartItem::updateOrCreate(['cart_id' => $cart->id, 'product_id' => $data['product_id']], ['quantity' => $data['quantity'], 'notes' => $data['notes'] ?? null]); } public function removeCartItem(int $id): void { $this->getCart()->items()->whereKey($id)->delete(); } }
