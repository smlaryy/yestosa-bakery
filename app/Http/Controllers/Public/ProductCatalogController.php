<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function home()
    {
        $latestProducts = Product::with(['category', 'primaryImage'])
            ->orderByDesc('is_available')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('latestProducts'));
    }

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $products = Product::with(['category', 'primaryImage'])
            ->orderByDesc('is_available')
            ->when($categorySlug, function ($q) use ($categorySlug) {
                $q->whereHas('category', fn($cq) => $cq->where('slug', $categorySlug));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories', 'categorySlug'));
    }

    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'images' => fn($q) => $q->orderByDesc('is_primary')->orderBy('sort_order'),
        ])
            ->where('slug', $slug)
            ->where('is_available', true)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
