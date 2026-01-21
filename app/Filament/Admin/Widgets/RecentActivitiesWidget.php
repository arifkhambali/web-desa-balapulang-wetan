<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use Filament\Widgets\Widget;
use Illuminate\Support\HtmlString;

class RecentActivitiesWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.recent-activities-widget';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 1;

    public function getActivities(): array
    {
        $activities = [];
        
        // Ambil 5 pengajuan terbaru
        $recentSubmissions = PengajuanSurat::with(['user', 'jenisSurat'])
            ->latest()
            ->limit(5)
            ->get();

        foreach ($recentSubmissions as $submission) {
            $userName = $submission->user->name ?? 'Unknown';
            $suratName = $submission->jenisSurat->nama_surat ?? 'Unknown';
            $time = $submission->created_at->diffForHumans();
            
            $icon = match($submission->status) {
                'pending' => 'heroicon-o-clock',
                'diproses' => 'heroicon-o-arrow-path',
                'menunggu_persetujuan' => 'heroicon-o-exclamation-circle',
                'selesai' => 'heroicon-o-check-circle',
                'ditolak' => 'heroicon-o-x-circle',
                default => 'heroicon-o-document',
            };
            
            $color = match($submission->status) {
                'pending' => 'text-yellow-600',
                'diproses' => 'text-blue-600',
                'menunggu_persetujuan' => 'text-purple-600',
                'selesai' => 'text-green-600',
                'ditolak' => 'text-red-600',
                default => 'text-gray-600',
            };

            $statusLabel = match($submission->status) {
                'pending' => 'mengajukan',
                'diproses' => 'sedang diproses',
                'menunggu_persetujuan' => 'menunggu persetujuan Kades',
                'selesai' => 'telah disetujui',
                'ditolak' => 'ditolak',
                default => 'status unknown',
            };

            $activities[] = [
                'icon' => $icon,
                'color' => $color,
                'text' => "{$userName} {$statusLabel} {$suratName}",
                'time' => $time,
                'url' => route('filament.admin.resources.pengajuan-surats.edit', ['record' => $submission->id]),
            ];
        }

        return $activities;
    }
}
