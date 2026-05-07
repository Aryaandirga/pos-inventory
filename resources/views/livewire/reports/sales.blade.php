<div class="w-full px-4 sm:px-6 lg:px-10 py-10">
    {{-- Header Section: Kita samakan padding & alignment-nya --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter">Laporan Penjualan</h2>
            <p class="text-sm text-gray-400">Pantau dan rekap seluruh transaksi penjualan sistem secara real-time</p>
        </div>
        
        {{-- Tombol Export: Tetap menggunakan style Anda --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('export.sales.excel', [$dateFrom, $dateTo, $filterPayment]) }}"
               class="flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-emerald-100 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
            <a href="{{ route('export.sales.pdf', [$dateFrom, $dateTo, $filterPayment]) }}"
               class="flex items-center gap-2 px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-rose-100 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0013 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Cetak PDF
            </a>
        </div>
    </div>

    {{-- Filter Toolbar --}}
<div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-3 mb-10">
    <div class="flex flex-col lg:flex-row items-center gap-4">
        
        {{-- Dari Tanggal --}}
        <div class="flex-1 w-full relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-400">
                <span class="text-[9px] font-black uppercase tracking-widest">DARI</span>
            </div>
            <input type="date" wire:model.live="dateFrom"
                   class="w-full pl-16 pr-6 py-4 bg-gray-50/50 border-none rounded-[1.8rem] text-sm font-bold text-gray-600 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition-all [color-scheme:light]">
        </div>
            <span class="text-gray-300 font-bold px-1 text-xs">—</span>
        {{-- Sampai Tanggal --}}
        <div class="flex-1 w-full relative group">
            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-gray-400">
                <span class="text-[9px] font-black uppercase tracking-widest">HINGGA</span>
            </div>
            <input type="date" wire:model.live="dateTo"
                   class="w-full pl-20 pr-6 py-4 bg-gray-50/50 border-none rounded-[1.8rem] text-sm font-bold text-gray-600 focus:bg-white focus:ring-4 focus:ring-indigo-50 transition-all [color-scheme:light]">
        </div>

       {{-- Metode Bayar (Button Dropdown Style) --}}
<div class="w-full lg:w-72 relative group">
    <select wire:model.live="filterPayment"
            class="w-full pl-8 pr-12 py-4 bg-white border border-gray-200 rounded-[1.8rem] text-sm font-black text-gray-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm appearance-none cursor-pointer tracking-tight uppercase">
        <option value="">Semua Metode</option>
        <option value="cash">💵 Tunai (Cash)</option>
        <option value="transfer">🏦 Transfer Bank</option>
        <option value="qris">📱 QRIS / E-Wallet</option>
    </select>
    
    {{-- Icon Panah Dropdown di Sisi Kanan --}}
    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4 h-4 transition-transform group-focus-within:rotate-180" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24" 
             stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</div>

    </div>
</div>

    {{-- Summary Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Transaksi</p>
            <p class="text-3xl font-black text-gray-800 tracking-tighter">{{ number_format($totalTrx, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Diskon</p>
            <p class="text-3xl font-black text-rose-500 tracking-tighter">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</p>
        </div>

        <div class="bg-indigo-600 rounded-[2rem] p-8 shadow-2xl shadow-indigo-100">
            <p class="text-[11px] font-black text-indigo-100 uppercase tracking-widest mb-1">Total Pendapatan</p>
            <p class="text-3xl font-black text-white tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Report Table: Menjaga Tabel Asli Anda tetap utuh --}}
    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest">Invoice / Tanggal</th>
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest">Kasir</th>
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Items</th>
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Pembayaran</th>
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Diskon</th>
                        <th class="px-10 py-7 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Grand Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-10 py-7">
                            <p class="text-xs font-mono font-black text-indigo-600 tracking-tighter uppercase">{{ $sale->invoice_no }}</p>
                            <p class="text-[11px] font-medium text-gray-400 mt-1">{{ \Carbon\Carbon::parse($sale->date)->format('d F Y') }}</p>
                        </td>
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] font-black text-gray-500 uppercase">
                                    {{ substr($sale->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $sale->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-7 text-center">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg ring-1 ring-indigo-100 uppercase">
                                {{ $sale->items->count() }} Item
                            </span>
                        </td>
                        <td class="px-10 py-7 text-center">
                            @php
                                $payStyle = match(strtolower($sale->payment_method)) {
                                    'cash' => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
                                    'transfer' => 'bg-blue-50 text-blue-600 ring-blue-100',
                                    'qris' => 'bg-purple-50 text-purple-600 ring-purple-100',
                                    default => 'bg-gray-50 text-gray-500 ring-gray-100'
                                };
                            @endphp
                            <span class="px-3 py-1 {{ $payStyle }} text-[10px] font-black rounded-lg ring-1 uppercase">
                                {{ $sale->payment_method }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
                            @if($sale->discount > 0)
                                <span class="text-xs font-bold text-rose-500">- Rp {{ number_format($sale->discount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-10 py-7 text-right">
                            <p class="text-sm font-black text-gray-800">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                    @empty
                    {{-- Empty State Asli Anda --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>