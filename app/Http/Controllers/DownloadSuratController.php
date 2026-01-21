<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DownloadSuratController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PengajuanSurat $record)
    {
        // 1. Authorization Check
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Allow if:
        // - User is the owner of the surat
        // - User is Admin
        // - User is Kades
        $isOwner = $record->user_id === $user->id;
        $isAdmin = $user->role === 'admin';
        $isKades = $user->role === 'kades';
        
        // Extra Check: Jika user adalah Warga, cek NIK-nya juga (siapa tahu user_id di surat salah assign ke admin)
        $isWargaOwner = false;
        if ($user->role === 'warga' && $user->penduduk) {
            $nikPemohon = $record->data_pemohon['nik'] ?? null;
            if ($nikPemohon && $user->penduduk->nik === $nikPemohon) {
                $isWargaOwner = true;
            }
        }

        if (!$isOwner && !$isAdmin && !$isKades && !$isWargaOwner) {
            abort(403, 'Anda tidak memiliki hak akses untuk surat ini.');
        }

        // 2. File Loopup
        if (!$record->file_surat) {
            abort(404, 'File surat belum diterbitkan.');
        }

        // Cek di disk 'local' (private) dulu
        if (Storage::disk('local')->exists($record->file_surat)) {
            return Storage::disk('local')->download($record->file_surat);
        }
        
        // Fallback: Cek di disk 'public' (untuk file lama sebelum migrasi)
        if (Storage::disk('public')->exists($record->file_surat)) {
            return Storage::disk('public')->download($record->file_surat);
        }

        abort(404, 'File fisik tidak ditemukan di server.');
    }
}
