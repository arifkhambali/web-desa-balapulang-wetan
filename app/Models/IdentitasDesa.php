<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class IdentitasDesa extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    
    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('identitas_desa');
        });
        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('identitas_desa');
        });
    }

    protected $fillable = [
        'nama_desa',
        'alamat',
        'email',
        'telepon',
        'jam_pelayanan',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'logo',
        'hero_image_beranda',
        'hero_image_umkm',
        'hero_image_pemerintahan',
        'latitude',
        'longitude',
        'batas_utara',
        'batas_timur',
        'batas_selatan',
        'batas_barat',
        'wa_api_url',
        'wa_api_key',
        'wa_sender_number',
        'wa_template_pengajuan',
        'wa_template_update_status',
    ];
}
