<?php

namespace App\Livewire\Prodi;

use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    function destroy($id)
    {
        Prodi::destroy($id);
        Alert::toast('Berhasil hapus data', 'success');
    }

    function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $dataProdi = Prodi::with('fakultas')
        ->when($this->search, fn($q) => $q->where('nama_prodi', 'like', '%' . $this->search . '%'))
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        return view('livewire.prodi.index', compact('dataProdi'));
    }
}
