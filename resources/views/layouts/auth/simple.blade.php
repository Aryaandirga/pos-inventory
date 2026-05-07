<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data :class="{ 'dark': $store.theme.dark }">
    <head>
        @include('partials.head')
        <script>
        function applyTheme() {
            const theme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');
            if (iconSun) iconSun.classList.toggle('hidden', theme !== 'dark');
            if (iconMoon) iconMoon.classList.toggle('hidden', theme === 'dark');
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');
            if (iconSun) iconSun.classList.toggle('hidden', next !== 'dark');
            if (iconMoon) iconMoon.classList.toggle('hidden', next === 'dark');
        }

        // Run on first load
        applyTheme();

        // Run after every Livewire navigation
        document.addEventListener('livewire:navigated', applyTheme);
    </script>
    </head>
    <body class="min-h-screen antialiased">
       
            
            <!-- Toggle Button -->
            <div class="fixed top-4 right-4">
                <button onclick="toggleTheme()" class="btn btn-ghost btn-circle">
                    <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                    </svg>
                </button>
            </div>

            <div class="min-h-screen w-full">
    {{ $slot }}
</div>
            </div>
        </div>

        <script>
            function toggleTheme() {
                const html = document.documentElement;
                const current = html.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                updateIcon(next);
            }

            function updateIcon(theme) {
                document.getElementById('icon-sun').classList.toggle('hidden', theme !== 'dark');
                document.getElementById('icon-moon').classList.toggle('hidden', theme === 'dark');
            }

            // Set icon on load
            updateIcon(document.documentElement.getAttribute('data-theme'));
        </script>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        <script>
document.addEventListener('livewire:navigated', () => {
    if (window.Alpine) {
        Alpine.initTree(document.body)
    }
})
</script>

@fluxScripts
</body>
</html>

        @fluxScripts
    </body>
</html>