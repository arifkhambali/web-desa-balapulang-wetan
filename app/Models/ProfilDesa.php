<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_profil');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_profil');
        });
    }

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'icon',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];
}
