<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('stock-opname.index') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-gray-800">Tambah Penyesuaian Stok</h2>
            <p class="text-sm text-gray-400">Input stock opname manual</p>
        </div>
    </div>

    <form wire:submit="save">
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Form Utama --}}
            <div class="lg:col-span-2 space-y-5">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-black text-gray-800">Detail Penyesuaian</h3>

                    {{-- Produk --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Produk <span class="text-red-500">*</span>
                        </label>
                        <select wire:model.live="product_id"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stok: {{ $product->stock }} {{ $product->unit->abbreviation }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tipe --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Tipe Penyesuaian <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" wire:click="$set('type', 'in')"
                                    class="py-3 text-sm font-bold rounded-xl border-2 transition-all
                                           {{ $type === 'in' ? 'border-green-500 bg-green-50 text-green-600' : 'border-gray-200 text-gray-500 hover:border-gray-300' }}">
                                ↑ Stok Masuk
                            </button>
                            <button type="button" wire:click="$set('type', 'out')"
                                    class="py-3 text-sm font-bold rounded-xl border-2 transition-all
                                           {{ $type === 'out' ? 'border-red-500 bg-red-50 text-red-600' : 'border-gray-200 text-gray-500 hover:border-gray-300' }}">
                                ↓ Stok Keluar
                            </button>
                            <button type="button" wire:click="$set('type', 'adjustment')"
                                    class="py-3 text-sm font-bold rounded-xl border-2 transition-all
                                           {{ $type === 'adjustment' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-200 text-gray-500 hover:border-gray-300' }}">
                                ⚖ Sesuaikan
                            </button>
                        </div>

                        {{-- Keterangan tipe --}}
                        <div class="mt-2 text-xs text-gray-400 bg-gray-50 rounded-lg px-3 py-2">
                            @if($type === 'in')
                                <span class="text-green-600 font-semibold">Stok Masuk:</span> Tambah stok dari hasil produksi atau pembelian tambahan
                            @elseif($type === 'out')
                                <span class="text-red-600 font-semibold">Stok Keluar:</span> Kurangi stok karena rusak, kadaluarsa, atau terpakai
                            @else
                                <span class="text-blue-600 font-semibold">Sesuaikan:</span> Set stok ke angka tertentu sesuai hasil hitung fisik
                            @endif
                        </div>
                    </div>

                    {{-- Qty --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            @if($type === 'adjustment')
                                Stok Aktual (Hasil Hitung Fisik) <span class="text-red-500">*</span>
                            @else
                                Jumlah <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" wire:model.live="qty" min="0"
                                   class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                            @if($productUnit)
                                <span class="text-sm font-semibold text-gray-500 shrink-0">{{ $productUnit }}</span>
                            @endif
                        </div>
                        @error('qty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model="date"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 transition-all">
                        @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Catatan / Alasan <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="notes" rows="3"
                                  placeholder="Contoh: Hasil hitung fisik gudang, Produk kadaluarsa, Produksi batch #123..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none"></textarea>
                        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

            </div>

            {{-- Preview Stok --}}
            <div class="space-y-5">

                {{-- Info Stok --}}
                @if($currentStock !== null)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-black text-gray-800 mb-4">Preview Stok</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Stok Sekarang</span>
                            <span class="text-sm font-black text-gray-800">{{ $currentStock }} {{ $productUnit }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Perubahan</span>
                            @php $diff = $this->getStockDiff(); @endphp
                            <span class="text-sm font-black {{ $diff >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $diff >= 0 ? '+' : '' }}{{ $diff }} {{ $productUnit }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3 bg-indigo-50 rounded-xl px-3">
                            <span class="text-sm font-black text-gray-800">Stok Baru</span>
                            <span class="text-xl font-black text-indigo-600">
                                {{ $this->getNewStock() }} {{ $productUnit }}
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-black text-gray-800 mb-4">Preview Stok</h3>
                    <div class="flex flex-col items-center justify-center h-32 text-center">
                        <svg class="w-10 h-10 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-sm text-gray-400">Pilih produk dulu</p>
                    </div>
                </div>
                @endif

                {{-- Submit --}}
                <div class="flex gap-3">
                    <a href="{{ route('stock-opname.index') }}"
                       class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition-colors">
                        <span wire:loading.remove>Simpan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>