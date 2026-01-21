<?php

namespace App\Filament\Admin\Widgets;

use App\Models\PengajuanSurat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Notifications\Notification;

class PendingApprovalsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Surat Menunggu Persetujuan Kepala Desa')
            ->description('Daftar surat yang perlu disetujui oleh Kepala Desa')
            ->query(
                PengajuanSurat::query()
                    ->where('status', 'menunggu_persetujuan')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Warga')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('data_pemohon.keperluan')
                    ->label('Keperluan')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->data_pemohon['keperluan'] ?? '-';
                    }),
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('sumber_pengajuan')
                    ->label('Sumber')
                    ->colors([
                        'primary' => 'warga',
                        'success' => 'admin',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (PengajuanSurat $record) {
                        $record->update([
                            'status' => 'selesai',
                            'tanggal_selesai' => now(),
                        ]);
                        
                        Notification::make()
                            ->title('Surat Disetujui')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('catatan_admin')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (PengajuanSurat $record, array $data) {
                        $record->update([
                            'status' => 'ditolak',
                            'catatan_admin' => $data['catatan_admin'],
                        ]);
                        
                        Notification::make()
                            ->title('Surat Ditolak')
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn (PengajuanSurat $record): string => 
                        route('filament.admin.resources.pengajuan-surats.edit', ['record' => $record])
                    ),
            ])
            ->emptyStateHeading('Tidak ada surat yang menunggu persetujuan')
            ->emptyStateDescription('Semua surat sudah diproses')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}
