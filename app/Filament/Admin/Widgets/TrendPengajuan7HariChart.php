<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TrendPengajuan7HariChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Pengajuan 7 Hari Terakhir';
    
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Ambil data 7 hari terakhir
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = PengajuanSurat::whereDate('created_at', $date->format('Y-m-d'))->count();
            
            $labels[] = $date->format('d M');
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengajuan',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
