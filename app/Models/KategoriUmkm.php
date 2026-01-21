<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class KategoriUmkm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    // Auto-generate slug dari nama_kategori
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });

        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama_kategori')) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
    }

    // Relationship
    public function umkms()
    {
        return $this->hasMany(Umkm::class, 'kategori_umkm_id');
    }
}
