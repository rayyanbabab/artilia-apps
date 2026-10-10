@extends('admin.layouts.dashboard')

@section('content')
    <x-inventory-form>
        @php
            $rp = $routePrefix ?? (auth()->user()?->role instanceof \App\Enums\UsersRole ? (auth()->user()->role->value === 'operator' ? 'staff' : 'admin') : ((string)(auth()->user()?->role ?? '') === 'operator' ? 'staff' : 'admin'));
            $totalCount = $histories->count();
            $totalIn = $histories->where('tipe', 'masuk')->sum('jumlah');
            $totalOut = $histories->where('tipe', 'keluar')->sum('jumlah');
            $specialCount = $histories->whereIn('status', ['damaged', 'lost', 'expired'])->count();
        @endphp

        <!-- Situational Overview / Real Metric Counters -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Transaksi</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalCount) }} <span class="text-xs font-normal text-gray-400">log</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Barang Masuk</p>
                        <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">+{{ number_format($totalIn) }} <span class="text-xs font-normal text-gray-400">unit</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Barang Keluar</p>
                        <p class="text-xl font-bold text-amber-600 dark:text-amber-400">-{{ number_format($totalOut) }} <span class="text-xs font-normal text-gray-400">unit</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kondisi Khusus</p>
                        <p class="text-xl font-bold text-rose-600 dark:text-rose-400">{{ number_format($specialCount) }} <span class="text-xs font-normal text-gray-400">insiden</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-4 sm:p-6 transition-colors"
             x-data="{
                search: '',
                typeFilter: 'all',
                rowCount: {{ $histories->count() }},
                isMatch(nama, kode, supplier, notes, type) {
                    const q = this.search.toLowerCase().trim();
                    const matchText = !q || nama.includes(q) || kode.includes(q) || supplier.includes(q) || notes.includes(q);
                    const matchType = this.typeFilter === 'all' || type === this.typeFilter;
                    return matchText && matchType;
                }
             }">

            <x-history-feature :filter="$filter" :route-prefix="$rp" />

            <!-- Table Search and Quick Local Filter Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 pt-2 border-t border-gray-100 dark:border-gray-700">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                           x-model="search"
                           placeholder="Cari nama barang, kode, pemasok, atau keterangan..."
                           class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-200 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                    <button type="button"
                            x-show="search.length > 0"
                            @click="search = ''"
                            class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <label for="filter-type" class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap">Tipe Mutasi:</label>
                    <select id="filter-type"
                            x-model="typeFilter"
                            class="text-xs sm:text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Semua Tipe (Masuk & Keluar)</option>
                        <option value="masuk">Barang Masuk (Inbound)</option>
                        <option value="keluar">Barang Keluar (Outbound)</option>
                    </select>
                </div>
            </div>

            @if ($histories->isEmpty())
                <div class="py-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14" />
                        </svg>
                    </div>
                    @if($filter)
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Tidak ada riwayat dengan status "{{ ucfirst($filter) }}"</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                            Tidak ditemukan log inventaris yang memiliki kondisi atau status ini.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route($rp . '.inventory.tab.history') }}"
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 dark:bg-blue-900/40 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/60 transition">
                                Reset ke Semua Riwayat
                            </a>
                        </div>
                    @else
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Belum Ada Riwayat Mutasi</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
                            Seluruh riwayat pergerakan stok, barang masuk, dan pengeluaran barang akan tercatat otomatis di tabel ini.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route($rp . '.inventory.index') }}"
                               class="inline-flex items-center px-3.5 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                                Buka Daftar Inventaris
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <!-- Printable Container Wrapper -->
                <div id="history-table-container" class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-left text-xs sm:text-sm divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/90 text-gray-500 dark:text-gray-400 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Waktu</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Informasi Barang</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Pemasok / Supplier</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap text-center">Tipe Mutasi</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap text-right">Jumlah</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap text-center">Kondisi / Status</th>
                                <th scope="col" class="px-4 py-3 whitespace-nowrap">Keterangan & PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 bg-white dark:bg-gray-800">
                            @foreach ($histories as $history)
                                @php
                                    $itemName = strtolower($history->item->nama ?? '');
                                    $itemKode = strtolower($history->item->kode ?? '');
                                    $supplierName = strtolower($history->item?->supplier?->company_name ?? $history->item?->supplier?->nama ?? 'internal');
                                    $notes = strtolower($history->keterangan ?? '');
                                    $itemType = strtolower($history->tipe ?? '');
                                    $isMasuk = $history->tipe === 'masuk';
                                    $conditionStatus = strtolower($history->status ?? 'good');
                                @endphp
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/40 transition-colors"
                                    x-show="isMatch('{{ addslashes($itemName) }}', '{{ addslashes($itemKode) }}', '{{ addslashes($supplierName) }}', '{{ addslashes($notes) }}', '{{ $itemType }}')">
                                    <!-- Timestamp Column -->
                                    <td class="px-4 py-3 whitespace-nowrap align-top">
                                        <div class="font-medium text-gray-800 dark:text-gray-200 text-xs">
                                            {{ $history->created_at ? $history->created_at->format('d M Y') : '-' }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 dark:text-gray-500 font-mono">
                                            {{ $history->created_at ? $history->created_at->format('H:i') . ' WIB' : '' }}
                                        </div>
                                    </td>

                                    <!-- Item Info Column -->
                                    <td class="px-4 py-3 align-top min-w-[180px]">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $history->item->nama ?? 'Item Telah Dihapus' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if(!empty($history->item?->kode))
                                                <span class="inline-flex items-center font-mono text-[10px] px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                    {{ $history->item->kode }}
                                                </span>
                                            @endif
                                            @if(!empty($history->item?->category?->name))
                                                <span class="text-[10px] text-gray-400 dark:text-gray-500">
                                                    • {{ $history->item->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Supplier Column -->
                                    <td class="px-4 py-3 whitespace-nowrap align-top text-xs text-gray-600 dark:text-gray-300">
                                        {{ $history->item?->supplier?->company_name ?? $history->item?->supplier?->nama ?? 'Internal / N/A' }}
                                    </td>

                                    <!-- Type Column (Masuk vs Keluar) -->
                                    <td class="px-4 py-3 whitespace-nowrap text-center align-top">
                                        @if ($isMasuk)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                </svg>
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                </svg>
                                                Keluar
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Quantity Column -->
                                    <td class="px-4 py-3 whitespace-nowrap text-right align-top">
                                        <span class="font-bold text-sm {{ $isMasuk ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-900 dark:text-gray-100' }}">
                                            {{ $isMasuk ? '+' : '-' }}{{ number_format($history->jumlah) }}
                                        </span>
                                        <span class="text-[11px] text-gray-400"> unit</span>
                                    </td>

                                    <!-- Condition / Status Column -->
                                    <td class="px-4 py-3 whitespace-nowrap text-center align-top">
                                        @if ($conditionStatus === 'sold')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                                Terjual
                                            </span>
                                        @elseif($conditionStatus === 'damaged')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                                Rusak
                                            </span>
                                        @elseif($conditionStatus === 'expired')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                                Kadaluwarsa
                                            </span>
                                        @elseif($conditionStatus === 'lost')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-300 dark:border-red-800">
                                                Hilang
                                            </span>
                                        @elseif($conditionStatus === 'received')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                Diterima
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                                {{ ucfirst($conditionStatus) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Notes & User PIC Column -->
                                    <td class="px-4 py-3 align-top min-w-[160px]">
                                        <div class="text-xs text-gray-700 dark:text-gray-300 line-clamp-2">
                                            {{ $history->keterangan ?: '-' }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            PIC: {{ $history->user?->name ?? 'Sistem' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500 mt-3 px-1">
                    <span>Menampilkan {{ number_format($totalCount) }} entri log riwayat</span>
                    <span>Diurutkan berdasarkan transaksi terbaru</span>
                </div>
            @endif
        </div>
    </x-inventory-form>
@endsection
