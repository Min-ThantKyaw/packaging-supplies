@extends('layouts.admin')

@section('title', 'Sellers')
@section('subtitle', 'Manage all sellers on the platform')

@section('content')
    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 13l4 4L19 7" />
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Page header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Sellers</h2>
            <p class="text-sm text-slate-500">All registered sellers across the platform.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4" />
                    <path d="M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                </svg>
                Export
            </button>
            <button type="button" data-modal-target="create-seller-modal"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Add Seller
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <path d="M20 20l-3.5-3.5" />
            </svg>
            <input type="search" placeholder="Search by name, email or shop…"
                class="h-10 w-full rounded-lg border border-slate-200 bg-white pl-9 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </div>
        <select
            class="h-10 rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100 sm:w-40">
            <option>All status</option>
            <option>Active</option>
            <option>Inactive</option>
        </select>
    </div>

    {{-- Sellers table --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-3 font-semibold">Owner</th>
                        <th class="px-5 py-3 font-semibold">Shop</th>
                        <th class="px-5 py-3 font-semibold">Phone</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 font-semibold">Joined</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    {{-- Sample rows — replace with @foreach ($owners as $owner) --}}
                    @foreach ($sellers as $seller)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">AA</div>
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-slate-900">{{ $seller->name }}</p>
                                        <p class="truncate text-xs text-slate-400">{{ $seller->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $seller->shop_name ?? 'N/A' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $seller->phone ?? 'N/A' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold {{ $seller->is_active ? 'text-emerald-700' : 'text-slate-500' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $seller->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                    {{ $seller->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">{{ optional($seller->created_at)->format('Y-m-d') }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="#" title="View" class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            <circle cx="12" cy="12" r="2.5" />
                                        </svg>
                                    </a>
                                    <a href="#" title="Edit" class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 20h4l10-10-4-4L4 16v4z" />
                                            <path d="M14 6l4 4" />
                                        </svg>
                                    </a>
                                    <button type="button" title="Delete" class="rounded-lg p-2 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 7h16M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-8 0l1 13h8l1-13" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer / pagination --}}
        <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row">
            <p class="text-xs text-slate-500">
                Showing <span class="font-medium text-slate-700">1</span>–<span class="font-medium text-slate-700">4</span>
                of <span class="font-medium text-slate-700">128</span> sellers
            </p>
            <div class="flex items-center gap-1">
                <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-500 transition hover:bg-slate-50">Previous</button>
                <button type="button" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white">1</button>
                <button type="button" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100">2</button>
                <button type="button" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100">3</button>
                <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">Next</button>
            </div>
        </div>
    </div>

    {{-- Create modal (fill in components/create-modal.blade.php) --}}
    @include('admin.sellers.create-modal')

    <script>
        // Opens/closes any [data-modal-target] modal. Safe when the modal is absent.
        (function () {
            document.querySelectorAll('[data-modal-target]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var modal = document.getElementById(btn.dataset.modalTarget);
                    if (modal) modal.classList.remove('hidden');
                });
            });

            document.querySelectorAll('[data-modal-close]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var modal = btn.closest('[data-modal]');
                    if (modal) modal.classList.add('hidden');
                });
            });
        })();
    </script>
@endsection
