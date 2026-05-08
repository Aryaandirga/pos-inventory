<x-layouts::auth.simple>

<div x-data="{ tab: 'login' }" class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex">

        <!-- LEFT: Pokeball Animation -->
        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-rose-200 via-amber-100 to-sky-200 items-center justify-center overflow-hidden relative">

            <!-- Background glow saat register -->
            <div
                class="absolute inset-0 transition-all duration-700"
                :class="tab === 'register' ? 'opacity-100' : 'opacity-0'"
                style="background: radial-gradient(circle at center, rgba(255,220,80,0.35) 0%, transparent 70%);"
            ></div>

            <!-- Pokeball Container -->
            <div class="relative flex items-center justify-center" style="width:160px;height:160px;">

                <!-- SVG Pokeball static state (login) -->
                <svg x-show="tab==='login'" width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute transition-all duration-500">
                    <!-- Top half red -->
                    <path d="M80 4 A76 76 0 0 1 156 80 L80 80 Z" fill="#f87171" stroke="#000" stroke-width="4"/>
                    <path d="M80 4 A76 76 0 0 0 4 80 L80 80 Z" fill="#f87171" stroke="#000" stroke-width="4"/>
                    <!-- Bottom half white -->
                    <path d="M4 80 A76 76 0 0 0 156 80 L80 80 Z" fill="#fff" stroke="#000" stroke-width="4"/>
                    <!-- Outer circle -->
                    <circle cx="80" cy="80" r="76" stroke="#000" stroke-width="4" fill="none"/>
                    <!-- Middle line -->
                    <line x1="4" y1="80" x2="156" y2="80" stroke="#000" stroke-width="4"/>
                    <!-- Center button -->
                    <circle cx="80" cy="80" r="14" fill="#fff" stroke="#000" stroke-width="4"/>
                    <!-- Shine on top -->
                    <ellipse cx="55" cy="42" rx="14" ry="6" fill="white" opacity="0.2" transform="rotate(-20 55 42)"/>
                </svg>

                <!-- SVG Pokeball open state (register) -->
                <svg x-show="tab==='register'" x-cloak width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute transition-all duration-500">
                    <!-- Top half red - moved up -->
                    <g transform="translate(80,80) rotate(-8) translate(-80,56)">
                        <path d="M80 4 A76 76 0 0 1 156 80 L80 80 Z" fill="#f87171" stroke="#000" stroke-width="4"/>
                        <path d="M80 4 A76 76 0 0 0 4 80 L80 80 Z" fill="#f87171" stroke="#000" stroke-width="4"/>
                        <path d="M4 80 L156 80" stroke="#000" stroke-width="4"/>
                        <ellipse cx="55" cy="42" rx="14" ry="6" fill="white" opacity="0.2" transform="rotate(-20 55 42)"/>
                    </g>
                    <!-- Bottom half white - moved down -->
                    <g transform="translate(80,80) rotate(8) translate(-80,104)">
                        <path d="M4 80 A76 76 0 0 0 156 80 L80 80 Z" fill="#fff" stroke="#000" stroke-width="4"/>
                        <path d="M4 80 L156 80" stroke="#000" stroke-width="4"/>
                    </g>
                    <!-- Center button yellow -->
                    <circle cx="80" cy="80" r="18" fill="#fef08a" stroke="#000" stroke-width="4"/>
                </svg>

            </div>

            <!-- Label bawah -->
            <div class="absolute bottom-8 text-center">
                <p class="text-sm font-semibold text-gray-600 transition-all duration-300"
                   x-text="tab === 'login' ? 'Masuk ke akunmu' : 'Buat akun baru'"></p>
                <p class="text-xs text-gray-400 mt-1">Pokemon Card POS</p>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="w-full lg:w-1/2 p-8 flex flex-col">
            <div class="max-w-sm mx-auto w-full space-y-5 flex flex-col flex-1">

                <!-- HEADER -->
                <div class="text-center space-y-1">
                    <h2 class="text-xl font-bold text-gray-800">Welcome back!</h2>
                    <p class="text-xs text-gray-400">Enter your login details</p>
                </div>

                <!-- TAB -->
                <div class="flex bg-gray-100 p-1 rounded-xl">
                    <button @click="tab='login'"
                        :class="tab==='login' ? 'bg-white shadow text-gray-800 font-semibold' : 'text-gray-400'"
                        class="w-1/2 py-2 rounded-xl text-sm transition-all duration-200">
                        Login
                    </button>
                    <button @click="tab='register'"
                        :class="tab==='register' ? 'bg-white shadow text-gray-800 font-semibold' : 'text-gray-400'"
                        class="w-1/2 py-2 rounded-xl text-sm transition-all duration-200">
                        Register
                    </button>
                </div>

                <!-- FORM WRAPPER — fixed height, scroll jika overflow -->
                <div class="relative flex-1" style="min-height:380px;">

                    <!-- LOGIN FORM -->
                    <form
                        x-show="tab==='login'"
                        x-cloak
                        x-transition:enter="transform transition duration-300 ease-in-out"
                        x-transition:enter-start="-translate-x-full opacity-0"
                        x-transition:enter-end="translate-x-0 opacity-100"
                        x-transition:leave="transform transition duration-300 ease-in-out"
                        x-transition:leave-start="translate-x-0 opacity-100"
                        x-transition:leave-end="translate-x-full opacity-0"
                        class="space-y-4 absolute inset-0 will-change-transform overflow-y-auto"
                        method="POST"
                        action="{{ route('login.store') }}"
                    >
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-600 text-xs px-3 py-2 rounded-lg">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition-all"
                                placeholder="admin@pos.com">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Password</label>
                            <input type="password" name="password"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 transition-all"
                                placeholder="••••••••">
                        </div>

                        <div class="flex justify-between items-center text-xs text-gray-400">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-rose-400">
                                <span>Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-rose-400 hover:text-rose-500 transition">Forgot?</a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full bg-gray-900 hover:bg-black text-white py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-lg">
                            Log in
                        </button>
                    </form>

                    <!-- REGISTER FORM -->
                    <form
                        x-show="tab==='register'"
                        x-cloak
                        x-transition:enter="transform transition duration-300 ease-in-out"
                        x-transition:enter-start="translate-x-full opacity-0"
                        x-transition:enter-end="translate-x-0 opacity-100"
                        x-transition:leave="transform transition duration-300 ease-in-out"
                        x-transition:leave-start="translate-x-0 opacity-100"
                        x-transition:leave-end="-translate-x-full opacity-0"
                        class="space-y-3 absolute inset-0 will-change-transform overflow-y-auto pb-1"
                        method="POST"
                        action="{{ route('register') }}"
                    >
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-600 text-xs px-3 py-2 rounded-lg">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                                placeholder="Nama kamu">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                                placeholder="email@example.com">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Password</label>
                            <input type="password" name="password"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                                placeholder="Min. 8 karakter (huruf & angka)">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-600">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-3.5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                                placeholder="••••••••">
                        </div>

                        <button type="submit"
                            class="w-full bg-sky-400 hover:bg-sky-500 text-white py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-lg">
                            Daftar Sekarang
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>

</div>

</x-layouts::auth.simple>
