<?php

namespace App\Livewire\Krs;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Livewire\Component;

class Form extends Component
{
    public Mahasiswa $mahasiswa;
    public $semuaMatakuliah;
    public $pilihanMatakuliah = [];
    public $totalSks = 0;
    public $semester;

    public function mount(Mahasiswa $mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
        $this->semuaMatakuliah = collect();
    }

    public function updatedSemester($value)
    {
        if (!empty($value) && is_numeric($value)) {
            $this->loadKrsForSemester($value);
        } else {
            $this->semuaMatakuliah = collect();
            $this->pilihanMatakuliah = [];
            $this->totalSks = 0;
        }
    }

    public function loadKrsForSemester($semester)
    {
        $this->semuaMatakuliah = Matakuliah::orderBy('nama_matakuliah')->get();
        $krsSudahDiambil = Krs::where('mahasiswa_id', $this->mahasiswa->id)
                              ->where('semester', $semester)
                              ->pluck('matakuliah_id')
                              ->toArray();
        $this->pilihanMatakuliah = [];
        $this->totalSks = 0;

        foreach ($this->semuaMatakuliah as $matkul) {
            if (in_array($matkul->id, $krsSudahDiambil)) {
                $this->pilihanMatakuliah[$matkul->id] = true;
                $this->totalSks += $matkul->sks; 
            } else {
                $this->pilihanMatakuliah[$matkul->id] = false;
            }
        }
    }

    public function updatedPilihanMatakuliah()
    {
        $this->totalSks = 0;
        foreach ($this->pilihanMatakuliah as $matakuliahId => $dipilih) {
            if ($dipilih) {
                $matkul = $this->semuaMatakuliah->find($matakuliahId);
                if ($matkul) {
                    $this->totalSks += $matkul->sks;
                }
            }
        }
    }

    public function simpanKrs()
    {
        $this->validate([
            'semester' => 'required|integer|min:1|max:8',
            'totalSks' => 'lte:24'
        ]);

        Krs::where('mahasiswa_id', $this->mahasiswa->id)
           ->where('semester', $this->semester)
           ->delete();

        foreach ($this->pilihanMatakuliah as $matakuliahId => $dipilih) {
            if ($dipilih) {
                Krs::create([
                    'mahasiswa_id' => $this->mahasiswa->id,
                    'matakuliah_id' => $matakuliahId,
                    'semester' => $this->semester,
                ]);
            }
        }

        session()->flash('sukses', 'KRS untuk semester ' . $this->semester . ' berhasil disimpan.');
        return $this->redirectRoute('dashboard');
    }

    public function render()
    {
        return view('livewire.krs.form')->layout('components.layouts.app', ['title' => 'Formulir KRS']);
    }
}