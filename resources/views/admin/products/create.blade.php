@extends('layouts.admin')
@section('title', 'Tambah Produk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Tambah Produk</h1>
    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg border hover:bg-zinc-100">Kembali</a>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @include('admin.products._form', ['categories' => $categories])
    <div class="max-w-2xl flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-zinc-900 text-white hover:bg-zinc-800">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg border hover:bg-zinc-100">Batal</a>
    </div>
</form>
@endsection
