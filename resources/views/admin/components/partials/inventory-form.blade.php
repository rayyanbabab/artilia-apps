@php
    $rp = $routePrefix ?? (auth()->user()?->role instanceof \App\Enums\UsersRole ? (auth()->user()->role->value === 'operator' ? 'staff' : 'admin') : ((string)(auth()->user()?->role ?? '') === 'operator' ? 'staff' : 'admin'));
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
    <!-- Top Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 transition-colors">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        Inventaris Bengkel
                    </span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Logistik & Peralatan</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Manajemen Inventaris</h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-0.5">Pantau ketersediaan stok, spesifikasi teknis barang, dan catatan log mutasi inventaris</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route($rp . '.inventory.add') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mt-6 border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-2 -mb-px overflow-x-auto pb-1 sm:pb-0" aria-label="Tabs Inventaris">
                <x-tab-links :route="$rp . '.inventory.index'" :active="$rp . '.inventory.index'">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Daftar Inventaris
                </x-tab-links>

                <x-tab-links :route="$rp . '.inventory.tab.detail'" :active="$rp . '.inventory.tab.detail'">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Detail & Spesifikasi
                </x-tab-links>

                <x-tab-links :route="$rp . '.inventory.tab.history'" :active="$rp . '.inventory.tab.history*'">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Mutasi
                </x-tab-links>
            </nav>
        </div>
    </div>

    <x-alert type="success" />

    <!-- Tab Content Slot -->
    <div class="transition-colors">
        {{ $slot }}
    </div>
</div>
