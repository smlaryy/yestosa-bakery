@extends('layouts.public')
@section('title', $product->name.' - '.config('business.name'))
@section('meta_description', Str::limit(strip_tags($product->description ?? ''), 150, ''))

@section('content')
@php
$waNumber = config('business.wa');
$businessName = config('business.name');
$businessArea = config('business.area');
$businessAddress = config('business.address');
@endphp
@php
$imgs = $product->images ?? collect();
$imgUrls = $imgs->map(fn($img) => asset('storage/' . $img->image_path))->values();
@endphp


<div class="grid grid-cols-1 lg:grid-cols-2 gap-8"
    x-data="orderWa({
    wa: @js($waNumber),
    shop: @js($businessName),
    defaultArea: @js($businessArea),
    name: @js($product->name),
    minDays: {{ $product->min_preorder_days }},
    minOrder: {{ $product->min_order ?? 'null' }},
    pcsPrice: {{ $product->price_per_pcs ?? 'null' }},
    boxPrice: {{ $product->price_per_box ?? 'null' }},
})"

    x-init="init()">
    @php
    $imgs = $product->images ?? collect();
    $imgUrls = $imgs->map(fn($img) => asset('storage/' . $img->image_path))->values();
    @endphp

    <div
        x-data="carousel({ images: @js($imgUrls), start: 0 })"
        class="bg-white border rounded-2xl p-4">
        {{-- Main Image --}}
        <div class="aspect-square rounded-xl overflow-hidden bg-zinc-100 relative">
            <template x-if="images.length">
                <img :src="images[active]" class="w-full h-full object-cover" alt="Foto produk">
            </template>

            <template x-if="!images.length">
                <div class="w-full h-full flex items-center justify-center text-sm text-zinc-400">
                    Belum ada foto
                </div>
            </template>
        </div>

        {{-- Thumbnails --}}
        <div x-show="images.length > 1" class="mt-4 grid grid-cols-5 gap-2">
            <template x-for="(img, i) in images" :key="i">
                <button
                    type="button"
                    @click="go(i)"
                    class="aspect-square rounded-lg overflow-hidden border bg-zinc-100"
                    :class="active === i ? 'ring-2 ring-zinc-900' : 'opacity-80 hover:opacity-100'"
                    aria-label="Pilih foto">
                    <img :src="img" class="w-full h-full object-cover" alt="">
                </button>
            </template>
        </div>
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-zinc-700 mb-2">
                Deskripsi Produk
            </h3>

            <!-- Badge -->
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="px-3 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">
                    Homemade
                </span>
                <span class="px-3 py-1 rounded-full text-xs bg-amber-100 text-amber-700">
                    Fresh Order
                </span>
                <span class="px-3 py-1 rounded-full text-xs bg-sky-100 text-sky-700">
                    Tanpa Pengawet
                </span>
            </div>

            <!-- Deskripsi -->
            <p class="text-sm text-zinc-600 leading-relaxed">
                {{ $product->description ?? 'Produk dibuat fresh setiap hari dengan bahan pilihan. Cocok untuk acara keluarga, rapat, maupun kebutuhan harian.' }}
            </p>
        </div>

    </div>

    <div>
        <div class="text-sm text-zinc-500 mb-1">{{ $product->category->name }}</div>
        <h1 class="text-3xl font-bold mb-3">{{ $product->name }}</h1>

        <div class="text-zinc-700 mb-4">
            @if($product->description)
            <p class="whitespace-pre-line">{{ $product->description }}</p>
            @else
            <p>Pre-order area Cepu – Padangan. Detail bisa ditanyakan via WhatsApp.</p>
            @endif
        </div>

        <div class="bg-white rounded-xl border p-5 space-y-4">
            <div class="text-sm text-zinc-600">
                Minimal pre-order: <span class="font-semibold">H-{{ $product->min_preorder_days }}</span>
            </div>

            @if($product->min_order)
            <div class="text-sm text-zinc-600">
                Minimal order: <span class="font-semibold">{{ $product->min_order }}</span>
                <span class="text-zinc-500" x-text="type === 'pcs' ? 'pcs' : 'box'"></span>
            </div>
            @endif



            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih tipe</label>
                    <select x-model="type" class="w-full rounded-lg border p-2">
                        <option value="pcs" :disabled="pcsPrice === null">Pcs</option>
                        <option value="box" :disabled="boxPrice === null">Box</option>
                    </select>
                    <div class="text-xs text-zinc-500 mt-1" x-show="type==='pcs' && pcsPrice !== null">
                        Harga pcs: Rp<span x-text="fmt(pcsPrice)"></span>
                    </div>
                    <div class="text-xs text-zinc-500 mt-1" x-show="type==='box' && boxPrice !== null">
                        Harga box: Rp<span x-text="fmt(boxPrice)"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                    <input type="number"
                        :min="minOrder"
                        x-model.number="qty"
                        class="w-full rounded-lg border p-2">

                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal ambil/kirim</label>
                <input type="date" x-model="date" :min="minDate" class="w-full rounded-lg border p-2">
                <div class="text-xs text-zinc-500 mt-1">
                    Minimal tanggal: <span x-text="minDate"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Area</label>
                    <select x-model="area" class="w-full rounded-lg border p-2">
                        <option value="Cepu">Cepu</option>
                        <option value="Padangan">Padangan</option>
                        <option value="Bojonegoro">Bojonegoro</option>
                        <option value="Sekitar perbatasan Jateng/Jatim">Sekitar perbatasan Jateng/Jatim</option>
                    </select>

                </div>


                <div>
                    <label class="block text-sm font-medium mb-1">Alamat Lengkap</label>
                    <textarea
                        x-model="address"
                        @input="errorMsg=''"
                        rows="3"
                        class="w-full rounded-lg border p-2"
                        placeholder="Contoh: Jl. Raya Cepu No.12, dekat Pasar Cepu, RT 02 RW 01"
                        required></textarea>
                    <div class="text-xs text-zinc-500 mt-1">
                        Digunakan untuk antar / titik temu.
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
                    <input type="text" x-model="note" class="w-full rounded-lg border p-2" placeholder="contoh: untuk acara rapat">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm text-zinc-700" x-show="unitPrice() !== null">
                    Estimasi: <span class="font-semibold">Rp<span x-text="fmt(total())"></span></span>
                </div>

                <button type="button"
                    @click="openWa()"
                    :disabled="!isValid()"
                    class="px-4 py-2 rounded-lg text-white
                  disabled:bg-green-300 bg-green-600 hover:bg-green-700 rounded-lg">
                    Pesan via WhatsApp
                </button>
                <div class="text-xs text-red-600" x-show="errorMsg" x-text="errorMsg"></div>
            </div>

            <div class="text-xs text-zinc-500">
                Jam operasional & batas PO bisa kamu atur nanti di halaman “Cara Pesan”.
            </div>
        </div>
    </div>
