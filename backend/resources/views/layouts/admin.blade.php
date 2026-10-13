<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') · Packaging Supplies Admin</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback so the design renders without a build step (npm run build) --}}
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="min-h-screen">

        {{-- ============ Mobile overlay ============ --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

        {{-- ============ Sidebar ============ --}}
        <aside id="sidebar"
            class="fixed min-h-screen left-0 z-50 flex w-60 -translate-x-full flex-col bg-slate-900 text-slate-300 transition-transform duration-200 lg:translate-x-0">

            {{-- Brand --}}
            <div class="flex h-16 shrink-0 items-center gap-3 border-b border-white/10 px-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-500 text-white shadow-lg shadow-indigo-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                        <path d="M4 7.5l8 4.5 8-4.5" />
                        <path d="M12 12v9" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-white">Packaging Supplies</p>
                    <p class="text-xs text-slate-400">Admin Console</p>
                </div>
                <button type="button" id="sidebar-close" aria-label="Close menu"
                    class="ml-auto flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white/10 hover:text-white lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5">

                {{-- Overview --}}
                <div>
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Overview</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7.5" height="7.5" rx="1.5" />
                            <rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5" />
                            <rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5" />
                            <rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5" />
                        </svg>
                        Dashboard
                    </a>
                </div>

                {{-- Shops --}}
                <div>
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Shops</p>
                    <a href="{{ route('admin.owners') }}"
                        class="{{ request()->routeIs('admin.owners') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="8" r="3.5" />
                            <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                            <path d="M16 5.2a3.5 3.5 0 010 6.6" />
                            <path d="M18 14.6c2 1 3.3 3 3.3 5.4" />
                        </svg>
                        Shop Owners
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                            <path d="M4 7.5l8 4.5 8-4.5" />
                            <path d="M12 12v9" />
                        </svg>
                        Products
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h8l8 8-6 6-8-8V4z" />
                            <circle cx="9" cy="9" r="1.5" />
                        </svg>
                        Categories
                    </a>
                </div>

                {{-- Transactions --}}
                <div>
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Transactions</p>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2.5" y="6" width="19" height="12" rx="2" />
                            <circle cx="12" cy="12" r="2.5" />
                            <path d="M6 12h.01M18 12h.01" />
                        </svg>
                        Sales
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 16l1.5 3.5A2 2 0 006.3 21h11.4a2 2 0 001.8-1.5L21 16" />
                            <path d="M12 3v10m0 0l-4-4m4 4l4-4" />
                        </svg>
                        Purchases
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 3h16v18l-2-1.5L16 21l-2-1.5L12 21l-2-1.5L8 21l-2-1.5L4 21V3z" />
                            <path d="M8 8h8M8 12h8" />
                        </svg>
                        Expenses
                    </a>
                </div>

                {{-- System --}}
                <div>
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">System</p>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3.5" />
                            <path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9l2.1 2.1M17 17l2.1 2.1M19.1 4.9L17 7M7 17l-2.1 2.1" />
                        </svg>
                        Settings
                    </a>
                </div>
            </nav>
            <div class="flex items-center gap-3 rounded-xl bg-white/5 px-3 py-2">
                    {{-- Replace "Site Owner" with {{ auth()->user()->name }} once auth is wired --}}
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-500 text-sm font-semibold text-white">SO</div>
                    <div class="min-w-0 flex-1 leading-tight">
                        <p class="truncate text-sm font-semibold text-white">Site Owner</p>
                        <p class="truncate text-xs text-slate-400">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" title="Sign out"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white/10 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                                <path d="M16 17l5-5-5-5" />
                                <path d="M21 12H9" />
                            </svg>
                        </button>
                    </form>
                </div>
        </aside>

        {{-- ============ Main column ============ --}}
        <div class="flex min-h-screen flex-col lg:pl-60">

            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-4 border-b border-slate-200 bg-white/80 px-4 backdrop-blur sm:px-6">
                <button type="button" id="sidebar-toggle" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="min-w-0">
                    <h1 class="truncate text-base font-semibold text-slate-900">@yield('title', 'Dashboard')</h1>
                    <p class="hidden text-xs text-slate-500 sm:block">@yield('subtitle', 'Welcome back to your admin console')</p>
                </div>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">
                    <div class="relative hidden md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M20 20l-3.5-3.5" />
                        </svg>
                        <input type="search" placeholder="Search…"
                            class="h-9 w-56 rounded-lg border border-slate-200 bg-slate-50 pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    </div>

                    <button type="button" class="relative rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9a6 6 0 1112 0c0 5 2 6 2 6H4s2-1 2-6z" />
                            <path d="M10 20a2 2 0 004 0" />
                        </svg>
                        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </button>

                    <div class="hidden h-6 w-px bg-slate-200 sm:block"></div>

                    <div class="flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-sm font-semibold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'Site Owner', 0, 1)) }}</div>
                        <div class="hidden leading-tight lg:block">
                            <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name ?? 'Site Owner' }}</p>
                            <p class="text-xs text-slate-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            <footer class="shrink-0 border-t border-slate-200 px-6 py-4 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Packaging Supplies Admin. All rights reserved.
            </footer>
        </div>
    </div>

    {{-- Mobile sidebar toggle --}}
{{-- Mobile sidebar toggle --}}
<script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('sidebar-close');

        const open = () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // 👈 Mobile မှာ နောက်ခံမ scrolling ဖြစ်အောင် တားရန်
        };

        const close = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // 👈 ပိတ်လိုက်ရင် မူလအတိုင်း ပြန်ပြင်ရန်
        };

        toggle.addEventListener('click', () => {
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                close();
            } else {
                open();
            }
        });

        overlay.addEventListener('click', close);
        if (closeBtn) closeBtn.addEventListener('click', close);
    })();
</script>
</body>
</html>
