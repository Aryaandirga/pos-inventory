<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('categories.index') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Tambah Kategori</h2>
            <p class="text-sm text-gray-400">Buat kategori produk baru</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form wire:submit="save" class="space-y-5">

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       wire:model="name"
                       placeholder="Contoh: Minuman, Makanan Ringan..."
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                    Deskripsi
                </label>
                <textarea wire:model="description"
                          rows="3"
                          placeholder="Deskripsi kategori (opsional)..."
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('categories.index') }}"
                   class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors text-center">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition-colors">
                    <span wire:loading.remove>Simpan Kategori</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>
</div>