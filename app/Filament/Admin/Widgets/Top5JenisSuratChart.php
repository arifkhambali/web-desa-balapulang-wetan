<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class Top5JenisSuratChart extends ChartWidget
{
    protected static ?string $heading = 'Top 5 Jenis Surat Terpopuler';
    
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        // Ambil top 5 jenis surat berdasarkan jumlah pengajuan
        $topSurat = PengajuanSurat::select('jenis_surat_id', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $labels = [];
        $data = [];
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];

        foreach ($topSurat as $index => $surat) {
            $jenisSurat = JenisSurat::find($surat->jenis_surat_id);
            $labels[] = $jenisSurat->nama_surat ?? 'Unknown';
            $data[] = $surat->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengajuan',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
