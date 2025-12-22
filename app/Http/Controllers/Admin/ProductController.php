<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price_per_pcs' => ['nullable', 'integer', 'min:0'],
            'price_per_box' => ['nullable', 'integer', 'min:0'],
            'min_preorder_days' => ['required', 'integer', 'in:1,2'],
            'min_order' => 'nullable|integer|min:1',
            'is_available' => ['nullable', 'boolean'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available');

        $product = Product::create($data);

        // simpan gambar utama
        $path = $request->file('image')->store('products', 'public');
        $product->images()->create([
            'image_path' => $path,
            'is_primary' => true,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price_per_pcs' => ['nullable', 'integer', 'min:0'],
            'price_per_box' => ['nullable', 'integer', 'min:0'],
            'min_preorder_days' => ['required', 'integer', 'in:1,2'],
            'min_order' => 'nullable|integer|min:1',
            'is_available' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available');

        $product->update($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
