<?php

namespace App\Livewire\Mahasiswa;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public $filterFakultas = '';

    public function updatingFilterFakultas()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset('filterFakultas');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function destroy($id)
    {
        Mahasiswa::destroy($id);
        session()->flash('sukses', 'Data mahasiswa berhasil dihapus.');
    }

    public function render()
    {
        $dataMahasiswa = Mahasiswa::with('prodi.fakultas')
            ->withSum('matakuliah as total_sks', 'sks')
            ->when($this->filterFakultas, function ($query) {
                $query->whereHas('prodi', function ($subQuery) {
                    $subQuery->where('fakultas_id', $this->filterFakultas);
                });
            })
            ->orderBy($this->sortField === 'total_sks' ? 'total_sks' : $this->sortField, $this->sortDirection)
            ->paginate(10);

        $semuaFakultas = Fakultas::orderBy('nama_fakultas')->get();

        return view('livewire.mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
            'semuaFakultas' => $semuaFakultas,
        ])->layout('components.layouts.app', ['title' => 'Daftar Mahasiswa']);
    }
}
