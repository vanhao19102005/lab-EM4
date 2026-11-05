<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_product_can_retrieve_its_category(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Category::class, $product->category);
    }

    public function test_product_has_a_formatted_price_attribute(): void
    {
        $product = Product::factory()->create();
        $expected = number_format((float) $product->price).' '.$product->currency;

        $this->assertSame($expected, $product->formatted_price);
    }

    public function test_product_formats_total_amount_for_a_quantity(): void
    {
        $quantity = 5;
        $product = Product::factory()->create();
        $expected = number_format((float) $product->price * $quantity).' '.$product->currency;

        $this->assertSame($expected, $product->getFormattedTotalAmount($quantity));
    }
}
