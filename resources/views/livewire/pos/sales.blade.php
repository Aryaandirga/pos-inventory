<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-black text-gray-800">Riwayat Penjualan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Semua transaksi POS</p>
        </div>
        <a href="{{ route('pos.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Buka POS
        </a>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-3">
            <div class="relative flex-1 min-w-48">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari no. invoice..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-400 transition-all">
            </div>
            <div class="flex items-center gap-2">
                <input type="date" wire:model.live="dateFrom"
                       class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-400 transition-all">
                <span class="text-gray-400 text-sm">—</span>
                <input type="date" wire:model.live="dateTo"
                       class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-400 transition-all">
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kasir</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pembayaran</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($sales as $sale)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-xs font-mono font-semibold text-gray-700">{{ $sale->invoice_no }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}
                        <span class="text-xs text-gray-300 block">{{ $sale->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $sale->user->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full">
                            {{ $sale->items->count() }} item
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase">
                            {{ $sale->payment_method }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-black text-gray-800 text-right">
                        Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button wire:click="showDetail({{ $sale->id }})"
                                class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-bold rounded-lg transition-colors">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Belum ada transaksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($sales->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $sales->links() }}</div>
        @endif
    </div>

    {{-- Detail Modal --}}
    @if($showDetail && $selectedSale)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-gray-800">Detail Transaksi</h3>
                    <p class="text-xs text-gray-400 font-mono mt-0.5">{{ $selectedSale->invoice_no }}</p>
                </div>
                <button wire:click="$set('showDetail', false)"
                        class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Info --}}
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Tanggal</p>
                        <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($selectedSale->date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Kasir</p>
                        <p class="font-semibold text-gray-700">{{ $selectedSale->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Pembayaran</p>
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase">
                            {{ $selectedSale->payment_method }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Status</p>
                        <span class="px-2.5 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-full">
                            Selesai
                        </span>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <div class="px-6 py-4 border-b border-gray-100 max-h-60 overflow-y-auto">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Item Pembelian</p>
                <div class="space-y-2">
                    @foreach($selectedSale->items as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->qty }} {{ $item->product->unit->abbreviation ?? '' }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-black text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary --}}
            <div class="px-6 py-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($selectedSale->total, 0, ',', '.') }}</span>
                </div>
                @if($selectedSale->discount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Diskon</span>
                    <span class="font-semibold text-red-500">- Rp {{ number_format($selectedSale->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm border-t border-gray-100 pt-2">
                    <span class="font-black text-gray-800">Total</span>
                    <span class="font-black text-indigo-600">Rp {{ number_format($selectedSale->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Bayar</span>
                    <span class="font-semibold">Rp {{ number_format($selectedSale->amount_paid, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kembalian</span>
                    <span class="font-semibold text-green-600">Rp {{ number_format($selectedSale->change, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                <button wire:click="$set('showDetail', false)"
                        class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>