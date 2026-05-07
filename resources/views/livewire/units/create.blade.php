<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('units.index') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Tambah Satuan</h2>
            <p class="text-sm text-gray-400">Buat satuan produk baru</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form wire:submit="save" class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Satuan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="name" placeholder="Contoh: Kilogram, Liter, Dus..."
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Singkatan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="abbreviation" placeholder="Contoh: kg, ltr, dus..."
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                @error('abbreviation') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('units.index') }}" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors text-center">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition-colors">
                    <span wire:loading.remove>Simpan Satuan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>