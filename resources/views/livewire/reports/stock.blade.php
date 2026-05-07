<div class="w-full px-4 sm:px-6 lg:px-10 py-10">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter">Laporan Stok Barang</h2>
            <p class="text-sm text-gray-400">Analisis ketersediaan dan valuasi inventaris secara real-time</p>
        </div>
        
        {{-- Export Actions --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('export.stock.excel') }}"
               class="flex items-center gap-3 px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-[13px] font-black rounded-2xl transition-all shadow-xl shadow-emerald-100 active:scale-95 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                EXPORT EXCEL
            </a>
            <a href="{{ route('export.stock.pdf') }}"
               class="flex items-center gap-3 px-6 py-4 bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-black rounded-2xl transition-all shadow-xl shadow-rose-100 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0013 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                CETAK PDF
            </a>
        </div>
    </div>

    {{-- Summary Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        {{-- Total Produk --}}
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Produk</p>
            <p class="text-3xl font-black text-gray-900 mt-2 tracking-tighter leading-none">{{ number_format($totalProducts, 0, ',', '.') }}</p>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em]">Stok Menipis</p>
            <p class="text-3xl font-black text-amber-600 mt-2 tracking-tighter leading-none">{{ number_format($lowStock, 0, ',', '.') }}</p>
        </div>

        {{-- Stok Habis --}}
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm transition-all hover:shadow-md group">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <p class="text-[10px] font-black text-rose-600 uppercase tracking-[0.2em]">Stok Habis</p>
            <p class="text-3xl font-black text-rose-600 mt-2 tracking-tighter leading-none">{{ number_format($outOfStock, 0, ',', '.') }}</p>
        </div>

        {{-- Valuasi Stok --}}
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 shadow-2xl shadow-indigo-100 transition-all hover:translate-y-[-5px]">
            <div class="w-12 h-12 bg-white/20 text-white rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-[10px] font-black text-indigo-100 uppercase tracking-[0.2em]">Valuasi Stok</p>
            <p class="text-2xl font-black text-white mt-2 tracking-tight leading-tight">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Filter Toolbar --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="p-6 flex flex-col md:flex-row gap-4 bg-gray-50/30">
            {{-- Search Bar --}}
            <div class="relative flex-1 group">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama produk atau SKU..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>

            {{-- Category Filter --}}
            <div class="relative group min-w-[200px]">
                <select wire:model.live="filterCategory"
                        class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 focus:outline-none focus:border-indigo-400 transition-all shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            {{-- Stock Status Filter --}}
            <div class="relative group min-w-[200px]">
                <select wire:model.live="filterStock"
                        class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 focus:outline-none focus:border-indigo-400 transition-all shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Status Stok</option>
                    <option value="safe">Stok Aman</option>
                    <option value="low">Stok Menipis</option>
                    <option value="out">Stok Habis</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Table Card --}}
    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.25em]">Detail Produk</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.25em]">Kategori</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] text-center">Status Stok</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] text-right">Modal</th>
                        <th class="px-10 py-7 text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] text-right">Total Valuasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        {{-- Produk --}}
                        <td class="px-10 py-7">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-black text-gray-900 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $product->name }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-mono font-bold bg-gray-100 text-gray-500 px-2 py-0.5 rounded-md tracking-tighter">{{ $product->sku }}</span>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase italic">/ {{ $product->unit->abbreviation }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-7 py-7">
                            <span class="px-3 py-1 bg-gray-50 text-[10px] font-black text-gray-500 rounded-lg uppercase tracking-wider">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>

                        {{-- Status & Stok --}}
                        <td class="px-10 py-7">
    @php
        // Menentukan status berdasarkan stok vs min_stock
        $status = $product->stock == 0 ? 'out' : ($product->stock <= $product->min_stock ? 'low' : 'safe');
        
        // Mapping warna sesuai DNA desain POKE-ART
        $pillClasses = [
            'out'  => 'bg-rose-100 text-rose-600',
            'low'  => 'bg-amber-100 text-amber-600',
            'safe' => 'bg-emerald-100 text-emerald-600',
        ][$status];
    @endphp

    <div class="flex flex-col items-center ">
        {{-- Pill Status Tanpa Icon --}}
        <span class="px-4 py-1.5 rounded-full text-[11px] font-black  {{ $pillClasses }}">
            {{ $product->stock }} {{ $product->unit->abbreviation }}
        </span>
        
        {{-- Informasi Batas Minimum --}}
        <span class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.1em]">
            Batas Min: {{ $product->min_stock }}
        </span>
    </div>
</td>

                        {{-- Harga Modal --}}
                        <td class="px-7 py-7 text-right">
                            <p class="text-xs font-bold text-gray-400">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</p>
                        </td>

                        {{-- Valuasi --}}
                        <td class="px-10 py-7 text-right">
                            <span class="text-sm font-black text-gray-900 bg-gray-50 px-4 py-2 rounded-2xl">
                                Rp {{ number_format($product->stock * $product->cost_price, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-28 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-50 rounded-[3rem] flex items-center justify-center mb-6 text-gray-200">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="text-sm font-black text-gray-400 tracking-widest uppercase">Inventaris Kosong</p>
                                <p class="text-xs font-bold text-gray-300 mt-2">Data stok tidak ditemukan dalam kriteria ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-50">
            {{ $products->onEachSide(0)->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>
</div>