<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function preview($id)
    {
        $pengajuan = PengajuanSurat::with(['jenisSurat', 'user'])->findOrFail($id);

        // 1. Authorization Check
        $user = auth()->user();
        if (!$user) {
            // Jika belum login, redirect ke login
            return redirect()->route('filament.admin.auth.login');
        }

        $isOwner = $user->id === $pengajuan->user_id;
        $isAdmin = $user->role === 'admin';
        $isKades = $user->role === 'kades';

        if (!$isOwner && !$isAdmin && !$isKades) {
            // Extra Check for Warga (NIK based)
            $isWargaOwner = false;
            
            // Ensure penduduk relation is loaded
            if ($user->role === 'warga') {
                $user->loadMissing('penduduk');
                
                if ($user->penduduk) {
                     // Cek NIK di data surat
                    $nikPemohon = $pengajuan->data_pemohon['nik'] ?? null;
                    
                    // Use loose comparison (==) just in case of string/int mismatch
                    if ($nikPemohon && $user->penduduk->nik == $nikPemohon) {
                        $isWargaOwner = true;
                    }
                }
            }
            
            if (!$isWargaOwner) {
                // Return 403 but with more debug info (safe for now)
                abort(403, 'Unauthorized access. NIK Check Failed.');
            }
        }

        // 2. Prepare Data
        $dataPemohon = $pengajuan->data_pemohon;
        $nik = $dataPemohon['nik'] ?? null;
        
        $penduduk = null;
        if ($nik) {
            $penduduk = \App\Models\Penduduk::where('nik', $nik)->first();
        }

        // Fallback dummy object if penduduk not found
        if (!$penduduk) {
            $penduduk = new \App\Models\Penduduk([
                'nama_lengkap' => $dataPemohon['nama'] ?? '-',
                'nik' => $nik ?? '-',
                'alamat' => $dataPemohon['alamat'] ?? '-',
                // ... add other necessary fields default to '-' or now()
            ]);
        }

        // 3. Render PDF
        $jenisSurat = $pengajuan->jenisSurat;
        
        if (!empty($jenisSurat->template_html)) {
            // Render from Database Template
            $html = \Illuminate\Support\Facades\Blade::render($jenisSurat->template_html, [
                'pengajuan' => $pengajuan,
                'penduduk' => $penduduk
            ]);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
        } else {
            // Render from Blade View Fallback
            $kodeSurat = $jenisSurat->kode ?? 'SKD';
            $viewName = 'surat.' . $kodeSurat;
            if (!view()->exists($viewName)) {
                $viewName = 'surat.SKD';
            }
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, [
                'pengajuan' => $pengajuan,
                'penduduk' => $penduduk
            ])->setPaper('a4', 'portrait');
        }

        // 4. Stream PDF
        return $pdf->stream('preview-surat.pdf');
    }
}
