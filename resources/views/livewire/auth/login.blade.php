<x-layouts::auth.simple>

<div x-data="{ tab: 'login' }" class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex">

        <!-- LEFT -->
        <div class="hidden lg:flex w-1/2 items-center justify-center relative flex-col gap-6"
             style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 50%, #eef2ff 100%);">

            <!-- Title -->
            <div class="absolute top-8 text-center">
                <p class="text-lg font-black text-gray-800 tracking-tight">PokeArth Tech</p>
                <p class="text-xs text-gray-500 mt-0.5">Management System</p>
            </div>

            <!-- Glow -->
            <div class="absolute inset-0 pointer-events-none transition-all duration-500"
                 :class="tab === 'register' ? 'opacity-100 scale-110' : 'opacity-0 scale-100'"
                 style="background: radial-gradient(circle at center, rgba(34,197,94,0.25) 0%, transparent 70%);">
            </div>

            <!-- Pokeball -->
            <div class="relative flex items-center justify-center"
                 :class="tab === 'register' ? 'scale-105' : 'scale-100'"
                 style="width:160px;height:210px; transition: all 0.4s;">

                <svg width="160" height="210" viewBox="0 -25 160 210" fill="none"
                     xmlns="http://www.w3.org/2000/svg" style="overflow:visible;">

                    <!-- TOP -->
                    <g :class="tab === 'register' ? 'top-open' : 'top-close'"
                       style="transform-origin:center; transition: all 0.5s cubic-bezier(.34,1.56,.64,1);">
                        <path d="M4 80 A76 76 0 0 1 156 80 Z" fill="#ef4444"/>
                        <path d="M4 80 A76 76 0 0 1 156 80 Z" fill="none" stroke="#374151" stroke-width="3"/>
                        <ellipse cx="52" cy="44" rx="13" ry="5" fill="white" opacity="0.3"
                                 transform="rotate(-20 52 44)"/>
                    </g>

                    <!-- BOTTOM -->
                    <g :class="tab === 'register' ? 'bottom-open' : 'bottom-close'"
                       style="transform-origin:center; transition: all 0.5s cubic-bezier(.34,1.56,.64,1);">
                        <path d="M4 80 A76 76 0 0 0 156 80 Z" fill="#ffffff"/>
                        <path d="M4 80 A76 76 0 0 0 156 80 Z" fill="none" stroke="#374151" stroke-width="3"/>
                    </g>

                    <!-- OUTER -->
                    <circle cx="80" cy="80" r="76" stroke="#374151" stroke-width="3" fill="none"/>

                    <!-- LINE -->
                    <line x1="4" y1="80" x2="156" y2="80"
                          stroke="#374151" stroke-width="3"
                          :class="tab === 'register' ? 'opacity-0' : 'opacity-100 transition-all duration-300'" />

                    <!-- BUTTON -->
                    <circle cx="80" cy="80"
                            :r="tab === 'register' ? '18' : '13'"
                            :fill="tab === 'register' ? '#fde047' : '#ffffff'"
                            :opacity="tab === 'register' ? '0' : '1'"
                            stroke="#374151"
                            stroke-width="3"
                            style="transition: all 0.3s;" />

                    <!-- INNER -->
                    <circle cx="80" cy="80"
                            :r="tab === 'register' ? '10' : '6'"
                            :fill="tab === 'register' ? '#facc15' : '#e5e7eb'"
                            :opacity="tab === 'register' ? '0' : '1'"
                            style="transition: all 0.3s;" />

                </svg>
            </div>

            <!-- Bottom text -->
            <div class="absolute bottom-8 text-center">
                <p class="text-sm font-semibold text-gray-700 transition-all duration-300"
                   x-text="tab === 'login' ? 'Masuk ke akunmu' : 'Buat akun baru'"></p>
                <p class="text-xs text-gray-400 mt-1">Pokemon Card POS</p>
            </div>
        </div>

        <!-- RIGHT -->
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
                        class="w-1/2 py-2 rounded-xl text-sm transition">
                        Login
                    </button>
                    <button @click="tab='register'"
                        :class="tab==='register' ? 'bg-white shadow text-gray-800 font-semibold' : 'text-gray-400'"
                        class="w-1/2 py-2 rounded-xl text-sm transition">
                        Register
                    </button>
                </div>

                <!-- FORM -->
                <div class="relative flex-1" style="min-height:380px;">

                    <!-- LOGIN -->
                    <form x-show="tab==='login'" x-cloak
                        x-transition
                        class="space-y-4 absolute inset-0 overflow-y-auto"
                        method="POST"
                        action="{{ route('login.store') }}">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="text-xs text-gray-600">Email</label>
                            <input type="email" name="email"
                                class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-green-200">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs text-gray-600">Password</label>
                            <input type="password" name="password"
                                class="w-full px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-green-200">
                        </div>

                        <button class="w-full bg-gray-900 text-white py-2.5 rounded-xl text-sm font-semibold">
                            Log in
                        </button>
                    </form>

                    <!-- REGISTER -->
                    <form x-show="tab==='register'" x-cloak
                        x-transition
                        class="space-y-3 absolute inset-0 overflow-y-auto"
                        method="POST"
                        action="{{ route('register') }}">
                        @csrf

                        <input type="text" name="name" placeholder="Nama"
                            class="w-full px-3 py-2 border rounded-xl text-sm">

                        <input type="email" name="email" placeholder="Email"
                            class="w-full px-3 py-2 border rounded-xl text-sm">

                        <input type="password" name="password" placeholder="Password"
                            class="w-full px-3 py-2 border rounded-xl text-sm">

                        <button class="w-full bg-green-500 text-white py-2.5 rounded-xl text-sm font-semibold">
                            Register
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>

</div>

<!-- CSS ANIMATION -->
<style>
.top-open { transform: translateY(-28px) rotate(-14deg); }
.top-close { transform: translateY(0) rotate(0); }

.bottom-open { transform: translateY(28px) rotate(14deg); }
.bottom-close { transform: translateY(0) rotate(0); }
</style>

</x-layouts::auth.simple>