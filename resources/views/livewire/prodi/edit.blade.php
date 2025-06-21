<div>
    <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6 md:p-8">

        <form wire:submit.prevent="update">
            
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Prodi</h2>
                <p class="text-gray-500 mt-1">Ubah detail program studi pada form di bawah ini.</p>
            </div>
            <div class="space-y-6">
                <div>
                    <label for="nama_prodi" class="block text-sm font-medium text-gray-700 mb-1">Nama Prodi</label>
                    <input type="text" id="nama_prodi" wire:model.lazy="nama_prodi" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 p-2 focus:ring-blue-500 transition @error('nama_prodi') border-red-500 @enderror">
                    @error('nama_prodi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="fakultas_id" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                    <select id="fakultas_id" wire:model="fakultas_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 p-2 focus:ring-blue-500 transition @error('fakultas_id') border-red-500 @enderror">
                        <option value="">Pilih Fakultas</option>
                        @foreach($semuaFakultas as $fakultas)
                            <option value="{{ $fakultas->id }}">{{ $fakultas->nama_fakultas }}</option>
                        @endforeach
                    </select>
                    @error('fakultas_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('prodi.index') }}" wire:navigate class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                    Batal
                </a>
                    <button type="submit" 
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                        wire:loading.attr="disabled" wire:loading.class="opacity-75">
                    <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Update</span>
                </button>
            </div>
        </form>
    </div>
</div>
