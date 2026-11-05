<?php
namespace Database\Factories;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array { return ['cart_id' => Cart::factory(), 'code' => fake()->unique()->numerify('OR-#########'), 'full_name' => fake()->name(), 'phone_number' => fake()->phoneNumber(), 'email' => fake()->safeEmail(), 'shipping_address' => fake()->streetAddress().', '.fake()->city(), 'coupon_code' => null, 'notes' => fake()->optional()->sentence()]; }
}
