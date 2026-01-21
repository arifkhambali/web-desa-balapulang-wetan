<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\InformasiPublik;

class InformasiPublikTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $informasiPublik = InformasiPublik::query()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%');
            })
            ->latest('tgl_terbit')
            ->paginate(10);

        return view('livewire.informasi-publik-table', [
            'informasiPublik' => $informasiPublik,
        ]);
    }
}
