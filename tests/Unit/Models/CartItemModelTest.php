<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Tests\TestCase;

class CartItemModelTest extends TestCase
{
    public function test_cart_item_can_retrieve_its_cart(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Cart::class, $cartItem->cart);
    }

    public function test_cart_item_can_retrieve_its_product(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Product::class, $cartItem->product);
    }
}
