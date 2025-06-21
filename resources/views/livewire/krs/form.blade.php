<div>
    <div class="w-full max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl">
        <div class="mb-6 pb-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Formulir Rencana Studi (KRS)</h2>
            <p class="mt-2"><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
            <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            <p><strong>Prodi:</strong> {{ $mahasiswa->prodi->nama_prodi }}</p>
        </div>

        <form wire:submit.prevent="simpanKrs">
            <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Pilih Semester</label>
                    <select wire:model.live="semester" id="semester" class="mt-1 w-48 border-gray-300 rounded-lg shadow-sm">
                        <option value="">-- Semester --</option>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @if($semester)
                <div class="text-right">
                    <p class="text-lg">Total SKS Dipilih</p>
                    <span class="text-3xl font-bold @if($totalSks > 24) text-red-500 @else text-blue-600 @endif">
                        {{ $totalSks }}
                    </span> / 24
                    @error('totalSks')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            @if($semester)
            <div wire:loading wire:target="semester" class="text-center p-4">
                <p class="text-gray-500">Memuat data KRS...</p>
            </div>
            <div wire:loading.remove wire:target="semester">
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">Pilih</th>
                                <th class="px-6 py-3 text-left">Kode</th>
                                <th class="px-6 py-3 text-left">Nama Mata Kuliah</th>
                                <th class="px-6 py-3 text-center">SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semuaMatakuliah as $matkul)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" 
                                               wire:model="pilihanMatakuliah.{{ $matkul->id }}"
                                               class="rounded"
                                               @if($totalSks >= 24 && !$pilihanMatakuliah[$matkul->id]) disabled @endif>
                                    </td>
                                    <td class="px-6 py-4">{{ $matkul->kode }}</td>
                                    <td class="px-6 py-4">{{ $matkul->nama_matakuliah }}</td>
                                    <td class="px-6 py-4 text-center">{{ $matkul->sks }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data mata kuliah yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Simpan KRS
                    </button>
                </div>
            </div>
            @endif

        </form>
    </div>
</div>
