<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Livewire\Mahasiswa;
use App\Livewire\Prodi;
use App\Livewire\MataKuliah;
use App\Livewire\Krs;
use App\Livewire\Dashboard;
use App\Models\User;

Route::get('/test-admin', function () {
    // Cari user admin
    $user = User::where('email', 'admin@gmail.com')->first();

    // Jika tidak ditemukan, beri pesan
    if (!$user) {
        return 'User admin tidak ditemukan di database.';
    }

    // Hentikan semua eksekusi dan tampilkan isi dari variabel $user
    dd($user);
});

// ... sisa rute Anda ...

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware('role:admin')->group(function () {
        // MataKuliah Routes
        Route::get('/mata-kuliah', MataKuliah\Index::class)->name('mata-kuliah.index');
        Route::get('/mata-kuliah/create', MataKuliah\Create::class)->name('mata-kuliah.create');
        Route::get('/mata-kuliah/{id}/edit', MataKuliah\Edit::class)->name('mata-kuliah.edit');

        // Mahasiswa Routes
        Route::get('/mahasiswa', Mahasiswa\Index::class)->name('mahasiswa.index');
        Route::get('/mahasiswa/create', Mahasiswa\Create::class)->name('mahasiswa.create');
        Route::get('/mahasiswa/{id}/edit', Mahasiswa\Edit::class)->name('mahasiswa.edit');

        // Prodi Routes
        Route::get('/prodi', Prodi\Index::class)->name('prodi.index');
        Route::get('/prodi/create', Prodi\Create::class)->name('prodi.create');
        Route::get('/prodi/{id}/edit', Prodi\Edit::class)->name('prodi.edit');
    });

    Route::middleware('role:mahasiswa')->group(function () {
        // Mahasiswa Routes
        Route::get('/krs', Krs\Index::class)->name('krs.index');
        Route::get('/krs/{mahasiswa}/isi', Krs\Form::class)->name('krs.form');
    });
    
});

require __DIR__.'/auth.php';