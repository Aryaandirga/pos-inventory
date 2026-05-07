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
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Purchase Order</h2>
            <p class="text-sm text-gray-400 mt-1 font-medium">Kelola stok masuk dan pesanan ke supplier</p>
        </div>
        <a href="{{ route('purchases.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Buat PO Baru
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        
        {{-- Filter & Search Bar --}}
        <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex flex-col sm:flex-row gap-4">
            <div class="relative group flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nomor PO atau nama supplier..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>
            <div class="relative group">
    <select wire:model.live="filterStatus"
            class="pl-6 pr-12 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm appearance-none cursor-pointer min-w-[180px] w-full">
        <option value="">Semua Status</option>
        <option value="pending">⏳ Pending</option>
        <option value="received">✅ Diterima</option>
        <option value="cancelled">❌ Dibatalkan</option>
    </select>
    
    {{-- Icon Chevron Down --}}
    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
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
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">No. PO</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Supplier</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Total Transaksi</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($purchases as $po)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg group-hover:bg-white transition-colors">
                                #{{ $po->po_number }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-gray-800">{{ $po->supplier->name }}</div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-0.5">Supplier Partner</div>
                        </td>
                        <td class="px-6 py-5 text-sm font-medium text-gray-500">
                            {{ \Carbon\Carbon::parse($po->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-5 text-sm font-black text-gray-900">
                            Rp {{ number_format($po->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $statusStyle = match($po->status) {
                                    'pending'   => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'received'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'cancelled' => 'bg-red-50 text-red-500 border-red-100',
                                    default     => 'bg-gray-50 text-gray-500 border-gray-100'
                                };
                                $statusLabel = match($po->status) {
                                    'pending'   => 'Pending',
                                    'received'  => 'Diterima',
                                    'cancelled' => 'Dibatalkan',
                                    default     => $po->status
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 border {{ $statusStyle }} text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('purchases.show', $po) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 text-indigo-600 text-xs font-extrabold rounded-xl transition-all shadow-sm active:scale-95 group/btn">
                                    <span>Detail</span>
                                    <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-4 border border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <h3 class="text-gray-900 font-black text-lg">Belum Ada Transaksi</h3>
                                <p class="text-gray-400 text-sm max-w-[240px] mt-1 font-medium">Data Purchase Order akan muncul di sini setelah Anda membuat pesanan stok.</p>
                                <a href="{{ route('purchases.create') }}" class="mt-6 text-indigo-600 font-bold text-sm hover:text-indigo-700 underline underline-offset-4">Buat PO Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
       @if($purchases->hasPages())
        <div class="px-6 py-6 border-t border-gray-50 bg-gray-50/20">
            {{-- Menggunakan onEachSide(0) dan vendor view yang sama dengan Produk --}}
            {{ $purchases->onEachSide(0)->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>
</div>