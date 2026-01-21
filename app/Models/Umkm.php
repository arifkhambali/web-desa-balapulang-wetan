<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umkm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_produk',
        'slug',
        'kategori_umkm_id',
        'deskripsi',
        'harga',
        'gambar',
        'nama_penjual',
        'kontak',
        'status',
        'stok',
        'aktif',
        'featured',
        'views',
    ];
    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($umkm) {
            if (empty($umkm->slug)) {
                $umkm->slug = Str::slug($umkm->nama_produk);
            }
        });

        static::updating(function ($umkm) {
            if ($umkm->isDirty('nama_produk')) {
                $umkm->slug = Str::slug($umkm->nama_produk);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_featured_products');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_featured_products');
        });
    }

    // Relationships
    public function kategoriUmkm()
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_umkm_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->whereFullText(['nama_produk', 'deskripsi'], $search);
        });
    }

    // Scope untuk filter kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->when($kategori, function ($q) use ($kategori) {
            return $q->where('kategori', $kategori);
        });
    }

    // Scope untuk filter harga
    public function scopeByPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        return $query->when($minPrice, function ($q) use ($minPrice) {
            return $q->where('harga', '>=', $minPrice);
        })->when($maxPrice, function ($q) use ($maxPrice) {
            return $q->where('harga', '<=', $maxPrice);
        });
    }

    // Scope untuk sorting
    public function scopeSortBy($query, $sort = 'newest')
    {
        switch($sort) {
            case 'oldest':
                return $query->oldest();
            case 'price_low':
                return $query->orderBy('harga', 'asc');
            case 'price_high':
                return $query->orderBy('harga', 'desc');
            case 'most_viewed':
                return $query->orderBy('views', 'desc');
            case 'name_asc':
                return $query->orderBy('nama_produk', 'asc');
            case 'name_desc':
                return $query->orderBy('nama_produk', 'desc');
            default:
                return $query->latest(); // newest
        }
    }

    // Method untuk increment views count
    public function incrementViews()
    {
        $this->increment('views');
        return $this;
    }
}
