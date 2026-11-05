<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use RuntimeException;

class OrderSeeder extends Seeder
{
    private $target_products;

    public function __construct()
    {
        $this->target_products = Product::query()->get();
    }

    private function getDummyUsers(int $count): array
    {
        $users = [];

        for ($i = 1; $i <= $count; $i++) {
            $users[] = [
                'full_name' => fake()->name(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ];
        }

        return $users;
    }

    private function getRamdomTargetProducts(int $total): array
    {
        return $this->target_products->random($total)
            ->map(fn ($product) => ['product_id' => $product->id])
            ->toArray();
    }

    private function createDummyOrder(array $user): Order
    {
        $num_items = random_int(1, min(5, $this->target_products->count()));
        $order_date = Carbon::today()->subDays(random_int(0, 90));

        return Order::factory()
            ->state([
                'created_at' => $order_date,
                'cart_id' => Cart::factory()->has(
                    CartItem::factory()
                        ->count($num_items)
                        ->state(new Sequence(...$this->getRamdomTargetProducts($num_items))),
                    'items'
                ),
                ...$user,
            ])
            ->create();
    }

    public function run(): void
    {
        if ($this->target_products->isEmpty()) {
            throw new RuntimeException('Seed products before running OrderSeeder.');
        }

        foreach ($this->getDummyUsers(50) as $user) {
            for ($i = 0, $order_count = random_int(1, 20); $i < $order_count; $i++) {
                $this->createDummyOrder($user);
            }
        }
    }
}
