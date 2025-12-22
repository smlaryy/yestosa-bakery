@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
<div class="flex items-start justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold">Kategori</h1>
        <p class="text-sm text-zinc-600">Kelola kategori produk (Roti, Jajanan Pasar, Snack Box, dll).</p>
    </div>

    <a href="{{ route('admin.categories.create') }}"
       class="shrink-0 px-4 py-2 rounded-lg bg-zinc-900 text-white hover:bg-zinc-800">
        + Tambah
    </a>
</div>

{{-- DESKTOP TABLE (md+) --}}
<div class="hidden md:block overflow-hidden rounded-2xl border bg-white">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-700">
            <tr>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Slug</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-zinc-100">
            @forelse($categories as $cat)
                <tr class="hover:bg-zinc-50 align-middle">
                    <td class="p-4 font-medium">{{ $cat->name }}</td>
                    <td class="p-4 text-zinc-600">{{ $cat->slug }}</td>
                    <td class="p-4">
                        @if($cat->is_active)
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-zinc-200 text-zinc-800">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}"
                               class="px-3 py-1.5 rounded border border-zinc-300 hover:bg-zinc-100">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 rounded border border-red-300 text-red-700 hover:bg-red-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-4 text-zinc-600" colspan="4">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MOBILE CARDS (default) --}}
<div class="md:hidden space-y-3">
    @forelse($categories as $cat)
        <div class="rounded-2xl border bg-white p-4">
            {{-- Header: name + badge --}}
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="font-semibold truncate">{{ $cat->name }}</div>
                    <div class="text-xs text-zinc-500 mt-0.5 truncate">{{ $cat->slug }}</div>
                </div>

                @if($cat->is_active)
                    <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-green-100 text-green-800">
                        Aktif
                    </span>
                @else
                    <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-zinc-200 text-zinc-800">
                        Nonaktif
                    </span>
                @endif
            </div>

            {{-- Actions: 2 columns --}}
            <div class="mt-4 grid grid-cols-2 gap-2">
                <a href="{{ route('admin.categories.edit', $cat) }}"
                   class="text-center px-3 py-2 rounded-lg border hover:bg-zinc-50 text-sm">
                    Edit
                </a>

                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                      onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full px-3 py-2 rounded-lg border border-red-300 text-red-700 hover:bg-red-50 text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="rounded-2xl border bg-white p-4 text-sm text-zinc-600">
            Belum ada kategori.
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
