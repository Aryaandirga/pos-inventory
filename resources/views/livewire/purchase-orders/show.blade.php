<div>
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('purchases.index') }}"
               class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-black text-gray-800">{{ $purchaseOrder->po_number }}</h2>
                <p class="text-sm text-gray-400">Detail Purchase Order</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        @if($purchaseOrder->status === 'pending')
        <div class="flex gap-3">
            <button wire:click="cancel"
                    class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold rounded-xl transition-colors">
                Batalkan PO
            </button>
            <button wire:click="$set('showReceiveModal', true)"
                    class="px-4 py-2.5 bg-green-600 hover:bg-green-500 text-white text-sm font-bold rounded-xl transition-colors">
                ✅ Terima Barang
            </button>
        </div>
        @endif
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Detail PO --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-gray-800 mb-4">Informasi PO</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Supplier</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $purchaseOrder->supplier->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Tanggal</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($purchaseOrder->date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Dibuat Oleh</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $purchaseOrder->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Status</p>
                        @php
                            $statusColor = match($purchaseOrder->status) {
                                'pending'   => 'bg-yellow-50 text-yellow-600',
                                'received'  => 'bg-green-50 text-green-600',
                                'cancelled' => 'bg-red-50 text-red-500',
                            };
                            $statusLabel = match($purchaseOrder->status) {
                                'pending'   => 'Pending',
                                'received'  => 'Diterima',
                                'cancelled' => 'Dibatalkan',
                            };
                        @endphp
                        <span class="px-2.5 py-1 {{ $statusColor }} text-xs font-bold rounded-full">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    @if($purchaseOrder->notes)
                    <div class="col-span-2">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Catatan</p>
                        <p class="text-sm text-gray-600">{{ $purchaseOrder->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Items --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-black text-gray-800">Item Produk</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($purchaseOrder->items as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->qty }} {{ $item->product->unit->abbreviation }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Summary --}}
        <div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-gray-800 mb-4">Ringkasan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Item</span>
                        <span class="font-semibold">{{ $purchaseOrder->items->count() }} item</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between">
                        <span class="font-black text-gray-800">Total</span>
                        <span class="font-black text-indigo-600 text-lg">
                            Rp {{ number_format($purchaseOrder->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Receive Modal --}}
    @if($showReceiveModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center mb-4 mx-auto">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-lg font-black text-gray-800 text-center mb-2">Terima Barang?</h3>
            <p class="text-sm text-gray-400 text-center mb-6">Stok semua produk dalam PO ini akan otomatis bertambah!</p>
            <div class="flex gap-3">
                <button wire:click="$set('showReceiveModal', false)"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors">Batal</button>
                <button wire:click="receive"
                        class="flex-1 py-2.5 bg-green-600 hover:bg-green-500 text-white font-bold text-sm rounded-xl transition-colors">Ya, Terima!</button>
            </div>
        </div>
    </div>
    @endif
</div>