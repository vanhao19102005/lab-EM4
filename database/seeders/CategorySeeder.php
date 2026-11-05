<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public array $categories = [
        ['id' => 1, 'name' => 'Cafe', 'description' => ''],
        ['id' => 2, 'name' => 'Chicken', 'description' => ''],
    ];

    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::updateOrCreate(['id' => $category['id']], $category);
        }
    }
}
