<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $with = array_intersect(explode(',', (string) request('with', '')), ['category']);
        $query = Product::query()
            ->when($with !== [], fn (Builder $query) => $query->with($with))
            ->when(request('search'), function (Builder $query, string $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            });

        return $query->simplePaginate();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'display_image_url' => ['required', 'url', 'max:2048'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        return Product::create($validated);
    }

    public function show(Product $product)
    {
        $with = array_intersect(explode(',', (string) request('with', '')), ['category']);
        $product->loadMissing($with);
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'currency' => ['sometimes', 'required', 'string', 'max:10'],
            'display_image_url' => ['sometimes', 'required', 'url', 'max:2048'],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
        ]);

        $product->update($validated);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
