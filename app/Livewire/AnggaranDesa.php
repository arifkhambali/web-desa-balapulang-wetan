<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AnggaranDesa as AnggaranModel;
use App\Models\IdentitasDesa;
use Livewire\Attributes\Url;

class AnggaranDesa extends Component
{
    #[Url]
    public $tahun;

    public function mount()
    {
        if (!$this->tahun) {
            $latest = AnggaranModel::max('tahun');
            $this->tahun = $latest ?? date('Y');
        }
    }

    public function render()
    {
        $identitasDesa = IdentitasDesa::first() ?? new IdentitasDesa([
            'nama_desa' => 'Desa Tundagan',
            'alamat' => 'Alamat Desa Belum Diisi',
            'email' => 'admin@desa.id',
            'telepon' => '-',
        ]);

        $availableYears = AnggaranModel::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        
        // Validate year
        if ($availableYears->isNotEmpty() && !$availableYears->contains($this->tahun)) {
             $this->tahun = $availableYears->first();
        }

        $anggaran = AnggaranModel::where('tahun', $this->tahun)->get();

        $pendapatan = $anggaran->where('jenis', 'pendapatan');
        $belanja = $anggaran->where('jenis', 'belanja');
        $pembiayaan = $anggaran->where('jenis', 'pembiayaan');

        $totalPendapatan = $pendapatan->sum('nominal');
        $totalBelanja = $belanja->sum('nominal');
        $totalPembiayaan = $pembiayaan->sum('nominal');

        return view('livewire.anggaran-desa', compact(
            'identitasDesa', 
            'availableYears', 
            'pendapatan', 
            'belanja', 
            'pembiayaan',
            'totalPendapatan',
            'totalBelanja',
            'totalPembiayaan'
        ))->layout('layouts.app', [
            'identitasDesa' => $identitasDesa, // Layout might need this
            'title' => 'Transparansi Anggaran - ' . ($identitasDesa->nama_desa ?? 'Desa')
        ]);
    }
}
