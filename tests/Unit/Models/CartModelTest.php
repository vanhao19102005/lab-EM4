<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class CartModelTest extends TestCase
{
    public function test_cart_can_retrieve_its_items(): void
    {
        $cart = Cart::factory()->has(CartItem::factory()->count(3), 'items')->create();

        $this->assertCount(3, $cart->items);
        $this->assertInstanceOf(CartItem::class, $cart->items->random());
    }

    public function test_cart_can_retrieve_its_order(): void
    {
        $cart = Cart::factory()
            ->has(Order::factory(), 'order')
            ->has(CartItem::factory()->count(3), 'items')
            ->create();

        $this->assertInstanceOf(Order::class, $cart->order);
    }

    public function test_cart_currency_defaults_to_product_currency(): void
    {
        $cart = Cart::factory()->create();

        $this->assertSame(Product::DEFAULT_CURRENCY, $cart->currency);
    }

    public function test_cart_total_amount_is_the_sum_of_its_items(): void
    {
        $cart = Cart::factory()->has(CartItem::factory()->count(3), 'items')->create();
        $expected = $cart->items->sum(fn (CartItem $item) => (float) $item->product->price * $item->quantity);

        $this->assertEquals($expected, $cart->total_amount);
    }

    public function test_cart_total_amount_has_a_formatted_attribute(): void
    {
        $cart = Cart::factory()->has(CartItem::factory()->count(3), 'items')->create();
        $expected = number_format($cart->total_amount, 0, ',', '.').' '.$cart->currency;

        $this->assertSame($expected, $cart->formatted_total_amount);
    }
}
