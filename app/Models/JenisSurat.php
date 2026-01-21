<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSurat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama_surat',
        'deskripsi',
        'persyaratan',
        'icon',
        'color',
        'template_html',
        'form_schema',
        'aktif'
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'form_schema' => 'array',
        'aktif' => 'boolean'
    ];

    public function getDisplayIconAttribute()
    {
        if ($this->icon) {
            return $this->icon;
        }

        $icons = [
            'fa-file-lines', 'fa-hand-holding-heart', 'fa-house-chimney', 
            'fa-briefcase', 'fa-person-walking-luggage', 'fa-baby-carriage',
            'fa-skull', 'fa-gavel', 'fa-id-card', 'fa-certificate'
        ];

        return $icons[$this->id % count($icons)];
    }

    public function getDisplayColorAttribute()
    {
        if ($this->color) {
            return $this->color;
        }

        $colors = [
            'blue', 'green', 'orange', 'purple', 'indigo', 'red', 'slate', 'yellow', 'teal', 'cyan'
        ];

        return $colors[$this->id % count($colors)];
    }

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
