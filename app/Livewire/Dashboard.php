<?php

namespace App\Livewire;

use App\Enums\Role;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed; // <-- Import attribute Computed

class Dashboard extends Component
{
    // Properti untuk admin
    public $totalMahasiswa;
    public $totalProdi;
    public $totalMataKuliah;

    // Properti untuk mahasiswa
    public $krsMahasiswa;

    // Properti BARU untuk filter semester
    public $selectedSemester = ''; // Defaultnya kosong, berarti "Semua Semester"

    public function mount()
    {
        $user = Auth::user();

        // Logika untuk Admin (tidak berubah)
        if ($user->role === Role::Admin) {
            $this->totalMahasiswa = Mahasiswa::count();
            $this->totalProdi = Prodi::count();
            $this->totalMataKuliah = MataKuliah::count();
        }

        // Logika untuk Mahasiswa (sedikit diubah)
        if ($user->role === Role::Mahasiswa) {
            $mahasiswa = $user->mahasiswa;
            if ($mahasiswa) {
                // Sekarang kita muat SEMUA data KRS ke satu properti
                $this->krsMahasiswa = $mahasiswa->krs()->with('matakuliah')->get();
            }
        }
    }

    // Computed Property untuk memfilter KRS berdasarkan semester yang dipilih
    #[Computed]
    public function filteredKrs()
    {
        // Jika tidak ada semester yang dipilih, tampilkan semua
        if (empty($this->selectedSemester)) {
            return $this->krsMahasiswa;
        }

        // Jika ada semester yang dipilih, filter koleksinya
        return $this->krsMahasiswa->where('semester', $this->selectedSemester);
    }

    // Computed Property untuk menghitung total SKS dari KRS yang sudah difilter
    #[Computed]
    public function totalSksDiambil()
    {
        // Jika krsMahasiswa kosong atau tidak ada, kembalikan 0
        if (!$this->krsMahasiswa) {
            return 0;
        }

        // Hitung total SKS dari koleksi yang sudah difilter
        return $this->filteredKrs->sum(function ($krs) {
            // Tambahkan pengecekan jika relasi matakuliah tidak ada
            return $krs->matakuliah->sks ?? 0;
        });
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app', ['title' => 'Dashboard']);
    }
}