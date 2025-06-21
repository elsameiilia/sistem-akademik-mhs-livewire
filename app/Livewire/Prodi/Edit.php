<?php

namespace App\Livewire\Prodi;

use Livewire\Component;
use App\Models\Prodi;
use App\Models\Fakultas;

class Edit extends Component
{
    public $Prodi_ID;
    public $nama_prodi;
    public $fakultas_id;

    public function mount($id)
    {
        $data = Prodi::findOrFail($id);
        $this->Prodi_ID         = $data->id;
        $this->nama_prodi       = $data->nama_prodi;
        $this->fakultas_id      = $data->fakultas_id;
    }

    public function update()
    {
        $this->validate([
            'nama_prodi' => 'required|unique:prodis,nama_prodi,' . $this->Prodi_ID,
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        $Prodi = Prodi::findOrFail($this->Prodi_ID);
        
        $Prodi->update([
            'nama_prodi' => $this->nama_prodi,
            'fakultas_id' => $this->fakultas_id,
        ]);

        session()->flash('sukses', 'Data berhasil diperbarui.');
        return $this->redirectRoute('prodi.index', navigate: true);
    }

    public function render()
    {
        $fakultas = Fakultas::all();
        return view('livewire.prodi.edit', ['semuaFakultas' => $fakultas]);
    }
}
