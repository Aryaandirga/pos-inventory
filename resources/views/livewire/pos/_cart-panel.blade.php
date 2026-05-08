{{-- ===== CART PANEL (shared between sidebar and bottom sheet) ===== --}}

{{-- Cart Header --}}
<div class="px-5 py-4 border-b border-gray-100 flex-shrink-0">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Keranjang</p>
                <p class="text-[11px] text-gray-400 font-medium">{{ count($cart) }} item</p>
            </div>
        </div>
        @if(!empty($cart))
        <button wire:click="$set('cart', [])"
                class="text-[11px] font-bold text-red-500 hover:bg-red-50 px-2 py-1 rounded-lg transition-colors">
            Kosongkan
        </button>
        @endif
    </div>
</div>

{{-- Cart Items --}}
<div class="flex-1 overflow-y-auto px-4 py-3 flex flex-col gap-2">
    @forelse($cart as $key => $item)
    <div class="bg-gray-50 rounded-xl px-3 py-2.5">
        <div class="flex items-start justify-between gap-2 mb-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-gray-900 truncate">{{ $item['name'] }}</p>
                <p class="text-[11px] text-indigo-500 font-semibold mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
            </div>
            <button wire:click="removeFromCart('{{ $key }}')"
                    class="w-5 h-5 bg-red-50 hover:bg-red-100 rounded-md flex items-center justify-center flex-shrink-0 transition-colors">
                <svg class="w-2.5 h-2.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1.5">
                <button type="button"
                        wire:click.prevent="updateQty('{{ $key }}', {{ $item['qty'] - 1 }})"
                        class="w-6 h-6 bg-white border border-gray-200 rounded-lg flex items-center justify-center cursor-pointer transition hover:border-indigo-400">
                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                    </svg>
                </button>
                <span class="text-sm font-bold text-gray-900 min-w-[20px] text-center">{{ $item['qty'] }}</span>
                <button type="button"
                        wire:click.prevent="updateQty('{{ $key }}', {{ $item['qty'] + 1 }})"
                        class="w-6 h-6 bg-white border border-gray-200 rounded-lg flex items-center justify-center cursor-pointer transition hover:border-indigo-400">
                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>
            <p class="text-xs font-bold text-gray-700">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
        </div>
    </div>
    @empty
    <div class="flex flex-col items-center justify-center h-40 text-center">
        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-400">Keranjang kosong</p>
        <p class="text-xs text-gray-300 mt-1">Klik produk untuk menambahkan</p>
    </div>
    @endforelse
</div>

{{-- Cart Footer --}}
<div class="px-4 py-3.5 border-t border-gray-100 flex-shrink-0">

    {{-- Discount --}}
    <div class="flex items-center gap-2.5 mb-3">
        <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Diskon</label>
        <div class="relative flex-1">
            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[11px] text-gray-400 font-semibold">Rp</span>
            <input type="number" wire:model.live="discount" min="0"
                   class="w-full pl-7 pr-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none transition focus:border-indigo-400"
                   style="font-family:'Plus Jakarta Sans',sans-serif;">
        </div>
    </div>

    {{-- Summary --}}
    <div class="bg-gray-50 rounded-xl p-3 mb-3">
        <div class="flex justify-between mb-1.5">
            <span class="text-xs text-gray-500 font-medium">Subtotal</span>
            <span class="text-xs font-semibold text-gray-700">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($discount > 0)
        <div class="flex justify-between mb-1.5">
            <span class="text-xs text-gray-500 font-medium">Diskon</span>
            <span class="text-xs font-semibold text-red-500">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="flex justify-between border-t border-gray-200 pt-2 mt-1">
            <span class="text-sm font-bold text-gray-900">Total</span>
            <span class="text-base font-extrabold text-indigo-500">Rp {{ number_format($this->grandTotal, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Pay Button --}}
    <button wire:click="openPayment"
            class="w-full py-3 rounded-xl text-sm font-bold text-white transition-colors flex items-center justify-center gap-2 {{ empty($cart) ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-500 cursor-pointer' }}"
            {{ empty($cart) ? 'disabled' : '' }}
            style="font-family:'Plus Jakarta Sans',sans-serif;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Bayar Sekarang
    </button>
</div>
