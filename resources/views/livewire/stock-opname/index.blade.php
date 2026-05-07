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
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Stock Opname</h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Log riwayat penyesuaian dan audit stok produk</p>
        </div>
        <a href="{{ route('stock-opname.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Penyesuaian
        </a>
    </div>

    <div> {{-- SATU-SATUNYA PEMBUNGKUS UTAMA --}}
    
    {{-- Filter Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 mb-8 bg-gray-50/30">
        <div class="flex flex-wrap items-center gap-4">
            
            {{-- 1. Search Produk --}}
            <div class="relative flex-1 min-w-[280px] group">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama produk..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>

            {{-- 2. Type Filter --}}
            <div class="relative group">
                <select wire:model.live="filterType"
                        class="pl-6 pr-12 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm appearance-none cursor-pointer min-w-[160px]">
                    <option value="">Semua Tipe</option>
                    <option value="in">📦 Stok Masuk</option>
                    <option value="out">📤 Stok Keluar</option>
                    <option value="adjustment">⚖️ Penyesuaian</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            {{-- 3. Date Range dengan Icon Calendar --}}
            <div class="flex items-center gap-3 bg-white px-4 py-2 border border-gray-200 rounded-[1.25rem] shadow-sm hover:border-indigo-200 transition-all">
                {{-- Date From --}}
                <div class="flex items-center gap-2 group cursor-pointer relative">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input type="date" wire:model.live="dateFrom"
                           class="bg-transparent text-[11px] font-bold text-gray-600 focus:outline-none cursor-pointer border-none p-0 focus:ring-0 [color-scheme:light]">
                </div>
                
                <span class="text-gray-300 font-bold px-1 text-xs">—</span>
                
                {{-- Date To --}}
                <div class="flex items-center gap-2 group cursor-pointer relative">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input type="date" wire:model.live="dateTo"
                           class="bg-transparent text-[11px] font-bold text-gray-600 focus:outline-none cursor-pointer border-none p-0 focus:ring-0 [color-scheme:light]">
                </div>
            </div>

            {{-- 4. Tombol Tampilkan Semua --}}
            @if($dateFrom || $dateTo || $search || $filterType)
                <button type="button" 
                        wire:click="$set('dateFrom', null); $set('dateTo', null); $set('search', ''); $set('filterType', '');"
                        class="flex items-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-black rounded-2xl transition-all active:scale-95 uppercase tracking-wider shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tampilkan Semua
                </button>
            @endif

        </div>
    </div>

    {{-- STYLE DIPINDAHKAN KE DALAM PEMBUNGKUS UTAMA --}}
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            cursor: pointer;
            opacity: 0;
        }
    </style>

</div> {{-- AKHIR PEMBUNGKUS UTAMA --}}
       
   
    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Informasi Produk</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Tipe</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Qty</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Catatan</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($adjustments as $adj)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="px-6 py-5">
                            <span class="text-sm font-bold text-gray-500">
                                {{ \Carbon\Carbon::parse($adj->date)->translatedFormat('d M Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-[10px] group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                    {{ $adj->product->unit->abbreviation ?? 'Unit' }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $adj->product->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">ID: #{{ $adj->product_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $typeStyle = match($adj->type) {
                                    'in'         => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'out'        => 'bg-red-50 text-red-600 border-red-100',
                                    'adjustment' => 'bg-sky-50 text-sky-600 border-sky-100',
                                    default      => 'bg-gray-50 text-gray-500 border-gray-100'
                                };
                                $typeLabel = match($adj->type) {
                                    'in'         => '↑ Masuk',
                                    'out'        => '↓ Keluar',
                                    'adjustment' => '⚖ Penyesuaian',
                                    default      => $adj->type
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 border {{ $typeStyle }} text-[10px] font-black uppercase tracking-wider rounded-full">
                                {{ $typeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-black {{ $adj->type === 'out' ? 'text-red-500' : 'text-emerald-600' }}">
                                {{ $adj->type === 'out' ? '-' : '+' }}{{ number_format($adj->qty, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm text-gray-400 font-medium line-clamp-1 max-w-[150px]" title="{{ $adj->notes }}">
                                {{ $adj->notes ?? '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <span class="text-xs font-extrabold text-gray-700 bg-gray-100 px-2 py-1 rounded-lg">
                                {{ $adj->user->name }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-4 border border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-black text-lg">Belum Ada Data Log</h3>
                                <p class="text-gray-400 text-sm max-w-[240px] mt-1 font-medium">Semua penyesuaian stok manual akan tercatat secara otomatis di sini.</p>
                                <a href="{{ route('stock-opname.create') }}" class="mt-6 text-indigo-600 font-bold text-sm hover:text-indigo-700 underline underline-offset-4">Buat Log Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($adjustments->hasPages())
        <div class="px-6 py-6 border-t border-gray-50 bg-gray-50/20">
            {{ $adjustments->onEachSide(0)->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>
</div>