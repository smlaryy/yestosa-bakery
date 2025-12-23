@extends('layouts.public')
@section('title', 'Katalog')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Katalog Produk</h1>
    <p class="text-zinc-600">Pre-order area Cepu – Padangan – sekitar perbatasan Jateng/Jatim.</p>
</div>

<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('products.index') }}"
        class="px-3 py-1.5 rounded-full border {{ $categorySlug ? 'bg-white' : 'bg-zinc-900 text-white border-zinc-900' }}">
        Semua
    </a>

    @foreach($categories as $cat)
    <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
        class="px-3 py-1.5 rounded-full border {{ $categorySlug === $cat->slug ? 'bg-zinc-900 text-white border-zinc-900' : 'bg-white' }}">
        {{ $cat->name }}
    </a>
    @endforeach
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($products as $p)
    <a
        href="{{ $p->is_available ? route('products.show', $p->slug) : '#' }}"
        @if(!$p->is_available)
        onclick="event.preventDefault(); poClosedAlert();"
        aria-disabled="true"
        @endif
        class="group bg-white rounded-2xl border border-zinc-200 overflow-hidden transition hover:shadow-md
        {{ !$p->is_available ? 'opacity-70 cursor-not-allowed' : '' }}"
        >
        {{-- Foto --}}
        <div class="relative w-full overflow-hidden bg-zinc-100 aspect-square">
            @if($p->primaryImage)
            <img
                src="{{ asset('storage/' . $p->primaryImage->image_path) }}"
                alt="{{ $p->name }}"
                class="block w-full h-full object-cover transition {{ $p->is_available ? 'group-hover:scale-105' : 'grayscale' }}">
            @else
            <div class="w-full h-full flex items-center justify-center text-xs text-zinc-400">
                No Image
            </div>
            @endif

            {{-- Badge overlay --}}
            <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                @if(!$p->is_available)
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-medium bg-zinc-100 text-zinc-700 ring-1 ring-inset ring-zinc-200">
                    PO Tutup
                </span>
                @else
                @if($p->min_preorder_days)
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-medium bg-[#FBF1E1] text-[#6B1F2B] ring-1 ring-inset ring-[#E8D2C9]">
                    PO H-{{ $p->min_preorder_days }}
                </span>
                @endif

                @if($p->min_order)
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-medium bg-white text-[#6B1F2B] ring-1 ring-inset ring-[#E8D2C9]">
                    Min {{ $p->min_order }} pcs
                </span>
                @endif
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="p-4 space-y-1">
            <div class="text-xs text-zinc-500">{{ $p->category->name ?? '-' }}</div>

            <div class="font-semibold leading-tight line-clamp-2 min-h-[40px]">
                {{ $p->name }}
            </div>

            <div class="text-sm font-bold text-zinc-900 min-h-[20px]">
                {{ $p->price_label }}
            </div>
        </div>
    </a>
    @empty
    <div class="text-zinc-600">Belum ada produk.</div>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection