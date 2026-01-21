<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeri extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_galleries');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_galleries');
        });
    }

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal_kegiatan'
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];

    public function scopeByKategori($query, $kategori)
    {
        return $query->when($kategori, function ($q) use ($kategori) {
            return $q->where('kategori', $kategori);
        });
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->whereFullText(['judul', 'deskripsi'], $search);
        });
    }

    // Scope untuk filter tanggal kegiatan
    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        return $query->when($startDate, function ($q) use ($startDate) {
            return $q->whereDate('tanggal_kegiatan', '>=', $startDate);
        })->when($endDate, function ($q) use ($endDate) {
            return $q->whereDate('tanggal_kegiatan', '<=', $endDate);
        });
    }

    // Scope untuk sorting
    public function scopeSortBy($query, $sort = 'newest')
    {
        switch($sort) {
            case 'oldest':
                return $query->oldest();
            case 'event_date_asc':
                return $query->orderBy('tanggal_kegiatan', 'asc');
            case 'event_date_desc':
                return $query->orderBy('tanggal_kegiatan', 'desc');
            default:
                return $query->latest(); // newest upload
        }
    }
}
