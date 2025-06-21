<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Prodi;

class Edit extends Component
{
    public $Mahasiswa_ID;
    public $nim;
    public $nama;
    public $prodi_id;

    public function mount($id)
    {
        $data = Mahasiswa::findOrFail($id);
        $this->Mahasiswa_ID     = $data->id;
        $this->nim              = $data->nim;
        $this->nama             = $data->nama;
        $this->prodi_id         = $data->prodi_id;
    }

    public function update()
    {
        $this->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $this->Mahasiswa_ID,
            'nama' => 'required',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        $Mahasiswa = Mahasiswa::findOrFail($this->Mahasiswa_ID);
        
        $Mahasiswa->update([
            'nim' => $this->nim,
            'nama' => $this->nama,
            'prodi_id' => $this->prodi_id,
        ]);

        session()->flash('sukses', 'Data berhasil diperbarui.');
        return $this->redirectRoute('mahasiswa.index', navigate: true);
    }

    public function render()
    {
        $prodi = Prodi::all();
        return view('livewire.mahasiswa.edit', ['semuaProdi' => $prodi]);
    }
}

