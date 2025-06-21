<?php

namespace App\Livewire\MataKuliah;

use Livewire\Component;
use App\Models\MataKuliah;

class Edit extends Component
{
    public $MataKuliah_ID;
    public $kode;
    public $nama_matakuliah;
    public $sks;

    public function mount($id)
    {
        $data = MataKuliah::findOrFail($id);
        $this->MataKuliah_ID    = $data->id;
        $this->kode            = $data->kode;
        $this->nama_matakuliah = $data->nama_matakuliah;
        $this->sks             = $data->sks;
    }

    public function update()
    {
        $this->validate([
            'kode' => 'required|unique:mata_kuliahs,kode,' . $this->MataKuliah_ID,
            'nama_matakuliah' => 'required|max:100',
            'sks' => 'required|integer|min:1|max:4',
        ]);

        $matakuliah = MataKuliah::findOrFail($this->MataKuliah_ID);
        
        $matakuliah->update([
            'kode' => $this->kode,
            'nama_matakuliah' => $this->nama_matakuliah,
            'sks' => $this->sks,
        ]);

        session()->flash('sukses', 'Data berhasil diperbarui.');
        return $this->redirectRoute('mata-kuliah.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.mata-kuliah.edit');
    }
}
