<div class="max-w-7xl mx-auto">
    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="mb-6 px-5 py-4 bg-emerald-50 border border-emerald-100 rounded-[1.5rem] text-emerald-700 text-sm font-bold flex items-center gap-3 shadow-sm animate-fade-in">
            <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Manajemen User</h2>
            <p class="text-sm text-gray-400 mt-1">Kelola akses, role, dan akun pengguna sistem</p>
        </div>
        @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('users.create') }}"
           class="flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-2xl transition-all shadow-xl shadow-indigo-100 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah User Baru
        </a>
        @endif
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        {{-- Toolbar --}}
        <div class="p-6 border-b border-gray-50 bg-gray-50/30">
            <div class="relative group max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama atau email user..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all shadow-sm placeholder:text-gray-300">
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Informasi User</th>
                        <th class="px-8 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Akses Role</th>
                        <th class="px-8 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100 transition-transform group-hover:scale-110">
                                        <span class="text-white text-lg font-black uppercase">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    @if($user->id === auth()->id())
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center shadow-sm" title="Sedang Aktif">
                                            <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-800 leading-tight">{{ $user->name }}</p>
                                    <p class="text-xs font-medium text-gray-400 mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                    @php
                                        $roleStyle = match($role->name) {
                                            'admin'  => 'bg-purple-100 text-purple-700 ring-purple-200',
                                            'kasir'  => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                            'gudang' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                            default  => 'bg-gray-100 text-gray-600 ring-gray-200',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 {{ $roleStyle }} text-[10px] font-black rounded-lg uppercase tracking-tighter ring-1 ring-inset">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="p-2.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-all cursor-pointer" title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <button wire:click="confirmDelete({{ $user->id }})"
                                        class="p-2.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all cursor-pointer" title="Hapus User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-4 text-gray-200">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <p class="text-sm font-black text-gray-400">Tidak ada user ditemukan</p>
                                <p class="text-xs text-gray-300 mt-1">Coba gunakan kata kunci pencarian lain</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-8 py-6 border-t border-gray-50 bg-gray-50/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- Modern Delete Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-0">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDeleteModal', false)"></div>
        
        <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-sm shadow-2xl relative z-10 animate-scale-up">
            <div class="w-20 h-20 bg-red-50 rounded-[2rem] flex items-center justify-center mb-6 mx-auto shadow-inner">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-black text-gray-800 text-center mb-2 tracking-tight">Hapus Pengguna?</h3>
            <p class="text-sm text-gray-400 text-center mb-8 px-4">Akses user ini akan segera dicabut dan data tidak dapat dipulihkan.</p>
            
            <div class="flex flex-col gap-3">
                <button wire:click="delete"
                        class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black text-sm rounded-2xl transition-all shadow-xl shadow-red-100 active:scale-95">
                    Ya, Hapus Permanen
                </button>
                <button wire:click="$set('showDeleteModal', false)"
                        class="w-full py-4 bg-gray-50 hover:bg-gray-100 text-gray-500 font-bold text-sm rounded-2xl transition-all active:scale-95">
                    Batalkan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    @keyframes scale-up {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-scale-up { animation: scale-up 0.2s ease-out forwards; }
</style>