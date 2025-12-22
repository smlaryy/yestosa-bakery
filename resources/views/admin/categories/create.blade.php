@extends('layouts.admin')
@section('title', 'Tambah Kategori')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Kategori</h1>

<div class="bg-white rounded-xl border border-zinc-200 p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input name="name" value="{{ old('name') }}"
                   class="w-full rounded-lg border border-zinc-300 p-2 focus:outline-none focus:ring-2 focus:ring-zinc-300"
                   placeholder="Contoh: Roti"
                   required>
            @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" checked>
            <span>Aktif</span>
        </label>

        <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 rounded-lg bg-zinc-900 text-white hover:bg-zinc-800">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-lg border border-zinc-300 hover:bg-zinc-100">Batal</a>
        </div>
    </form>
</div>
@endsection
