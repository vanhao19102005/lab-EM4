<?php
namespace Database\Seeders;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::query()->get();
        if ($products->isEmpty()) return;

        foreach (range(1, 5) as $index) {
            $cart = Cart::factory()->create(['user_id' => (string) Str::uuid()]);
            foreach ($products->random(min(random_int(1, 3), $products->count())) as $product) {
                $cart->items()->create(['product_id' => $product->id, 'quantity' => random_int(1, 4)]);
            }
            Order::factory()->create(['cart_id' => $cart->id]);
        }
    }
}
