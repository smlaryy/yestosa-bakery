@extends('layouts.admin')
@section('title', 'Produk')

@section('content')
<div class="flex items-start justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold">Produk</h1>
        <p class="text-sm text-zinc-600">Kelola daftar produk, harga, PO, dan minimal order.</p>
    </div>

    <a href="{{ route('admin.products.create') }}"
        class="shrink-0 px-4 py-2 bg-zinc-900 text-white rounded-lg hover:bg-zinc-800">
        + Tambah Produk
    </a>
</div>

{{-- DESKTOP TABLE (md+) --}}
<div class="hidden md:block overflow-hidden rounded-2xl border bg-white">
    <table class="w-full text-sm">
        <thead class="bg-zinc-50 text-zinc-600">
            <tr>
                <th class="p-4 text-left">Produk</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Harga</th>
                <th class="p-4 text-center">PO</th>
                <th class="p-4 text-left">Min Order</th>
                <th class="p-4 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-zinc-100">
            @forelse($products as $p)
            <tr class="hover:bg-zinc-50 align-middle">
                <td class="p-4 font-medium">{{ $p->name }}</td>
                <td class="p-4 text-zinc-700">{{ $p->category?->name ?? '-' }}</td>
                <td class="p-4 text-zinc-700">{{ $p->price_label }}</td>
                <td class="p-4 text-center">
                    @if($p->min_preorder_days)
                    H-{{ $p->min_preorder_days }}
                    @else
                    -
                    @endif
                </td>
                <td class="p-4">
                    @if($p->min_order)
                    {{ $p->min_order }} pcs
                    @else
                    -
                    @endif
                </td>
                <td class="p-4">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $p) }}"
                            class="px-3 py-1.5 rounded border border-zinc-300 hover:bg-zinc-100">
                            Edit
                        </a>

                        <form method="POST"
                            action="{{ route('admin.products.destroy', $p) }}"
                            class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1.5 rounded border border-red-300 text-red-700 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="p-4 text-zinc-600" colspan="6">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MOBILE CARDS (default) --}}
<div class="md:hidden space-y-3">
    @forelse($products as $p)
    <div class="rounded-2xl border bg-white p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <div class="font-semibold truncate">{{ $p->name }}</div>
                <div class="text-xs text-zinc-500 mt-0.5 truncate">
                    {{ $p->category?->name ?? '-' }}
                </div>
            </div>

            <div class="text-right text-xs text-zinc-600 shrink-0">
                <div>
                    PO:
                    <span class="font-medium">
                        {{ $p->min_preorder_days ? 'H-'.$p->min_preorder_days : '-' }}
                    </span>
                </div>
                <div class="mt-0.5">
                    Min:
                    <span class="font-medium">
                        {{ $p->min_order ? $p->min_order.' pcs' : '-' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-3 text-sm font-semibold text-zinc-900">
            {{ $p->price_label }}
        </div>

        <div class="mt-3 flex gap-2">
            <a href="{{ route('admin.products.edit', $p) }}"
                class="flex-1 text-center px-3 py-2 rounded-lg border hover:bg-zinc-50">
                Edit
            </a>

            <form method="POST"
                action="{{ route('admin.products.destroy', $p) }}"
                class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-3 py-1.5 rounded border border-red-300 text-red-700 hover:bg-red-50">
                    Hapus
                </button>
            </form>

        </div>
    </div>
    @empty
    <div class="rounded-2xl border bg-white p-4 text-sm text-zinc-600">
        Belum ada produk.
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection