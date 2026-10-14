<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->where('status', 'active')
            ->with(['images', 'variants', 'category'])
            ->latest()
            ->take(16)
            ->get();

        $deals = $products->take(7);
        $featured = $products->skip(3)->take(5);

        return view('storefront.home', compact('categories', 'products', 'deals', 'featured'));
    }
}
