@extends('layouts.public')

@section('title', 'Cara Pesan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-4">Cara Pesan di Yestosa Bakery</h1>
    <p class="text-zinc-600 mb-10">
        Ikuti langkah berikut untuk memesan roti, jajanan pasar, atau snack box.
    </p>

    <div class="space-y-8">

        {{-- STEP 1 --}}
        <div class="flex gap-4">
            <div class="text-xl font-bold text-green-600">1</div>
            <div>
                <h2 class="font-semibold text-lg">Pilih Produk</h2>
                <p class="text-zinc-600">
                    Buka katalog produk, lalu pilih produk yang ingin dipesan.
                </p>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-2 text-sm font-semibold text-green-600 underline">
                    Lihat Katalog Produk
                </a>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div class="flex gap-4">
            <div class="text-xl font-bold text-green-600">2</div>
            <div>
                <h2 class="font-semibold text-lg">Isi Form Pesanan</h2>
                <p class="text-zinc-600">
                    Tentukan jumlah, tanggal ambil/kirim, dan alamat pengantaran.
                </p>
            </div>
        </div>

        {{-- STEP 3 --}}
        <div class="flex gap-4">
            <div class="text-xl font-bold text-green-600">3</div>
            <div>
                <h2 class="font-semibold text-lg">Kirim ke WhatsApp</h2>
                <p class="text-zinc-600">
                    Klik tombol <strong>“Pesan via WhatsApp”</strong>,
                    pesan akan otomatis terkirim ke admin.
                </p>
            </div>
        </div>

        
        
        {{-- CATATAN --}}
        <div class="bg-zinc-50 border rounded-xl p-5">
            <h3 class="font-semibold mb-2">Catatan Penting</h3>
            <ul class="list-disc list-inside text-zinc-600 space-y-1 text-sm">
                <li>Pre-order minimal H-1 / H-2 (tergantung produk)</li>
                <li>Area layanan: Cepu – Padangan & sekitarnya</li>
                <li>Jam operasional: 08.00 – 20.00</li>
            </ul>
        </div>
        
    </div>
</div>
@endsection
