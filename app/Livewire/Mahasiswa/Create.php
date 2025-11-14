<?php
namespace App\Livewire\Mahasiswa;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Livewire\Component;
class Create extends Component
{
    public $nim;
    public $nama;
    public $prodi_id;
    function store()
    {
        $this->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'prodi_id' => 'required|exists:prodis,id',
        ]);
        Mahasiswa::create([
            'nim' => $this->nim,
            'nama' => $this->nama,
            'prodi_id' => $this->prodi_id
        ]);
        session()->flash('sukses', 'Data mahasiswa berhasil ditambahkan.');
        return $this->redirectRoute('mahasiswa.index', navigate: true);
    }
    public function render()
    {
        $prodi = Prodi::all();
        return view('livewire.mahasiswa.create', ['semuaProdi' => $prodi]);
    }
}
