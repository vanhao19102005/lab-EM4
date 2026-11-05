<?php

namespace Tests\Unit\Notifications;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderCreatedNotificationTest extends TestCase
{
    public function test_checkout_sends_the_order_created_notification(): void
    {
        Notification::fake();

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

        $this->withSession(['user_id' => $userId])
            ->post(route('checkout.store'), $body)
            ->assertRedirect();

        $order = Order::query()->where('cart_id', $cart->id)->firstOrFail();

        Notification::assertSentOnDemand(
            OrderCreatedNotification::class,
            fn (OrderCreatedNotification $notification, array $channels, object $notifiable): bool =>
                array_key_first($notifiable->routes['mail']) === $order->email
        );
    }
}
