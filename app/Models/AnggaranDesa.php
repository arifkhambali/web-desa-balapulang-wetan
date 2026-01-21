<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AnggaranDesa extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['tahun', 'jenis', 'kategori', 'rincian', 'nominal'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'tahun',
        'jenis',
        'kategori',
        'rincian',
        'nominal',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'nominal' => 'decimal:2',
    ];
}
