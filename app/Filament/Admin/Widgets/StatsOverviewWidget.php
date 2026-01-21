<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use App\Models\Penduduk;
use App\Models\Berita;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Hitung stats
        $totalPenduduk = Penduduk::count();
        $totalUmkm = \App\Models\Umkm::count();
        $totalPending = PengajuanSurat::where('status', 'pending')->count();
        $totalBerita = \Firefly\FilamentBlog\Models\Post::count();
        
        // Hitung trend pengajuan (vs bulan lalu)
        $totalBulanIni = PengajuanSurat::whereMonth('created_at', date('m'))->count();
        $bulanLalu = PengajuanSurat::whereMonth('created_at', date('m', strtotime('-1 month')))->count();
        $trendBulanIni = $bulanLalu > 0 ? (($totalBulanIni - $bulanLalu) / $bulanLalu) * 100 : 0;

        return [
            Stat::make('Total Penduduk', number_format($totalPenduduk))
                ->description('Warga yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([10, 15, 12, 18, 20, 22, $totalPenduduk]),

            Stat::make('Produk UMKM', $totalUmkm)
                ->description('Produk lokal aktif')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info')
                ->chart([5, 8, 12, 10, 15, 13, $totalUmkm]),

            Stat::make('Surat Pending', $totalPending)
                ->description('Perlu verifikasi admin')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($totalPending > 0 ? 'warning' : 'gray')
                ->chart([5, 10, 8, 12, 9, 7, $totalPending]),
            
            Stat::make('Berita Desa', $totalBerita)
                ->description('Informasi publik')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),
        ];
    }
}
