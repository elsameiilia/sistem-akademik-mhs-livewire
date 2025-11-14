<?php
namespace App\Livewire\MataKuliah;
use App\Models\MataKuliah;
use Livewire\Component;
class Create extends Component
{
    public $kode;
    public $nama_matakuliah;
    public $sks;
    function store()
    {
        $this->validate([
            'kode' => 'required|unique:mata_kuliahs,kode',
            'nama_matakuliah' => 'required',
            'sks'   => 'required|integer|min:1|max:4',
        ]);
        MataKuliah::create([
            'kode' => $this->kode,
            'nama_matakuliah' => $this->nama_matakuliah,
            'sks' => $this->sks
        ]);

        session()->flash('sukses', 'Data mata kuliah berhasil ditambahkan.');
        return $this->redirectRoute('mata-kuliah.index', navigate: true);
    }
    public function render()
    {
        return view('livewire.mata-kuliah.create')
            ->layout('layouts.app', ['title' => 'Tambah Mata Kuliah']);
    }
}