</div>

<script>
    function orderWa({
        wa,
        shop,
        defaultArea,
        address,
        name,
        minDays,
        minOrder,
        pcsPrice,
        boxPrice
    }) {
        return {
            wa,
            shop,
            defaultArea,
            name,
            minDays,
            minOrder,
            pcsPrice,
            boxPrice,
            type: (pcsPrice !== null ? 'pcs' : 'box'),
            qty: 1,
            date: '',
            area: defaultArea || 'Cepu',
            address: '',
            note: '',
            minDate: '',
            errorMsg: '',

            init() {
                const d = new Date();
                d.setDate(d.getDate() + this.minDays);
                this.minDate = this.toISO(d);
                this.date = this.minDate;

                if (this.minOrder) {
                    this.qty = this.minOrder;
                }
            },

            toISO(d) {
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            },

            unitPrice() {
                if (this.type === 'pcs') return this.pcsPrice;
                if (this.type === 'box') return this.boxPrice;
                return null;
            },

            total() {
                const p = this.unitPrice();
                if (p === null) return 0;
                return p * (this.qty || 1);
            },

            fmt(n) {
                try {
                    return Number(n).toLocaleString('id-ID');
                } catch (e) {
                    return n;
                }
            },

            isValid() {
                if (!this.date) return false;
                if (!this.qty || this.qty < this.minOrder) return false;
                if (!this.address || this.address.trim().length < 5) return false;
                return true;
            },

            validateAndExplain() {
                if (!this.date) return 'Isi tanggal ambil/kirim dulu ya 🙂';
                if (!this.qty || this.qty < this.minOrder) return `Minimal order ${this.minOrder} ya 🙂`;
                if (!this.address || this.address.trim().length < 5) return 'Isi alamat minimal 5 karakter ya 🙂';
                return '';
            },


            message() {
                const tipe = this.type === 'pcs' ? 'Pcs' : 'Box';
                const harga = this.unitPrice();
                const hargaTxt = harga !== null ? `Rp${this.fmt(harga)}` : '-';
                const totalTxt = harga !== null ? `Rp${this.fmt(this.total())}` : '-';

                const lines = [
                    `Halo ${this.shop}, saya mau *pre-order* 😊`,
                    '',
                    `*Produk:* ${this.name}`,
                    `*Tipe:* ${tipe}`,
                    `*Harga:* ${hargaTxt}`,
                    `*Jumlah:* ${this.qty || 1}`,
                    `*Tanggal ambil/kirim:* ${this.date}`,
                    `*Area:* ${this.area}`,
                    `*Alamat lengkap:* ${this.address}`
                ];

                if (this.note) lines.push(`*Catatan:* ${this.note}`);

                lines.push('', `*Estimasi total:* ${totalTxt}`, '', 'Terima kasih 🙏');

                return lines.join('\n');
            },

            openWa() {
                this.errorMsg = '';

                if (!this.wa) {
                    this.errorMsg = 'Nomor WhatsApp belum di-set. Isi BUSINESS_WA di file .env';
                    return;
                }

                const err = this.validateAndExplain();
                if (err) {
                    this.errorMsg = err;
                    return;
                }

                const text = encodeURIComponent(this.message());
                const url = `https://wa.me/${this.wa}?text=${text}`;
                window.open(url, '_blank');
            },

        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('carousel', ({
            images = [],
            start = 0
        }) => ({
            images,
            active: start ?? 0,
            next() {
                if (!this.images.length) return;
                this.active = (this.active + 1) % this.images.length;
            },
            prev() {
                if (!this.images.length) return;
                this.active = (this.active - 1 + this.images.length) % this.images.length;
            },
            go(i) {
                this.active = i;
            },
        }));
    });
</script>

@endsection