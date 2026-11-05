<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private const CAFE_COUNT = 6;
    private const CHICKEN_COUNT = 6;

    public function run(): void
    {
        $products = [];
        for ($id = 1; $id <= self::CAFE_COUNT; $id++) {
            $products[] = ['id' => $id, 'category_id' => 1, 'name' => 'Cappuchino', 'description' => 'Cappuccino is a coffee drink that today is typically composed of a single espresso shot and hot milk', 'price' => 35000, 'display_image_url' => Product::DEFAULT_IMAGE];
        }
        for ($id = 7; $id <= self::CAFE_COUNT + self::CHICKEN_COUNT; $id++) {
            $products[] = ['id' => $id, 'category_id' => 2, 'name' => 'Chicken satay salad', 'description' => 'Marinate chicken breasts, then drizzle with a punchy peanut satay sauce', 'price' => 50000, 'display_image_url' => Product::DEFAULT_IMAGE];
        }
        foreach ($products as $product) {
            Product::updateOrCreate(['id' => $product['id']], $product + ['currency' => Product::DEFAULT_CURRENCY]);
        }
    }
}
