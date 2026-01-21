<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'kategori_berita_id',
        'konten',
        'gambar',
        'penulis',
        'views',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    // Auto-generate slug dari judul
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_latest_news');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_latest_news');
        });
    }

    // Relationships
    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }

    // Scope untuk berita yang sudah published
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->whereFullText(['judul', 'konten'], $search);
        });
    }

    // Scope untuk filter kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->when($kategori, function ($q) use ($kategori) {
            return $q->where('kategori', $kategori);
        });
    }

    // Scope untuk filter tanggal
    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        return $query->when($startDate, function ($q) use ($startDate) {
            return $q->whereDate('created_at', '>=', $startDate);
        })->when($endDate, function ($q) use ($endDate) {
            return $q->whereDate('created_at', '<=', $endDate);
        });
    }

    // Scope untuk sorting
    public function scopeSortBy($query, $sort = 'newest')
    {
        switch ($sort) {
            case 'oldest':
                return $query->oldest();
            case 'most_viewed':
                return $query->orderBy('views', 'desc');
            case 'least_viewed':
                return $query->orderBy('views', 'asc');
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
