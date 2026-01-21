<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AparaturDesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'slug',
        'nip',
        'jabatan',
        'urutan',
        'foto',
        'email',
        'telepon',
        'alamat',
        'tanggal_mulai_jabatan',
        'tanggal_selesai_jabatan',
        'pendidikan',
        'bio',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai_jabatan' => 'date',
        'tanggal_selesai_jabatan' => 'date',
        'aktif' => 'boolean',
    ];

    // Auto-generate slug dari nama
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($aparatur) {
            if (empty($aparatur->slug)) {
                $aparatur->slug = Str::slug($aparatur->nama);
            }
        });

        static::updating(function ($aparatur) {
            if ($aparatur->isDirty('nama')) {
                $aparatur->slug = Str::slug($aparatur->nama);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_aparatur');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_aparatur');
        });
    }
}
