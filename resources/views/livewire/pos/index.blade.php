<div x-data="{ cartOpen: false }">
    @if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-semibold">
        {{ session('error') }}
    </div>
    @endif

    {{-- ===== MAIN LAYOUT ===== --}}
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-5 lg:h-[calc(100vh-110px)]">

        {{-- ===== LEFT: Products ===== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Search --}}
            <div class="relative mb-4">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari produk atau scan barcode..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 shadow-sm"
                       style="font-family:'Plus Jakarta Sans',sans-serif;">
            </div>

            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto pr-1">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                    @forelse($products as $product)
                    <button type="button"
                            wire:key="prod-{{ $product->id }}"
                            wire:click="addToCart({{ $product->id }})"
                            class="bg-white border border-gray-200 rounded-xl p-3 text-left cursor-pointer transition-all duration-150 shadow-sm hover:border-indigo-400 hover:shadow-md hover:-translate-y-px active:scale-95">

                        {{-- Image --}}
                        <div class="w-full h-32 sm:h-40 lg:h-48 bg-[#F6F4E8] rounded-lg mb-2.5 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ $product->image_url }}"
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>

                        <p class="text-xs font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</p>
                        <p class="text-[11px] text-gray-400 font-medium mb-1.5">
                            Stok: {{ $product->stock }} {{ $product->unit->abbreviation }}
                        </p>
                        <p class="text-sm font-extrabold text-indigo-500">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </button>
                    @empty
                    <div class="col-span-2 sm:col-span-3 xl:col-span-4 flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3.5">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-400">Tidak ada produk ditemukan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Cart (desktop/tablet sidebar) ===== --}}
        <div class="hidden md:flex w-72 lg:w-80 flex-shrink-0 flex-col bg-white rounded-2xl border border-gray-200 shadow-sm">
            @include('livewire.pos._cart-panel')
        </div>
    </div>

    {{-- ===== MOBILE: Floating cart button ===== --}}
    <div class="md:hidden fixed bottom-5 right-5 z-40">
        <button @click="cartOpen = true"
                class="relative flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-bold text-sm rounded-2xl shadow-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Keranjang
            @if(!empty($cart))
            <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center">
                {{ count($cart) }}
            </span>
            @endif
        </button>
    </div>

    {{-- ===== MOBILE: Cart bottom sheet ===== --}}
    <div x-show="cartOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="cartOpen = false"
         class="md:hidden fixed inset-0 z-50 bg-black/50"
         style="display:none;">
        <div x-show="cartOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl flex flex-col max-h-[85vh] shadow-2xl">

            {{-- Drag handle --}}
            <div class="flex justify-center pt-3 pb-1 flex-shrink-0">
                <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
            </div>

            {{-- Close button --}}
            <div class="flex items-center justify-between px-5 pb-2 flex-shrink-0">
                <span class="text-sm font-bold text-gray-700">Keranjang Belanja</span>
                <button @click="cartOpen = false"
                        class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex flex-col flex-1 min-h-0">
                @include('livewire.pos._cart-panel')
            </div>
        </div>
    </div>

    {{-- ===== PAYMENT MODAL ===== --}}
    @if($showPaymentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/55 p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl" style="animation:fadeUp 0.2s ease both;">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-base font-extrabold text-gray-900">Proses Pembayaran</h3>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Lengkapi data pembayaran</p>
            </div>

            <div class="px-6 py-5 flex flex-col gap-4 overflow-y-auto max-h-[70vh]">

                {{-- Total --}}
                <div class="bg-indigo-50 rounded-xl p-4 text-center">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-black text-indigo-500">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</p>
                </div>

                {{-- Payment Method --}}
                <div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-2">Metode Pembayaran</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['cash' => ['💵','Cash'], 'transfer' => ['🏦','Transfer'], 'qris' => ['📱','QRIS']] as $method => $info)
                        <button type="button"
                                wire:click="$set('paymentMethod', '{{ $method }}')"
                                class="py-2.5 px-2 rounded-xl border-2 text-xs font-bold cursor-pointer transition-all flex flex-col items-center gap-1 {{ $paymentMethod === $method ? 'border-indigo-500 bg-indigo-50 text-indigo-600' : 'border-gray-200 bg-white text-gray-500 hover:border-gray-300' }}"
                                style="font-family:'Plus Jakarta Sans',sans-serif;">
                            <span class="text-lg">{{ $info[0] }}</span>
                            {{ $info[1] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Amount Paid --}}
                <div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mb-2">Jumlah Bayar</p>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-semibold">Rp</span>
                        <input type="number"
                               wire:model.live="amountPaid"
                               class="w-full pl-9 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-lg font-bold text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                               style="font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                </div>

                {{-- Change --}}
                <div class="rounded-xl px-4 py-3 flex justify-between items-center {{ $this->change >= 0 ? 'bg-emerald-50' : 'bg-red-50' }}">
                    <span class="text-sm font-semibold text-gray-700">Kembalian</span>
                    <span class="text-xl font-extrabold {{ $this->change >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        Rp {{ number_format($this->change, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Quick Amount --}}
                @if($paymentMethod === 'cash')
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide mb-2">Uang Pas</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach([50000, 100000, 200000] as $amount)
                        <button type="button"
                                wire:click="$set('amountPaid', {{ $amount }})"
                                class="py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-gray-700 cursor-pointer transition hover:border-indigo-400 hover:text-indigo-600"
                                style="font-family:'Plus Jakarta Sans',sans-serif;">
                            Rp {{ number_format($amount, 0, ',', '.') }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex gap-2.5">
                <button wire:click="$set('showPaymentModal', false)"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-bold text-gray-700 transition-colors"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Batal
                </button>
                <button wire:click="processPayment"
                        class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition-colors {{ $this->amountPaid < $this->grandTotal ? 'bg-gray-400 cursor-not-allowed' : 'bg-emerald-500 hover:bg-emerald-600 cursor-pointer' }}"
                        {{ $this->amountPaid < $this->grandTotal ? 'disabled' : '' }}
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    <span wire:loading.remove>✅ Konfirmasi Bayar</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== SUCCESS MODAL ===== --}}
    @if($showSuccessModal && $lastSale)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/55 p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl" style="animation:fadeUp 0.2s ease both;">

            <div class="px-6 pt-7 pb-5 text-center border-b border-gray-100">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 mb-1">Transaksi Berhasil!</h3>
                <p class="text-xs text-gray-400 font-mono">{{ $lastSale->invoice_no }}</p>
            </div>

            <div class="px-6 py-4 flex flex-col gap-2.5">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Total</span>
                    <span class="text-sm font-semibold text-gray-700">Rp {{ number_format($lastSale->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Bayar ({{ strtoupper($lastSale->payment_method) }})</span>
                    <span class="text-sm font-semibold text-gray-700">Rp {{ number_format($lastSale->amount_paid, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between bg-emerald-50 rounded-xl px-3.5 py-3 mt-1">
                    <span class="text-sm font-bold text-emerald-800">Kembalian</span>
                    <span class="text-lg font-extrabold text-emerald-500">Rp {{ number_format($lastSale->change, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex gap-2.5">
                <button wire:click="closeSuccess"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-bold text-gray-700 transition-colors"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Transaksi Baru
                </button>
                <button wire:click="printReceipt"
                        class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-bold text-white transition-colors flex items-center justify-center gap-1.5"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== PRINT MODAL ===== --}}
    @if($showPrintModal && $lastSale)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/55 p-4">
        <div class="bg-white rounded-2xl w-full max-w-[300px] shadow-2xl">

            <div id="receipt" class="px-5 py-5">

                {{-- Receipt Header --}}
                <div class="text-center mb-3.5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center mx-auto mb-2"
                         style="background:linear-gradient(135deg,#6366F1,#8B5CF6);">
                        <svg class="w-4.5 h-4.5 text-white" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h2 style="font-size:14px;font-weight:800;color:#111827;margin:0;">PokeArth Tech</h2>
                    <p style="font-size:10px;color:#9CA3AF;margin:2px 0 0;">Management System</p>
                    <div style="border-top:1.5px dashed #E5E7EB;margin:10px 0;padding-top:10px;">
                        <p style="font-size:10px;color:#6366F1;font-family:'DM Mono',monospace;font-weight:500;margin:0;">{{ $lastSale->invoice_no }}</p>
                        <p style="font-size:10px;color:#6B7280;margin:3px 0 0;">{{ \Carbon\Carbon::parse($lastSale->date)->format('d M Y') }} · {{ $lastSale->created_at->format('H:i') }}</p>
                        <p style="font-size:10px;color:#9CA3AF;margin:2px 0 0;">Kasir: {{ auth()->user()->name }}</p>
                    </div>
                </div>

                {{-- Items --}}
                <div style="border-top:1.5px dashed #E5E7EB;padding:10px 0;display:flex;flex-direction:column;gap:7px;">
                    @foreach($lastSale->items as $item)
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#111827;margin:0;">{{ $item->product->name }}</p>
                        <div style="display:flex;justify-content:space-between;margin-top:2px;">
                            <span style="font-size:10px;color:#9CA3AF;">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <span style="font-size:10px;font-weight:700;color:#374151;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div style="border-top:1.5px dashed #E5E7EB;padding-top:10px;display:flex;flex-direction:column;gap:5px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Subtotal</span>
                        <span style="font-size:10px;color:#374151;">Rp {{ number_format($lastSale->total, 0, ',', '.') }}</span>
                    </div>
                    @if($lastSale->discount > 0)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Diskon</span>
                        <span style="font-size:10px;color:#EF4444;">- Rp {{ number_format($lastSale->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;margin-top:4px;padding-top:6px;border-top:1px solid #F3F4F6;">
                        <span style="font-size:12px;font-weight:800;color:#111827;">TOTAL</span>
                        <span style="font-size:12px;font-weight:800;color:#6366F1;">Rp {{ number_format($lastSale->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">{{ strtoupper($lastSale->payment_method) }}</span>
                        <span style="font-size:10px;color:#374151;">Rp {{ number_format($lastSale->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:10px;color:#9CA3AF;">Kembalian</span>
                        <span style="font-size:10px;font-weight:700;color:#10B981;">Rp {{ number_format($lastSale->change, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="border-top:1.5px dashed #E5E7EB;margin-top:10px;padding-top:10px;text-align:center;">
                    <p style="font-size:10px;color:#6B7280;font-weight:600;margin:0;">Terima kasih atas pembelian Anda!</p>
                    <p style="font-size:9px;color:#D1D5DB;margin:4px 0 0;">Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="px-5 pb-5 flex gap-2.5">
                <button wire:click="closePrint"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-bold text-gray-700 transition-colors"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Tutup
                </button>
                <button onclick="window.print()"
                        class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-bold text-white transition-colors flex items-center justify-center gap-1.5"
                        style="font-family:'Plus Jakarta Sans',sans-serif;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </div>
    @endif

    <script>
        window.addEventListener('close-print-modal', () => {
            @this.call('closePrint');
        });
    </script>
</div>
