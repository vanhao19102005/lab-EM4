<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\Order;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    public function test_order_can_retrieve_its_cart(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Cart::class, $order->cart);
    }

    public function test_order_signed_path_opens_its_detail_page(): void
    {
        $order = Order::factory()->create();

        $this->get($order->getCheckoutConfirmationPath())->assertOk();
    }

    public function test_order_detail_requires_a_valid_signature(): void
    {
        $order = Order::factory()->create();

        $this->get(route('orders.show', $order))->assertForbidden();
    }
}
