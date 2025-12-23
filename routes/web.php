<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Public\ProductCatalogController;
use App\Models\Product;


Route::get('/', [ProductCatalogController::class, 'home'])->name('home');

Route::get('/produk', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductCatalogController::class, 'show'])->name('products.show');
Route::view('/cara-pesan', 'howto')->name('howto');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/sitemap.xml', function () {
    $products = Product::query()
        ->where('is_available', true)
        ->get(['slug', 'updated_at']);

    return response()
        ->view('sitemap', compact('products'))
        ->header('Content-Type', 'application/xml');
});

require __DIR__ . '/auth.php';