<?php

namespace App\Filament\Warga\Widgets;

use App\Models\PengajuanSurat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class WargaStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s'; // Auto-refresh setiap 30 detik
    
    protected function getStats(): array
    {
        $userId = Auth::id();

        return [
            Stat::make('Surat Pending', PengajuanSurat::where('user_id', $userId)->where('status', 'pending')->count())
                ->description('Menunggu verifikasi admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('Surat Diproses', PengajuanSurat::where('user_id', $userId)->whereIn('status', ['diproses', 'menunggu_persetujuan'])->count())
                ->description('Sedang dalam proses')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Surat Selesai', PengajuanSurat::where('user_id', $userId)->where('status', 'selesai')->count())
                ->description('Siap diunduh')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Surat Ditolak', PengajuanSurat::where('user_id', $userId)->where('status', 'ditolak')->count())
                ->description('Pengajuan ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
