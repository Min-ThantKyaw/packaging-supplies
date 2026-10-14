@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Platform overview for all shop owners')

@section('content')
    {{-- Page actions --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Good day, Admin 👋</h2>
            <p class="text-sm text-slate-500">Here's what's happening across your shops today.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="#"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4" />
                    <path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                Export
            </a>
            <a href="#"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Add Shop Owner
            </a>
        </div>
    </div>

    {{-- ============ Stat cards ============ --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Sellers</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">128</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="8" r="3.5" />
                        <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                        <path d="M16 5.2a3.5 3.5 0 010 6.6" />
                        <path d="M18 14.6c2 1 3.3 3 3.3 5.4" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">All registered sellers</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Active Shops</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">112</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12l4-4 4 4 5-5 5 5" />
                        <path d="M3 19h18" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Currently active shops</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Products</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">4,392</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                        <path d="M4 7.5l8 4.5 8-4.5" />
                        <path d="M12 12v9" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Across all shops</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Ks 84.2M</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2.5" y="6" width="19" height="12" rx="2" />
                        <circle cx="12" cy="12" r="2.5" />
                        <path d="M6 12h.01M18 12h.01" />
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Completed sales</p>
        </div>
    </div>

    {{-- ============ Revenue chart + Low stock ============ --}}
    <div class="mt-6 grid grid-cols-1 gap-4 xl:grid-cols-3">
        {{-- Revenue overview --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-slate-900">Revenue Overview</h3>
                    <p class="text-xs text-slate-500">Last 6 months · completed sales</p>
                </div>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">Ks</span>
            </div>

            <div class="flex h-56 items-end gap-3 sm:gap-5">
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">8.2M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 45%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Jan</span>
                </div>
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">10.4M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 58%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Feb</span>
                </div>
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">9.1M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 50%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Mar</span>
                </div>
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">14.7M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 82%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Apr</span>
                </div>
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">16.3M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 92%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">May</span>
                </div>
                <div class="group flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 opacity-0 transition group-hover:opacity-100">25.5M</span>
                    <div class="flex w-full flex-1 items-end">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition group-hover:from-indigo-700 group-hover:to-indigo-500" style="height: 100%"></div>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Jun</span>
                </div>
            </div>
        </div>

        {{-- Low stock alerts --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Low Stock Alerts</h3>
                <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-600">3</span>
            </div>

            <div class="flex items-center gap-3 border-b border-slate-100 py-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 9v4m0 4h.01" />
                        <path d="M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-slate-800">Clear Tape 48mm</p>
                    <p class="truncate text-xs text-slate-500">SKU-TAPE-48 · 48mm</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-rose-600">4</p>
                    <p class="text-[11px] text-slate-400">left</p>
                </div>
            </div>

            <div class="flex items-center gap-3 border-b border-slate-100 py-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 9v4m0 4h.01" />
                        <path d="M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-slate-800">Bubble Wrap Roll</p>
                    <p class="truncate text-xs text-slate-500">SKU-BUB-100 · 100m</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-rose-600">2</p>
                    <p class="text-[11px] text-slate-400">left</p>
                </div>
            </div>

            <div class="flex items-center gap-3 py-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 9v4m0 4h.01" />
                        <path d="M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-slate-800">Kraft Box (Small)</p>
                    <p class="truncate text-xs text-slate-500">SKU-BOX-SM · 20x15x10</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-rose-600">9</p>
                    <p class="text-[11px] text-slate-400">left</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ Recent shop owners ============ --}}
    <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h3 class="font-semibold text-slate-900">Recent Sellers</h3>
                <p class="text-xs text-slate-500">Latest seller registrations</p>
            </div>
            <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-3 font-semibold">Seller</th>
                        <th class="px-5 py-3 font-semibold">Shop</th>
                        <th class="px-5 py-3 font-semibold">Phone</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold">Joined</th>
                        <th class="px-5 py-3 text-right font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">MT</div>
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-slate-900">Min Thant Kyaw</p>
                                    <p class="truncate text-xs text-slate-400">minthant@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">MT Packaging</td>
                        <td class="px-5 py-3.5 text-slate-600">09 123 456 789</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">Mar 12, 2026</td>
                        <td class="px-5 py-3.5 text-right"><a href="#" class="font-medium text-indigo-600 hover:text-indigo-700">Manage</a></td>
                    </tr>
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">AA</div>
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-slate-900">Aung Aung</p>
                                    <p class="truncate text-xs text-slate-400">aung@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">Golden Pack</td>
                        <td class="px-5 py-3.5 text-slate-600">09 987 654 321</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">Mar 10, 2026</td>
                        <td class="px-5 py-3.5 text-right"><a href="#" class="font-medium text-indigo-600 hover:text-indigo-700">Manage</a></td>
                    </tr>
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">SN</div>
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-slate-900">Su Nandar</p>
                                    <p class="truncate text-xs text-slate-400">sunandar@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">Nandar Supplies</td>
                        <td class="px-5 py-3.5 text-slate-600">09 555 111 222</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                Inactive
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">Mar 8, 2026</td>
                        <td class="px-5 py-3.5 text-right"><a href="#" class="font-medium text-indigo-600 hover:text-indigo-700">Manage</a></td>
                    </tr>
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">KO</div>
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-slate-900">Ko Htet</p>
                                    <p class="truncate text-xs text-slate-400">kohtet@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">Htet Box House</td>
                        <td class="px-5 py-3.5 text-slate-600">09 444 777 888</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">Mar 5, 2026</td>
                        <td class="px-5 py-3.5 text-right"><a href="#" class="font-medium text-indigo-600 hover:text-indigo-700">Manage</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
