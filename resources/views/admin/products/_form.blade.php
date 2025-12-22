@php
$isEdit = isset($product);
@endphp

<div class="bg-white rounded-xl border border-zinc-200 p-6 space-y-5 max-w-2xl">
    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="category_id" class="w-full rounded-lg border border-zinc-300 p-2" required>
            <option value="">-- Pilih kategori --</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
        @error('category_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Nama Produk</label>
        <input name="name" value="{{ old('name', $product->name ?? '') }}"
            class="w-full rounded-lg border border-zinc-300 p-2"
            placeholder="Contoh: Roti Sobek Coklat" required>
        @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="4"
            class="w-full rounded-lg border border-zinc-300 p-2"
            placeholder="Isi: bahan, ukuran, minimal order, dll">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Harga per Pcs (Rp)</label>
            <input type="number" min="0" name="price_per_pcs"
                value="{{ old('price_per_pcs', $product->price_per_pcs ?? '') }}"
                class="w-full rounded-lg border border-zinc-300 p-2"
                placeholder="contoh: 3000">
            @error('price_per_pcs') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Harga per Box (Rp)</label>
            <input type="number" min="0" name="price_per_box"
                value="{{ old('price_per_box', $product->price_per_box ?? '') }}"
                class="w-full rounded-lg border border-zinc-300 p-2"
                placeholder="contoh: 25000">
            @error('price_per_box') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Minimal Pre-order</label>
            <select name="min_preorder_days" class="w-full rounded-lg border border-zinc-300 p-2" required>
                <option value="1" @selected(old('min_preorder_days', $product->min_preorder_days ?? 1) == 1)>H-1</option>
                <option value="2" @selected(old('min_preorder_days', $product->min_preorder_days ?? 1) == 2)>H-2</option>
            </select>
            @error('min_preorder_days') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" name="is_available" value="1"
                @checked(old('is_available', $product->is_available ?? true))>
            <span class="text-sm">Tersedia (buka PO)</span>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Minimal Order</label>
        <input
            type="number"
            min="1"
            name="min_order"
            value="{{ old('min_order', $product->min_order ?? '') }}"
            class="w-full rounded-lg border p-2"
            placeholder="contoh: 10">
        <p class="text-xs text-zinc-500 mt-1">Kosongkan jika tidak ada minimal.</p>
    </div>



    <div>
        <label class="block text-sm font-medium mb-1">
            Foto Produk {{ $isEdit ? '(opsional)' : '(wajib)' }}
        </label>
        <input type="file" name="image" accept="image/*"
            class="w-full rounded-lg border border-zinc-300 p-2" {{ $isEdit ? '' : 'required' }}>
        @error('image') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror

        @if($isEdit)
        @php $primary = $product->images()->where('is_primary', true)->latest()->first(); @endphp
        @if($primary)
        <div class="mt-3">
            <div class="text-xs text-zinc-600 mb-1">Foto utama saat ini:</div>
            <img src="{{ asset('storage/'.$primary->image_path) }}"
                class="w-40 h-28 object-cover rounded-lg border">
        </div>
        @endif
        @endif
    </div>
</div>