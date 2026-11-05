<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class QueryBuilderPlayground extends Command
{
    protected $signature = 'app:query-builder-playground';
    protected $description = 'Display categories and their products';

    public function handle(): int
    {
        $categories = Category::query()->with('products')->get();
        foreach ($categories as $category) {
            dump('Category name: ' . $category->name);
            dump('Total products: ' . $category->products->count());
            foreach ($category->products as $product) {
                dump('--- Product name: ' . $product->name);
            }
            dump('--------------------------------------------');
        }
        return self::SUCCESS;
    }
}
