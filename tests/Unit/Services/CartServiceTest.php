<?php

namespace Tests\Unit\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    private CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = new CartService();
    }

    public function test_get_cart_returns_a_cart_instance(): void
    {
        $this->assertInstanceOf(Cart::class, $this->cartService->getCart());
    }

    public function test_get_cart_uses_the_current_session_user_id(): void
    {
        Session::put('user_id', 'DUMMY_USER_ID');

        $this->assertSame('DUMMY_USER_ID', $this->cartService->getCart()->user_id);
    }

    public function test_get_cart_creates_a_new_cart_after_the_current_cart_is_ordered(): void
    {
        $currentCart = $this->cartService->getCart();
        $currentCart->order()->save(Order::factory()->make());
        $newCart = $this->cartService->getCart();

        $this->assertNotSame($currentCart->id, $newCart->id);
    }

    public function test_get_cart_returns_the_same_open_cart_for_the_session(): void
    {
        $cart = $this->cartService->getCart();

        for ($i = 0; $i < 8; $i++) {
            $lastCart = $this->cartService->getCart();
        }

        $this->assertSame($cart->id, $lastCart->id);
        $this->assertSame($cart->user_id, $lastCart->user_id);
    }

    public function test_get_cart_item_finds_an_item_by_product_id(): void
    {
        $cart = $this->cartService->getCart();
        $cart->items()->saveMany(CartItem::factory()->count(3)->make());
        $cartItem = $cart->items()->first();

        $this->assertNotNull($cartItem);
        $this->assertSame($cartItem->id, $this->cartService->getCartItem($cartItem->product_id)?->id);
    }

    public function test_remove_cart_item_removes_existing_items_and_returns_false_when_missing(): void
    {
        $cart = $this->cartService->getCart();
        $cart->items()->saveMany(CartItem::factory()->count(3)->make());
        $cartItem = $cart->items()->first();

        $this->assertNotNull($cartItem);
        $this->assertTrue($this->cartService->removeCartItem($cartItem->product_id));
        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
        $this->assertFalse($this->cartService->removeCartItem($cartItem->product_id));
    }

    public function test_add_cart_item_persists_product_quantity_and_notes(): void
    {
        $product = Product::factory()->create();
        $cart = $this->cartService->getCart();
        $data = ['product_id' => $product->id, 'quantity' => 15, 'notes' => 'here my notes'];

        $this->cartService->addCartItem($data);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'notes' => $data['notes'],
        ]);
    }
}
