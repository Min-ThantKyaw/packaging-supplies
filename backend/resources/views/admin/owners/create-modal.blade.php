{{-- Create Shop Owner modal — opened by [data-modal-target="create-owner-modal"] --}}
<div id="create-owner-modal" data-modal class="fixed inset-0 z-[60] hidden overflow-y-auto">

    {{-- Backdrop: click anywhere outside the panel to close --}}
    <div data-modal-close class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    {{-- Panel --}}
    <div class="pointer-events-none relative flex min-h-full items-center justify-center p-4 sm:p-6">
        {{-- TODO: point action at the POST /admin/owners route once it exists --}}
        <form method="POST" action="{{ route('admin.owners.store') }}"
            class="pointer-events-auto w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl">
            @csrf

            {{-- Header --}}
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-5 py-4">
                <div>
                    <h3 class="font-semibold text-slate-900">Add Shop Owner</h3>
                    <p class="text-xs text-slate-500">Create a new shop owner account.</p>
                </div>
                <button type="button" data-modal-close aria-label="Close"
                    class="-mr-1 rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="grid grid-cols-1 gap-4 px-5 py-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="owner-name" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Full name <span class="text-rose-500">*</span>
                    </label>
                    <input id="owner-name" type="text" name="name" required autocomplete="name"
                        placeholder="e.g. Aung Aung"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <div class="sm:col-span-2">
                    <label for="owner-email" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Email address <span class="text-rose-500">*</span>
                    </label>
                    <input id="owner-email" type="email" name="email" required autocomplete="email"
                        placeholder="owner@example.com"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <div>
                    <label for="owner-phone" class="mb-1.5 block text-sm font-medium text-slate-700">Phone</label>
                    <input id="owner-phone" type="text" name="phone" autocomplete="tel"
                        placeholder="09 123 456 789"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <div>
                    <label for="owner-shop" class="mb-1.5 block text-sm font-medium text-slate-700">Shop name</label>
                    <input id="owner-shop" type="text" name="shop_name"
                        placeholder="e.g. MT Packaging"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <div>
                    <label for="owner-password" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    <input id="owner-password" type="password" name="password" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <div>
                    <label for="owner-password-confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Confirm password <span class="text-rose-500">*</span>
                    </label>
                    <input id="owner-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                </div>

                <label class="flex items-center gap-2.5 text-sm text-slate-600 sm:col-span-2">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Active — owner can sign in immediately
                </label>
            </div>

            {{-- Footer --}}
            <div class="flex flex-col gap-2 border-t border-slate-100 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end">
                <button type="button" data-modal-close
                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 sm:w-auto">
                    Cancel
                </button>
                <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition hover:bg-indigo-700 sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Create Owner
                </button>
            </div>
        </form>
    </div>
</div>
