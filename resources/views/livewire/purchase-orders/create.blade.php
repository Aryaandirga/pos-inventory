<div class="max-w-5xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('purchases.index') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Buat Purchase Order</h2>
            <p class="text-sm text-gray-400">Order barang dari supplier</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- KIRI: Info PO --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Header PO --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-black text-gray-800 mb-4">Informasi PO</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Supplier <span class="text-red-500">*</span></label>
                            <select wire:model="supplier_id"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="date"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Catatan</label>
                        <textarea wire:model="notes" rows="2" placeholder="Catatan tambahan..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all resize-none"></textarea>
                    </div>
                </div>

                {{-- Items --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-gray-800">Item Produk</h3>
                        <button type="button" wire:click="addItem"
                                class="flex items-center gap-2 px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-bold rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Item
                        </button>
                    </div>

                    <div class="space-y-3">
                        {{-- Header --}}
                        <div class="grid grid-cols-12 gap-2 px-2">
                            <div class="col-span-5 text-xs font-bold text-gray-400 uppercase">Produk</div>
                            <div class="col-span-2 text-xs font-bold text-gray-400 uppercase">Qty</div>
                            <div class="col-span-3 text-xs font-bold text-gray-400 uppercase">Harga</div>
                            <div class="col-span-2 text-xs font-bold text-gray-400 uppercase">Subtotal</div>
                        </div>

                        @foreach($items as $index => $item)
                        <div class="grid grid-cols-12 gap-2 items-center bg-gray-50 rounded-xl p-3">
                            <div class="col-span-5">
                                <select wire:model.live="items.{{ $index }}.product_id"
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit->abbreviation }})</option>
                                    @endforeach
                                </select>
                                @error("items.{$index}.product_id") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-2">
                                <input type="number" wire:model.live="items.{{ $index }}.qty" min="1"
                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                                @error("items.{$index}.qty") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-3">
                                <input type="number" wire:model.live="items.{{ $index }}.price" min="0"
                                       class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                                @error("items.{$index}.price") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-1 text-sm font-semibold text-gray-700 text-right">
                                {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                            <div class="col-span-1 flex justify-end">
                                @if(count($items) > 1)
                                <button type="button" wire:click="removeItem({{ $index }})"
                                        class="w-7 h-7 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- KANAN: Summary --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-black text-gray-800 mb-4">Ringkasan</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Total Item</span>
                            <span class="font-semibold text-gray-800">{{ count($items) }} item</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-black text-gray-800">Total</span>
                            <span class="font-black text-indigo-600 text-lg">
                                Rp {{ number_format($this->getTotal(), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button type="submit"
                                class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition-colors">
                            <span wire:loading.remove>Buat Purchase Order</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                        <a href="{{ route('purchases.index') }}"
                           class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors text-center block">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>