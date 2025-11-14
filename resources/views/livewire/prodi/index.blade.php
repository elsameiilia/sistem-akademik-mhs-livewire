<div>
    <div class="w-full max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl">
        
        @if (session('sukses'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Prodi</h2>
            <!-- <div class="relative w-full sm:w-1/3">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.debounce.500ms="search" class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Cari mata kuliah...">
            </div> -->
            @if (auth()->user()->role == \App\Enums\Role::Admin)
                <a dusk="btn-add-prodi" href="{{ route('prodi.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Tambah Prodi
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            @else
                <span class="text-gray-500">Detail data program studi.</span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 text-sm font-semibold">
                    <tr>
                        <th wire:click="sortBy('nama_prodi')" class="px-6 py-3 text-left cursor-pointer hover:text-blue-600 transition-colors">
                            Nama Prodi
                            @if ($sortField === 'nama_prodi')
                                <span class="ml-1">@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('fakultas_id')" class="px-6 py-3 text-left cursor-pointer hover:text-blue-600 transition-colors">
                            Fakultas
                            @if ($sortField === 'fakultas_id')
                                <span class="ml-1">@if ($sortDirection === 'asc') ↑ @else ↓ @endif</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center cursor-pointer hover:text-blue-600 transition-colors">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($dataProdi as $prodi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $prodi->nama_prodi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $prodi->fakultas?->nama_fakultas ?? 'Tidak ada Fakultas' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if (auth()->user()->role == \App\Enums\Role::Admin)
                                <a dusk="edit-prodi-{{ $prodi->id }}" href="{{ route('prodi.edit', $prodi->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                    Edit
                                </a>
                                <button dusk="delete-prodi-{{ $prodi->id }}" wire:click="destroy({{ $prodi->id }})" class="ml-4 text-red-600 hover:text-red-800 transition-colors" wire:confirm="Apakah anda yakin ingin menghapus program studi ini?">
                                    Hapus
                                </button>
                            @else
                                <span class="text-gray-500">Tidak ada aksi yang tersedia</span>
                            @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data program studi yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $dataProdi->links() }}
        </div>
    </div>
</div>