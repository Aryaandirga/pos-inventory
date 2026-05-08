<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'POS Inventory' }} — POKE-ART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F0F2F5;
            color: #111827;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: #111827;
            width: 240px;
        }
        .sidebar-logo-wrap {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-app-name {
            font-size: 13px; font-weight: 800;
            color: #F9FAFB; letter-spacing: 0.3px;
        }
        .sidebar-app-sub {
            font-size: 10px; color: #6B7280;
            margin-top: 1px;
        }

        /* User chip */
        .sidebar-user {
            margin: 14px 16px;
            padding: 10px 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-avatar {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, #6366F1, #8B5CF6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-size: 12px; font-weight: 600; color: #E5E7EB;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-email {
            font-size: 10px; color: #6B7280;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* Nav */
        .nav-section-label {
            font-size: 9.5px; font-weight: 700;
            color: #4B5563; letter-spacing: 1px;
            text-transform: uppercase;
            padding: 18px 20px 6px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 12px; margin: 1px 10px;
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: #9CA3AF;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.06); color: #E5E7EB; }
        .nav-link.active {
            background: rgba(99,102,241,0.15);
            color: #A5B4FC;
        }
        .nav-link.active svg { color: #818CF8; }
        .nav-link svg { width: 15px; height: 15px; flex-shrink: 0; opacity: 0.7; }
        .nav-link.active svg { opacity: 1; }

        /* Logout */
        .sidebar-logout {
            margin: 0 10px 14px;
        }
        .sidebar-logout button {
            width: 100%;
            display: flex; align-items: center; gap: 9px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: #EF4444;
            background: none; border: none; cursor: pointer;
            transition: background 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sidebar-logout button:hover { background: rgba(239,68,68,0.1); }
        .sidebar-logout svg { width: 15px; height: 15px; }

        /* ── Header ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
            height: 54px;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-title {
            font-size: 14px; font-weight: 700; color: #111827;
        }
        .topbar-date {
            font-size: 12px; color: #9CA3AF; font-weight: 500;
        }

        /* ── Main ── */
        .main-content {
            padding: 28px 28px;
        }

        @media print {
            body > *:not(#print-area) { display: none !important; }
            #print-area { display: block !important; position: fixed; top: 0; left: 0; width: 80mm; }
        }
    </style>
</head>

<body>
<div style="display:flex; min-height:100vh;">

    <!-- Overlay mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         style="position:fixed;inset:0;z-index:20;background:rgba(0,0,0,0.5);"
         class="lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="sidebar fixed top-0 left-0 z-30 h-full flex flex-col transition-transform duration-300">

        <!-- Logo -->
        <div class="sidebar-logo-wrap">
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <div class="sidebar-logo-icon">
                    <svg width="16" height="16" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <div class="sidebar-app-name">PokeArth Tech</div>
                    <div class="sidebar-app-sub">Management System</div>
                </div>
            </a>
        </div>

        <!-- User -->
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div style="min-width:0;">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-email">{{ auth()->user()->email }}</div>
            </div>
        </div>

        <!-- Nav -->
        <nav style="flex:1;overflow-y:auto;padding-bottom:8px;">

            <div class="nav-section-label">Main</div>

            {{-- Dashboard: semua role --}}
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>

            {{-- POS/Kasir: admin, kasir --}}
            @if(auth()->user()->hasAnyRole(['admin', 'kasir']))
            <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                POS / Kasir
            </a>
            @endif

            {{-- Riwayat Penjualan: admin, kasir --}}
            @if(auth()->user()->hasAnyRole(['admin', 'kasir']))
            <a href="{{ route('pos.sales') }}" class="nav-link {{ request()->routeIs('pos.sales') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Riwayat Penjualan
            </a>
            @endif

            {{-- Inventory: admin, gudang, guest (read-only) — tidak untuk kasir --}}
            @unless(auth()->user()->hasRole('kasir'))
            <div class="nav-section-label">Inventory</div>

            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk
            </a>
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Kategori
            </a>
            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                Supplier
            </a>
            <a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                Satuan
            </a>
            <a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Purchase Order
            </a>
            <a href="{{ route('stock-opname.index') }}" class="nav-link {{ request()->routeIs('stock-opname.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Stock Opname
            </a>
            @endunless

            {{-- Laporan: semua role --}}
            <div class="nav-section-label">Laporan</div>

            {{-- Laporan Penjualan: admin, kasir --}}
            @if(auth()->user()->hasAnyRole(['admin', 'kasir']))
            <a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Laporan Penjualan
            </a>
            @endif

            {{-- Laporan Stok: semua role --}}
            <a href="{{ route('reports.stock') }}" class="nav-link {{ request()->routeIs('reports.stock') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                Laporan Stok
            </a>

            {{-- Pengguna: semua role bisa lihat, tapi hanya admin yang bisa create/edit --}}
            @if(auth()->user()->hasAnyRole(['admin', 'kasir', 'gudang', 'guest']))
            <div class="nav-section-label">Pengaturan</div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengguna
            </a>
            @endif

        </nav>

        <!-- Logout -->
        <div style="border-top:1px solid rgba(255,255,255,0.07);" class="sidebar-logout pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- Main -->
    <div class="flex-1 lg:ml-[240px] flex flex-col min-h-screen">

        <!-- Topbar -->
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden" style="background:none;border:none;cursor:pointer;color:#6B7280;padding:4px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>
            </div>
            <span class="topbar-date">{{ now()->translatedFormat('d F Y') }}</span>
        </header>

        <!-- Content -->
        <main class="flex-1 main-content">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

    </div>

</div>

@livewireScripts

<div id="print-area" style="display:none;"></div>
<script>
function printReceipt() {
    const receipt = document.getElementById('receipt');
    if (!receipt) return;
    const printArea = document.getElementById('print-area');
    printArea.innerHTML = receipt.innerHTML;
    printArea.style.display = 'block';
    window.print();
    printArea.style.display = 'none';
    printArea.innerHTML = '';
}
</script>
@stack('scripts')
</body>
</html>