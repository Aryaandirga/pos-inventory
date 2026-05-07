<div class="max-w-2xl mx-auto pb-12">
    {{-- Header & Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('users.index') }}"
           class="group w-11 h-11 bg-white border border-gray-100 rounded-2xl flex items-center justify-center transition-all shadow-sm hover:shadow-md hover:border-indigo-100 active:scale-95">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Tambah User</h2>
            <p class="text-sm text-gray-400 mt-0.5">Daftarkan akun pengguna baru ke dalam sistem</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden p-8">
        <form wire:submit="save" class="space-y-6">

            {{-- Input Nama --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <input type="text" wire:model="name" placeholder="Masukkan nama lengkap..."
                           class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-gray-700 text-sm font-semibold focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all placeholder:text-gray-300 placeholder:font-normal">
                </div>
                @error('name') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            {{-- Input Email --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" wire:model="email" placeholder="contoh: arya@pos.com"
                       class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-gray-700 text-sm font-semibold focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all placeholder:text-gray-300 placeholder:font-normal">
                @error('email') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            {{-- Input Password --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Password Keamanan <span class="text-red-500">*</span></label>
                <input type="password" wire:model="password" placeholder="Gunakan minimal 6 karakter"
                       class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-gray-700 text-sm font-semibold focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all placeholder:text-gray-300 placeholder:font-normal">
                @error('password') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            {{-- Select Role --}}
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1">Pilih Hak Akses <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <select wire:model="role"
                            class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-gray-700 text-sm font-bold focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all appearance-none cursor-pointer">
                        <option value="">Pilih Role User</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                @error('role') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            {{-- Role Info Badges --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-purple-50/50 border border-purple-100 rounded-2xl p-4 transition-all hover:shadow-md hover:shadow-purple-50">
                    <div class="w-8 h-8 bg-purple-500 rounded-xl flex items-center justify-center text-white mb-2 shadow-lg shadow-purple-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <p class="text-[10px] font-black text-purple-600 uppercase tracking-wider mb-0.5">Admin</p>
                    <p class="text-[9px] text-purple-400 leading-tight">Kontrol penuh sistem & pengaturan</p>
                </div>
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-4 transition-all hover:shadow-md hover:shadow-emerald-50">
                    <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center text-white mb-2 shadow-lg shadow-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-wider mb-0.5">Kasir</p>
                    <p class="text-[9px] text-emerald-400 leading-tight">Transaksi POS & riwayat penjualan</p>
                </div>
                <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-4 transition-all hover:shadow-md hover:shadow-amber-50">
                    <div class="w-8 h-8 bg-amber-500 rounded-xl flex items-center justify-center text-white mb-2 shadow-lg shadow-amber-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-wider mb-0.5">Gudang</p>
                    <p class="text-[9px] text-amber-400 leading-tight">Manajemen stok & inventaris barang</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4 pt-6">
                <a href="{{ route('users.index') }}"
                   class="flex-1 py-4 bg-gray-50 hover:bg-gray-100 text-gray-500 font-black text-sm rounded-2xl transition-all text-center active:scale-95">
                    Batalkan
                </a>
                <button type="submit"
                        class="flex-[2] py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm rounded-2xl transition-all shadow-xl shadow-indigo-100 active:scale-95 flex items-center justify-center gap-2">
                    <span wire:loading.remove class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Akun Baru
                    </span>
                    <span wire:loading class="animate-pulse">Sedang Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>