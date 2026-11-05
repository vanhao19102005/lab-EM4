<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    public function test_checkout_page_renders_successfully(): void
    {
        $this->get(route('checkout.index'))->assertOk();
    }

    public function test_checkout_displays_the_current_cart_items_and_amounts(): void
    {
        $userId = 'DUMMY_USER_ID';
        $cart = Cart::factory()
            ->has(CartItem::factory()->count(3), 'items')
            ->create(['user_id' => $userId]);

        $response = $this->withSession(['user_id' => $userId])
            ->get(route('checkout.index'))
            ->assertOk();

        foreach ($cart->items as $item) {
            $response
                ->assertSee($item->product->name)
                ->assertSee($item->product->getFormattedTotalAmount($item->quantity));
        }
    }

    public function test_checkout_requires_the_required_contact_and_address_fields(): void
    {
        $this->post(route('checkout.store'))->assertInvalid([
            'full_name',
            'phone_number',
            'email',
            'shipping_address',
        ]);
    }

    public function test_checkout_creates_an_order_and_redirects_to_signed_completion_page(): void
    {
        $userId = 'DUMMY_USER_ID';
        $cart = Cart::factory()
            ->has(CartItem::factory()->count(3), 'items')
            ->create(['user_id' => $userId]);
        $body = [
            'full_name' => 'John',
            'phone_number' => '+84111122222',
            'email' => 'john@example.com',
            'shipping_address' => 'lorem ipsum',
        ];

        $response = $this->withSession(['user_id' => $userId])
            ->post(route('checkout.store'), $body);

        $order = Order::query()->where('cart_id', $cart->id)->firstOrFail();

        $this->assertDatabaseHas('orders', ['id' => $order->id, ...$body]);
        $response->assertRedirectToSignedRoute('orders.complete', ['order' => $order->id]);
    }

    public function test_checkout_rejects_an_empty_cart(): void
    {
        $this->withSession(['user_id' => 'EMPTY_CART_USER'])
            ->post(route('checkout.store'), [
                'full_name' => 'John',
                'phone_number' => '+84111122222',
                'email' => 'john@example.com',
                'shipping_address' => 'lorem ipsum',
            ])
            ->assertSessionHasErrors('cart');
    }
}
