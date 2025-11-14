<div>
    <div class="w-full max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-xl">
        
        @if (session('sukses'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Mahasiswa</h2>
            @if (auth()->user()->role == \App\Enums\Role::Admin)
                <a dusk="btn-add-mhs" href="{{ route('mahasiswa.create') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700">
                    Tambah Data Mahasiswa
                </a>
            @endif
        </div>
        <div class="mb-4 p-4 bg-gray-50 rounded-lg flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-1/3">
                <label for="filterFakultas" class="text-sm font-medium text-gray-700">Filter Berdasarkan Fakultas</label>
                <select wire:model.live="filterFakultas" id="filterFakultas" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="">Semua Fakultas</option>
                    @foreach($semuaFakultas as $fakultas)
                        <option value="{{ $fakultas->id }}">{{ $fakultas->nama_fakultas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-auto">
                <button wire:click="resetFilters" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100">
                    Reset Filter
                </button>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 text-sm font-semibold">
                    <tr>
                        <th wire:click="sortBy('nim')" class="px-6 py-3 text-left cursor-pointer hover:text-blue-600">NIM</th>
                        <th wire:click="sortBy('nama')" class="px-6 py-3 text-left cursor-pointer hover:text-blue-600">Nama</th>
                        <th class="px-6 py-3 text-left">Program Studi</th>
                        <th wire:click="sortBy('total_sks')" class="px-6 py-3 text-center cursor-pointer hover:text-blue-600">Total SKS</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($dataMahasiswa as $mhs)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $mhs->prodi->nama_prodi ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-medium">{{ $mhs->total_sks ?? 0 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if (auth()->user()->role == \App\Enums\Role::Admin)
                                    <a dusk="edit-mhs-{{ $mhs->id }}" href="{{ route('mahasiswa.edit', $mhs->id) }}" wire:navigate class="font-medium text-blue-600 hover:text-blue-800">Edit</a>
                                    <button dusk="delete-mhs-{{ $mhs->id }}" wire:click="destroy({{ $mhs->id }})" class="ml-4 font-medium text-red-600 hover:text-red-800" wire:confirm="Anda yakin?">Hapus</button>
                                @else
                                    <span class="text-gray-400">--</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data mahasiswa yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $dataMahasiswa->links() }}
        </div>
    </div>
</div>
