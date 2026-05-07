<x-layouts::auth.simple>

<div x-data="{ tab: 'login' }" class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex">

        <!-- LEFT: Pokeball Animation -->
        <div class="hidden lg:flex w-1/2 bg-linear-to-br from-rose-200 via-amber-100 to-sky-200 items-center justify-center overflow-hidden relative">

            <!-- Background glow saat register -->
            <div
                class="absolute inset-0 transition-all duration-700"
                :class="tab === 'register' ? 'opacity-100' : 'opacity-0'"
                style="background: radial-gradient(circle at center, rgba(255,220,80,0.35) 0%, transparent 70%);"
            ></div>

            <!-- Pokeball Container -->
            <div class="relative w-36 h-36">

                <!-- Lingkaran luar (shadow/border) -->
                <div class="absolute inset-0 rounded-full border-4 border-black z-30 pointer-events-none"></div>

                <!-- TOP HALF: Merah -->
                <div
                    class="absolute top-0 left-0 w-full h-1/2 bg-red-400 border-4 border-black rounded-t-full overflow-hidden transition-all duration-500 ease-in-out z-20"
                    :class="tab === 'register' ? '-translate-y-6 rotate-[-8deg]' : 'translate-y-0 rotate-0'"
                >
                    <!-- Kilap -->
                    <div class="absolute top-2 left-5 w-8 h-3 bg-white opacity-20 rounded-full rotate-[-20deg]"></div>
                </div>

                <!-- GARIS TENGAH -->
                <div
                    class="absolute top-1/2 left-0 w-full h-1.25 bg-black z-30 transition-all duration-500"
                    :class="tab === 'register' ? 'opacity-0' : 'opacity-100'"
                    style="transform: translateY(-50%);"
                ></div>

                <!-- TOMBOL TENGAH -->
                <div
                    class="absolute top-1/2 left-1/2 z-40 transition-all duration-500 ease-in-out"
                    :class="tab === 'register'
                        ? 'w-10 h-10 bg-yellow-200 border-4 border-black -translate-x-1/2 -translate-y-1/2 scale-110'
                        : 'w-7 h-7 bg-white border-4 border-black -translate-x-1/2 -translate-y-1/2 scale-100'"
                    style="border-radius: 50%;"
                ></div>

                <!-- BOTTOM HALF: Putih -->
                <div
                    class="absolute bottom-0 left-0 w-full h-1/2 bg-white border-4 border-black rounded-b-full transition-all duration-500 ease-in-out z-20"
                    :class="tab === 'register' ? 'translate-y-6 rotate-[8deg]' : 'translate-y-0 rotate-0'"
                ></div>

            </div>

            <!-- Label bawah -->
            <div class="absolute bottom-8 text-center transition-all duration-300">
                <p
                    class="text-sm font-semibold text-gray-600 transition-all duration-300"
                    x-text="tab === 'login' ? 'Masuk ke akunmu' : 'Buat akun baru'"
                ></p>
                <p class="text-xs text-gray-400 mt-1">Pokemon Card POS</p>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="w-full lg:w-1/2 p-8">
            <div class="max-w-sm mx-auto space-y-5">

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

                <!-- FORM WRAPPER -->
                <div class="relative min-h-[360px] overflow-hidden">

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
                        class="space-y-4 absolute w-full will-change-transform"
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
                        class="space-y-3 absolute w-full will-change-transform"
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
                                placeholder="••••••••">
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