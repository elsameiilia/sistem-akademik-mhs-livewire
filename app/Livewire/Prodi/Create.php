<?php
namespace App\Livewire\Prodi;
use App\Models\Prodi;
use App\Models\Fakultas;
use Livewire\Component;
class Create extends Component
{
    public $nama_prodi;
    public $fakultas_id;
    function store()
    {
        $this->validate([
            'nama_prodi' => 'required',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);
        Prodi::create([
            'nama_prodi' => $this->nama_prodi,
            'fakultas_id' => $this->fakultas_id
        ]);
        session()->flash('sukses', 'Data prodi berhasil ditambahkan.');
        return $this->redirectRoute('prodi.index', navigate: true);
    }
    public function render()
    {
        $fakultas = Fakultas::all();
        return view('livewire.prodi.create', ['semuaFakultas' => $fakultas]);
    }
}
