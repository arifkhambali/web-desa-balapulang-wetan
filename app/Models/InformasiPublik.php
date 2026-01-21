<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    protected $table = 'informasi_publik';

    protected $fillable = [
        'judul',
        'slug',
        'file_path',
        'tgl_terbit',
        'unit_pengelola',
    ];

    protected $casts = [
        'tgl_terbit' => 'date',
    ];
}
