@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-2">Dashboard</h1>
    <p class="text-zinc-600 mb-6">Selamat datang di panel admin Yestosa Bakery.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl border border-zinc-200 p-5">
            <div class="text-sm text-zinc-500">Total Kategori</div>
            <div class="text-3xl font-bold">{{ \App\Models\Category::count() }}</div>
        </div>

        <div class="bg-white rounded-xl border border-zinc-200 p-5">
            <div class="text-sm text-zinc-500">Total Produk</div>
            <div class="text-3xl font-bold">{{ \App\Models\Product::count() }}</div>
        </div>
    </div>
@endsection
