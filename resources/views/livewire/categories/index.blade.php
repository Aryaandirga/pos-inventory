<div>
    {{-- Notifikasi Sukses (DNA: Emerald/Green) --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-sm font-bold flex items-center gap-3 animate-fade-down">
            <div class="w-6 h-6 bg-emerald-500 text-white rounded-lg flex items-center justify-center shadow-sm shadow-emerald-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Kategori Produk</h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Kelola klasifikasi produk inventaris POKE-ART</p>
        </div>
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        
        {{-- Search Bar --}}
        <div class="p-6 border-b border-gray-50 bg-gray-50/30">
            <div class="relative group">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama kategori atau deskripsi..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest w-20">No</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Detail Kategori</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Deskripsi</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Total Produk</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="px-6 py-5">
                            <span class="text-xs font-black text-gray-300 group-hover:text-indigo-300 transition-colors">
                                {{ str_pad($categories->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm shadow-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm text-gray-400 font-medium line-clamp-1 max-w-xs italic">
                                {{ $category->description ?? 'Tidak ada deskripsi tambahan' }}
                            </p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[11px] font-black rounded-full ring-2 ring-indigo-100 shadow-sm shadow-indigo-50">
                                    {{ $category->products->count() }} PRODUK
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="p-2.5 bg-white border border-gray-100 hover:border-amber-200 hover:bg-amber-50 text-amber-500 rounded-xl transition-all shadow-sm active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button wire:click="confirmDelete({{ $category->id }})"
                                        class="p-2.5 bg-white border border-gray-100 hover:border-red-200 hover:bg-red-50 text-red-500 rounded-xl transition-all shadow-sm active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4 border border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-black text-lg">Kategori Kosong</h3>
                                <p class="text-gray-400 text-sm max-w-[240px] mt-1 font-medium">Anda belum menambahkan kategori untuk memisahkan jenis produk.</p>
                                <a href="{{ route('categories.create') }}" class="mt-6 text-indigo-600 font-bold text-sm hover:text-indigo-700 underline underline-offset-4">Tambah Kategori Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (Menggunakan Template Kustom Kita) --}}
        @if($categories->hasPages())
        <div class="px-6 py-6 border-t border-gray-50 bg-gray-50/20">
            {{ $categories->onEachSide(0)->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>

    {{-- Premium Delete Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm animate-fade" wire:click="$set('showDeleteModal', false)"></div>
        <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-sm shadow-2xl relative z-10 animate-scale-up">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 text-center mb-2 tracking-tight">Hapus Kategori?</h3>
            <p class="text-sm text-gray-400 text-center mb-8 font-medium px-4">Tindakan ini permanen. Pastikan tidak ada produk yang masih terhubung dengan kategori ini.</p>
            <div class="flex flex-col gap-3">
                <button wire:click="delete"
                        class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black text-sm rounded-2xl transition-all shadow-lg shadow-red-100 active:scale-95">
                    Ya, Hapus Sekarang
                </button>
                <button wire:click="$set('showDeleteModal', false)"
                        class="w-full py-4 bg-gray-50 hover:bg-gray-100 text-gray-500 font-bold text-sm rounded-2xl transition-all active:scale-95">
                    Batalkan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>