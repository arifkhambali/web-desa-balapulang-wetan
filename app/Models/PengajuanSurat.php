<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PengajuanSurat extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan_admin', 'file_surat', 'tanggal_selesai'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'user_id',
        'sumber_pengajuan',
        'jenis_surat_id',
        'nomor_surat',
        'data_pemohon',
        'lampiran',
        'status',
        'catatan_admin',
        'file_surat',
        'tanggal_pengajuan',
        'tanggal_selesai'
    ];

    protected $casts = [
        'data_pemohon' => 'array',
        'lampiran' => 'array',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
