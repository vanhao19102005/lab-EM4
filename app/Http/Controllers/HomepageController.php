<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\View\View;
class HomepageController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->with('products')->orderBy('name')->get();
        return view('homepage', compact('categories'));
    }
}
