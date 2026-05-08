<div>
    {{-- Notifikasi Sukses --}}
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
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Katalog Produk</h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Manajemen stok dan harga inventaris POKE-ART</p>
        </div>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk Baru
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        
        {{-- Filter & Search Bar --}}
        <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row gap-4 bg-gray-50/30">
            <div class="relative flex-1 group">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama produk, SKU, atau kategori..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>
            <div class="relative group">
    <select wire:model.live="filterCategory"
            class="pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 focus:outline-none focus:border-indigo-400 transition-all shadow-sm appearance-none cursor-pointer w-full sm:w-48">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
    
    {{-- Icon Dropdown Custom --}}
    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Detail Produk</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">SKU</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Harga Jual</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-12 flex-shrink-0">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}"
                                             class="w-full h-full rounded-2xl object-cover shadow-sm group-hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-full h-full bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-300 group-hover:bg-indigo-100 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $product->name }}</p>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-5 font-mono text-[11px] text-gray-500 font-bold tracking-tighter">
                            <span class="bg-gray-100 px-2 py-1 rounded-lg">#{{ $product->sku }}</span>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <p class="text-sm font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col items-center">
                                <span class="px-3 py-1 text-[11px] font-black rounded-full shadow-sm
                                    {{ $product->stock <= $product->min_stock 
                                        ? 'bg-red-100 text-red-600 ring-2 ring-red-50' 
                                        : 'bg-emerald-100 text-emerald-600 ring-2 ring-emerald-50' }}">
                                    {{ $product->stock }} {{ $product->unit->abbreviation ?? '' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full border {{ $product->is_active ? 'border-emerald-200 bg-emerald-50' : 'border-gray-200 bg-gray-50' }}">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $product->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                    <span class="text-[10px] font-black uppercase {{ $product->is_active ? 'text-emerald-700' : 'text-gray-500' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="p-2.5 bg-white border border-gray-100 hover:border-amber-200 hover:bg-amber-50 text-amber-500 rounded-xl transition-all shadow-sm active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button wire:click="confirmDelete({{ $product->id }})"
                                        class="p-2.5 bg-white border border-gray-100 hover:border-red-200 hover:bg-red-50 text-red-500 rounded-xl transition-all shadow-sm active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4 border border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-black text-lg">Produk Tidak Ditemukan</h3>
                                <p class="text-gray-400 text-sm max-w-[240px] mt-1 font-medium">Coba gunakan kata kunci lain atau tambah produk baru.</p>
                                <a href="{{ route('products.create') }}" class="mt-6 text-indigo-600 font-bold text-sm hover:text-indigo-700 underline underline-offset-4">Mulai Tambah Produk</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
<div class="px-6 py-6 border-t border-gray-50 bg-gray-50/20">
    {{-- Menggunakan onEachSide(0) akan meminimalkan angka di tengah --}}
    {{ $products->onEachSide(0)->links('vendor.pagination.custom-tailwind') }}
</div>
@endif
    </div>

    {{-- Modal Konfirmasi Hapus (Premium Design) --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm animate-fade" wire:click="$set('showDeleteModal', false)"></div>
        <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-sm shadow-2xl relative z-10 animate-scale-up">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 text-center mb-2 tracking-tight">Hapus Produk?</h3>
            <p class="text-sm text-gray-400 text-center mb-8 font-medium px-4">Tindakan ini permanen. Produk akan dihapus dari inventaris Anda selamanya.</p>
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