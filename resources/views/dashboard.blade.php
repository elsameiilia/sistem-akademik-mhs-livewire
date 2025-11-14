<div>
    @if (session('sukses'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Anda login sebagai {{ auth()->user()->role->value }}.</p>
    </div>

    @if(auth()->user()->role == \App\Enums\Role::Admin)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-500">Total Mahasiswa</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $totalMahasiswa }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-500">Total Program Studi</h3>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ $totalProdi }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-500">Total Mata Kuliah</h3>
                <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalMataKuliah }}</p>
            </div>
        </div>
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Akses Cepat</h3>
             <div class="flex flex-wrap gap-4">
                <a href="{{ route('mahasiswa.index') }}" wire:navigate class="px-5 py-3 bg-white shadow rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Manajemen Mahasiswa</a>
                <a href="{{ route('prodi.index') }}" wire:navigate class="px-5 py-3 bg-white shadow rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Manajemen Prodi</a>
                <a href="{{ route('mata-kuliah.index') }}" wire:navigate class="px-5 py-3 bg-white shadow rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Manajemen Mata Kuliah</a>
             </div>
        </div>
    @endif

    @if(auth()->user()->role == \App\Enums\Role::Mahasiswa)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Kartu Rencana Studi (KRS) Anda</h3>

            @if(auth()->user()->mahasiswa)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div><strong>NIM:</strong> {{ auth()->user()->mahasiswa->nim }}</div>
                    <div><strong>Prodi:</strong> {{ auth()->user()->mahasiswa->prodi->nama_prodi }}</div>
                    <div><strong>Total SKS Diambil:</strong> <span class="font-bold text-blue-600">{{ $totalSksDiambil ?? 0 }}</span></div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Kode</th>
                                <th class="px-6 py-3 text-left">Nama Mata Kuliah</th>
                                <th class="px-6 py-3 text-center">SKS</th>
                                <th class="px-6 py-3 text-center">Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($krsMahasiswa as $krs)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $krs->matakuliah->kode }}</td>
                                    <td class="px-6 py-4">{{ $krs->matakuliah->nama_matakuliah }}</td>
                                    <td class="px-6 py-4 text-center">{{ $krs->matakuliah->sks }}</td>
                                    <td class="px-6 py-4 text-center">{{ $krs->semester }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Anda belum mengambil KRS.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-red-500">Data akademik Anda tidak ditemukan. Harap hubungi admin.</p>
            @endif
        </div>
    @endif

</div>