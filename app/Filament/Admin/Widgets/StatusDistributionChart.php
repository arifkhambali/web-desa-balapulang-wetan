<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use Filament\Widgets\ChartWidget;

class StatusDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Surat';
    
    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $statusData = PengajuanSurat::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $labels = [];
        $data = [];
        $colors = [
            'pending' => '#f59e0b',
            'diproses' => '#3b82f6',
            'menunggu_persetujuan' => '#8b5cf6',
            'selesai' => '#10b981',
            'ditolak' => '#ef4444',
        ];

        $statusLabels = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'menunggu_persetujuan' => 'Menunggu Approval',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $backgroundColors = [];
        foreach ($statusData as $status => $total) {
            $labels[] = $statusLabels[$status] ?? ucfirst($status);
            $data[] = $total;
            $backgroundColors[] = $colors[$status] ?? '#6b7280';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Surat',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
