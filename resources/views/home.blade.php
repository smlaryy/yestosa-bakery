@extends('layouts.public')
@section('title', config('business.name', 'Yestosa Bakery'))

@section('content')
@php
$shop = config('business.name');
$area = config('business.area');
$hours = config('business.hours'); // kalau belum ada, nanti aku kasih fallback
$wa = preg_replace('/\D+/', '', (string) config('business.wa'));
$waLink = $wa
? "https://wa.me/{$wa}?text=" . urlencode("Halo {$shop}, saya mau pesan 😊")
: '#';
@endphp

<div class="max-w-6xl mx-auto px-4">

    {{-- HERO (awal banget) --}}
    <section class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl font-bold leading-tight">
                Pre-order Snack<br>
                <span class="text-zinc-600">area {{ $area }}</span>
            </h1>

            <p class="text-zinc-700 mt-4">
                {{ $shop }} menerima pesanan snack atau snack box.
                Cocok untuk acara keluarga, rapat kantor, atau kebutuhan harian.
            </p>

            <div class="flex gap-3 mt-6 flex-wrap">
                <a href="{{ route('products.index') }}"
                    class="px-5 py-3 rounded-xl bg-[#5A1F2A] text-white hover:bg-[#E48A9A]">
                    Lihat Produk
                </a>

                <a href="{{ $waLink }}" target="_blank"
                    class="px-5 py-3 rounded-xl bg-emerald-500 text-white hover:bg-emerald-600">
                    Pesan Sekarang
                </a>

                <a href="{{ route('howto') }}"
                    class="px-5 py-3 rounded-xl border hover:bg-white">
                    Cara Pesan
                </a>
            </div>

            <div class="text-sm text-zinc-500 mt-4">
                @if($hours)
                Jam operasional: <span class="font-medium text-zinc-700">{{ $hours }}</span>
                @else
                Jam operasional: <span class="font-medium text-zinc-700">08:00 - 20:00</span>
                @endif
            </div>
        </div>

        <div class="bg-white border rounded-2xl p-6">
            <div class="font-semibold mb-2">Kenapa pesan di sini?</div>
            <ul class="text-sm text-zinc-700 space-y-2 list-disc pl-5">
                <li>Format order otomatis ke WhatsApp</li>
                <li>Pre-order jelas (H-1 / H-2)</li>
                <li>Harga transparan (pcs/box)</li>
                <li>Bisa Antar area Cepu–Padangan dan sekitarnya</li>
            </ul>

            <div class="mt-5 border-t pt-5 text-sm text-zinc-600">
                Tips: Kalau mau custom order atau tanya-tanya dulu, bisa langsung chat WA ya! dengan cara klik tombol <strong>Pesan Sekarang</strong>.
            </div>
        </div>
    </section>

    {{-- PRODUK TERBARU --}}
    @if(isset($latestProducts) && $latestProducts->count())
    <section class="mt-14">
        <div class="flex items-end justify-between gap-4">
            <h2 class="text-2xl font-bold">Best Seller</h2>

            <a href="{{ route('products.index') }}"
                class="text-sm font-semibold text-zinc-700 hover:text-zinc-900 underline">
                Lihat semua
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
            @foreach($latestProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}"
                class="group bg-white border rounded-2xl overflow-hidden hover:shadow-md transition">

                {{-- Foto --}}
                <div class="aspect-square bg-zinc-100">
                    @if($product->primaryImage)
                    <img
                        src="{{ asset('storage/'.$product->primaryImage->image_path) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-zinc-400">
                        No Image
                    </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-3 space-y-1">
                    <div class="font-semibold text-sm leading-tight line-clamp-2">
                        {{ $product->name }}
                    </div>

                    <div class="text-sm font-bold text-zinc-900">
                        {{ $product->price_label }}
                    </div>

                    <div class="mt-2 flex flex-col gap-1.5">
                        @if($product->min_preorder_days)
                        <span class="inline-flex items-center self-start rounded-full
                        px-3 py-1.5 text-xs font-medium
                      bg-[#FBF1E1] text-[#6B1F2B]
                        ring-1 ring-inset ring-[#E8D2C9] hover:bg-[#F6E8DB] transition">
                            PO H-{{ $product->min_preorder_days }}
                        </span>
                        @endif

                        @if($product->min_order)
                        <span class="inline-flex items-center self-start rounded-full
                        px-3 py-1.5 text-xs font-medium
                      bg-white text-[#6B1F2B]
                        ring-1 ring-inset ring-[#E8D2C9] hover:bg-[#F6E8DB] transition">
                            Min {{ $product->min_order }} pcs
                        </span>
                        @endif
                    </div>

                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection