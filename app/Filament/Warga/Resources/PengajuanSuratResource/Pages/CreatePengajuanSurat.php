<?php

namespace App\Filament\Warga\Resources\PengajuanSuratResource\Pages;

use App\Filament\Warga\Resources\PengajuanSuratResource;
use App\Models\User;
use App\Notifications\NewSuratSubmitted;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePengajuanSurat extends CreateRecord
{
    protected static string $resource = PengajuanSuratResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['sumber_pengajuan'] = 'warga'; // Flag untuk membedakan dari admin
        $data['status'] = 'pending';
        
        // Ambil data penduduk dari user yang login
        $user = Auth::user();
        $penduduk = $user->penduduk;

        if ($penduduk) {
            $data['data_pemohon'] = array_merge($data['data_pemohon'] ?? [], [
                'nama' => $penduduk->nama_lengkap,
                'nik' => $penduduk->nik,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir->format('d-m-Y'),
                'agama' => $penduduk->agama,
                'pekerjaan' => $penduduk->pekerjaan,
                'alamat' => $penduduk->alamat,
                'rt' => $penduduk->rt,
                'rw' => $penduduk->rw,
                'desa_kelurahan' => $penduduk->desa_kelurahan,
                'kecamatan' => $penduduk->kecamatan,
                'kabupaten_kota' => $penduduk->kabupaten_kota,
                'provinsi' => $penduduk->provinsi,
            ]);
        } else {
            // Fallback jika belum terhubung data penduduk
            $data['data_pemohon'] = array_merge($data['data_pemohon'] ?? [], [
                'nama' => $user->name,
                'email' => $user->email,
                'note' => 'Data penduduk belum terhubung',
            ]);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Kirim notifikasi ke semua admin dan kades
        $admins = User::whereIn('role', ['admin', 'kades'])->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new NewSuratSubmitted($this->record));
        }

        // Tampilkan success notification untuk warga
        Notification::make()
            ->success()
            ->title('Pengajuan Berhasil!')
            ->body('Pengajuan surat Anda telah dikirim dan menunggu verifikasi admin.')
            ->icon('heroicon-o-check-circle')
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
