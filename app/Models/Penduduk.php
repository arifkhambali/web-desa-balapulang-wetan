<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Penduduk extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nik', 'nama_lengkap', 'status_hidup', 'alamat', 'rt', 'rw'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    
    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_stats');
            \Illuminate\Support\Facades\Cache::forget('page_statistik');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_stats');
            \Illuminate\Support\Facades\Cache::forget('page_statistik');
        });
    }

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_perkawinan',
        'status_keluarga', // Kepala Keluarga, Istri, Anak
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'status_hidup', // Hidup, Meninggal, Pindah
        'golongan_darah',
        'kewarganegaraan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Helper untuk menghitung umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
