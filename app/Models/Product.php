<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_per_pcs',
        'price_per_box',
        'min_preorder_days',
        'min_order',
        'is_available'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->orderByDesc('is_primary')->orderBy('sort_order');
    }

    public function getPriceLabelAttribute()
    {
        $parts = [];

        if (!is_null($this->price_per_pcs) && $this->price_per_pcs > 0) {
            $parts[] = 'Pcs: Rp' . number_format($this->price_per_pcs, 0, ',', '.');
        }

        if (!is_null($this->price_per_box) && $this->price_per_box > 0) {
            $parts[] = 'Box: Rp' . number_format($this->price_per_box, 0, ',', '.');
        }

        // kalau dua-duanya kosong, jangan tampil "Rp0"
        return count($parts) ? implode(' • ', $parts) : 'Harga: chat admin';
    }

    public function primaryImageUrl(): ?string
    {
        $img = $this->images()->where('is_primary', true)->latest()->first()
            ?? $this->images()->latest()->first();

        return $img ? asset('storage/' . $img->image_path) : null;
    }
}
