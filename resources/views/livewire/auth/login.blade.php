<x-layouts::auth.simple>

<div x-data="{ tab: 'login' }" class="min-h-screen flex items-center justify-center px-4 py-8" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);">

    {{-- Floating orbs background --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full opacity-20 blur-3xl" style="background: radial-gradient(circle, #6366f1, transparent);"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full opacity-20 blur-3xl" style="background: radial-gradient(circle, #8b5cf6, transparent);"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 rounded-full opacity-10 blur-3xl" style="background: radial-gradient(circle, #ec4899, transparent);"></div>
    </div>

    <div class="w-full max-w-4xl relative z-10" style="animation: fadeUp 0.5s ease both;">

        {{-- Card --}}
        <div class="rounded-3xl overflow-hidden flex shadow-2xl" style="box-shadow: 0 25px 80px rgba(0,0,0,0.5);">

            {{-- ===== LEFT PANEL ===== --}}
            <div class="hidden lg:flex w-5/12 flex-col relative overflow-hidden" style="background: linear-gradient(160deg, #1e1b4b 0%, #0f172a 60%, #1a0533 100%);">

                {{-- Grid pattern overlay --}}
                <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 32px 32px;"></div>

                {{-- Glow orb --}}
                <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full blur-3xl transition-all duration-700"
                         :class="tab === 'register' ? 'opacity-30' : 'opacity-15'"
                         style="background: radial-gradient(circle, #6366f1, transparent);"></div>
                </div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-col h-full p-8">

                    {{-- Logo --}}
                    <div class="flex items-center gap-3 mb-auto">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-black text-white tracking-tight">PokeArth Tech</p>
                            <p class="text-[10px] text-indigo-400 font-medium">Management System</p>
                        </div>
                    </div>

                    {{-- Pokeball --}}
                    <div class="flex items-center justify-center my-8">
                        <div class="relative" style="width:140px;height:140px;">
                            <svg width="140" height="140" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" style="overflow:visible;">

                                {{-- TOP HALF --}}
                                <g :style="tab === 'register'
                                    ? 'transform:translate(80px,80px) rotate(-14deg) translate(-80px,-80px) translateY(-26px); transition:transform 0.5s cubic-bezier(.34,1.56,.64,1);'
                                    : 'transform:translate(0,0); transition:transform 0.5s cubic-bezier(.34,1.56,.64,1);'">
                                    <path d="M4 80 A76 76 0 0 1 156 80 Z" fill="#ef4444"/>
                                    <path d="M4 80 A76 76 0 0 1 156 80 Z" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="2.5"/>
                                    <ellipse cx="52" cy="44" rx="14" ry="5" fill="white" opacity="0.25" transform="rotate(-20 52 44)"/>
                                    <ellipse cx="68" cy="36" rx="6" ry="3" fill="white" opacity="0.15" transform="rotate(-20 68 36)"/>
                                </g>

                                {{-- BOTTOM HALF --}}
                                <g :style="tab === 'register'
                                    ? 'transform:translate(80px,80px) rotate(14deg) translate(-80px,-80px) translateY(26px); transition:transform 0.5s cubic-bezier(.34,1.56,.64,1);'
                                    : 'transform:translate(0,0); transition:transform 0.5s cubic-bezier(.34,1.56,.64,1);'">
                                    <path d="M4 80 A76 76 0 0 0 156 80 Z" fill="rgba(255,255,255,0.9)"/>
                                    <path d="M4 80 A76 76 0 0 0 156 80 Z" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="2.5"/>
                                </g>

                                {{-- OUTER RING --}}
                                <circle cx="80" cy="80" r="76" stroke="rgba(255,255,255,0.25)" stroke-width="2.5" fill="none"/>

                                {{-- MIDDLE LINE --}}
                                <line x1="4" y1="80" x2="156" y2="80"
                                      stroke="rgba(255,255,255,0.3)" stroke-width="2.5"
                                      :style="tab === 'register' ? 'opacity:0;transition:opacity 0.3s' : 'opacity:1;transition:opacity 0.3s'"/>

                                {{-- CENTER BUTTON --}}
                                <circle cx="80" cy="80"
                                    :r="tab === 'register' ? '20' : '14'"
                                    :fill="tab === 'register' ? '#fde047' : 'white'"
                                    stroke="rgba(255,255,255,0.4)" stroke-width="2.5"
                                    style="transition: r 0.4s cubic-bezier(.34,1.56,.64,1), fill 0.4s;"/>
                                <circle cx="80" cy="80"
                                    :r="tab === 'register' ? '11' : '7'"
                                    :fill="tab === 'register' ? '#facc15' : '#e5e7eb'"
                                    style="transition: r 0.4s cubic-bezier(.34,1.56,.64,1), fill 0.4s;"/>

                                {{-- Sparkles saat register --}}
                                <g :style="tab === 'register' ? 'opacity:1;transition:opacity 0.4s 0.2s' : 'opacity:0;transition:opacity 0.2s'">
                                    <circle cx="80" cy="30" r="3" fill="#fde047" opacity="0.8"/>
                                    <circle cx="130" cy="60" r="2" fill="#a78bfa" opacity="0.8"/>
                                    <circle cx="30" cy="60" r="2" fill="#a78bfa" opacity="0.8"/>
                                    <circle cx="115" cy="115" r="2.5" fill="#fde047" opacity="0.6"/>
                                    <circle cx="45" cy="115" r="2.5" fill="#fde047" opacity="0.6"/>
                                </g>

                            </svg>
                        </div>
                    </div>

                    {{-- Tagline --}}
                    <div class="mt-auto">
                        <p class="text-white font-bold text-base leading-snug mb-1"
                           x-text="tab === 'login' ? 'Selamat datang kembali!' : 'Bergabung sekarang!'"></p>
                        <p class="text-indigo-300 text-xs font-medium leading-relaxed">
                            Kelola inventaris & penjualan Pokemon Card dengan mudah dan efisien.
                        </p>

                        {{-- Stats --}}
                        <div class="flex gap-4 mt-5">
                            <div class="flex flex-col">
                                <span class="text-white font-black text-lg leading-none">POS</span>
                                <span class="text-indigo-400 text-[10px] font-medium mt-0.5">Kasir</span>
                            </div>
                            <div class="w-px bg-indigo-800"></div>
                            <div class="flex flex-col">
                                <span class="text-white font-black text-lg leading-none">IMS</span>
                                <span class="text-indigo-400 text-[10px] font-medium mt-0.5">Inventaris</span>
                            </div>
                            <div class="w-px bg-indigo-800"></div>
                            <div class="flex flex-col">
                                <span class="text-white font-black text-lg leading-none">RPT</span>
                                <span class="text-indigo-400 text-[10px] font-medium mt-0.5">Laporan</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== RIGHT PANEL ===== --}}
            <div class="flex-1 bg-white flex flex-col">

                {{-- Mobile logo --}}
                <div class="lg:hidden flex items-center gap-2.5 px-8 pt-7 pb-0">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg width="14" height="14" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-black text-gray-900">PokeArth Tech</span>
                </div>

                <div class="flex-1 flex flex-col justify-center px-8 py-8 max-w-sm mx-auto w-full">

                    {{-- Header --}}
                    <div class="mb-6">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight"
                            x-text="tab === 'login' ? 'Masuk ke akun' : 'Buat akun baru'"></h1>
                        <p class="text-sm text-gray-400 mt-1"
                           x-text="tab === 'login' ? 'Masukkan email dan password kamu' : 'Daftarkan diri untuk mulai menggunakan sistem'"></p>
                    </div>

                    {{-- Tab --}}
                    <div class="flex bg-gray-100 p-1 rounded-2xl mb-6">
                        <button @click="tab='login'"
                            :class="tab==='login' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="flex-1 py-2.5 rounded-xl text-sm transition-all duration-200">
                            Masuk
                        </button>
                        <button @click="tab='register'"
                            :class="tab==='register' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="flex-1 py-2.5 rounded-xl text-sm transition-all duration-200">
                            Daftar
                        </button>
                    </div>

                    {{-- Error --}}
                    @if ($errors->any())
                    <div class="mb-4 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-100 rounded-2xl">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <p class="text-xs text-red-600 font-medium">{{ $errors->first() }}</p>
                    </div>
                    @endif

                    {{-- FORM WRAPPER --}}
                    <div class="relative" style="min-height:300px;">

                        {{-- LOGIN FORM --}}
                        <form x-show="tab==='login'" x-cloak
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0 translate-x-4"
                              x-transition:enter-end="opacity-100 translate-x-0"
                              x-transition:leave="transition ease-in duration-150"
                              x-transition:leave-start="opacity-100 translate-x-0"
                              x-transition:leave-end="opacity-0 -translate-x-4"
                              class="absolute inset-0 space-y-4 overflow-y-auto"
                              method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Email</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="nama@email.com"
                                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Password</label>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-indigo-500 hover:text-indigo-600 font-semibold transition-colors">Lupa password?</a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    <input type="password" name="password"
                                           placeholder="••••••••"
                                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="remember" id="remember"
                                       class="w-4 h-4 rounded border-gray-300 text-indigo-500 focus:ring-indigo-400">
                                <label for="remember" class="text-xs text-gray-500 cursor-pointer">Ingat saya</label>
                            </div>

                            <button type="submit"
                                    class="w-full py-3 rounded-xl text-sm font-bold text-white transition-all duration-200 active:scale-95 flex items-center justify-center gap-2"
                                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 15px rgba(99,102,241,0.4);"
                                    onmouseover="this.style.boxShadow='0 6px 20px rgba(99,102,241,0.5)'"
                                    onmouseout="this.style.boxShadow='0 4px 15px rgba(99,102,241,0.4)'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
                                Masuk Sekarang
                            </button>

                        </form>

                        {{-- REGISTER FORM --}}
                        <form x-show="tab==='register'" x-cloak
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0 translate-x-4"
                              x-transition:enter-end="opacity-100 translate-x-0"
                              x-transition:leave="transition ease-in duration-150"
                              x-transition:leave-start="opacity-100 translate-x-0"
                              x-transition:leave-end="opacity-0 -translate-x-4"
                              class="absolute inset-0 space-y-3 overflow-y-auto pb-1"
                              method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Nama Lengkap</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           placeholder="Nama kamu"
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Email</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="email@example.com"
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Password</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    <input type="password" name="password"
                                           placeholder="Min. 8 karakter (huruf & angka)"
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Konfirmasi Password</label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <input type="password" name="password_confirmation"
                                           placeholder="Ulangi password"
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all">
                                </div>
                            </div>

                            <div class="pt-1">
                                <button type="submit"
                                        class="w-full py-3 rounded-xl text-sm font-bold text-white transition-all duration-200 active:scale-95 flex items-center justify-center gap-2"
                                        style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 15px rgba(99,102,241,0.4);"
                                        onmouseover="this.style.boxShadow='0 6px 20px rgba(99,102,241,0.5)'"
                                        onmouseout="this.style.boxShadow='0 4px 15px rgba(99,102,241,0.4)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                                    Buat Akun
                                </button>
                            </div>

                        </form>

                    </div>

                    {{-- Footer note --}}
                    <p class="text-center text-xs text-gray-400 mt-6">
                        Akun baru akan mendapat role
                        <span class="font-bold text-indigo-500">Guest</span>
                        — hubungi admin untuk upgrade akses.
                    </p>

                </div>
            </div>

        </div>

        {{-- Bottom credit --}}
        <p class="text-center text-xs text-indigo-300/50 mt-4">© 2025 PokeArth Tech · All rights reserved</p>

    </div>

</div>

<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
[x-cloak] { display: none !important; }
</style>

</x-layouts::auth.simple>
