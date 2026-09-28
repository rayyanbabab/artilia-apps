@extends('admin.layouts.dashboard')

@section('content')
@php
    $role = Auth::user()?->role;
    $roleVal = $role instanceof \App\Enums\UsersRole ? $role->value : (string) ($role ?? 'admin');
    $routePrefix = $routePrefix ?? ($roleVal === 'operator' ? 'staff' : 'admin');
@endphp
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-5">

    <div class="flex items-center gap-3">
        <a href="{{ route($routePrefix . '.maintenance.index') }}"
           class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Detail Maintenance</h1>
            <p class="text-sm text-gray-500">Informasi lengkap catatan servis barang</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-3 {{ $maintenance->status === 'in_repair' ? 'bg-orange-50 border-b border-orange-100' : ($maintenance->status === 'completed' ? 'bg-green-50 border-b border-green-100' : 'bg-red-50 border-b border-red-100') }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide {{ $maintenance->status === 'in_repair' ? 'text-orange-600' : ($maintenance->status === 'completed' ? 'text-green-600' : 'text-red-600') }}">
                    Status Servis
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $maintenance->statusColor() }}">
                    @if($maintenance->status === 'in_repair')
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    @endif
                    {{ $maintenance->statusLabel() }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-5">

            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                <div class="w-12 h-12 rounded-xl overflow-hidden bg-white border border-gray-200 flex-shrink-0">
                    @if($maintenance->item?->gambar)
                        <img src="{{ asset($maintenance->item->gambar) }}" alt="{{ $maintenance->item->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-blue-600 mb-0.5">{{ $maintenance->item?->kode }}</div>
                    <div class="font-semibold text-gray-900">{{ $maintenance->item?->nama ?? 'Barang tidak ditemukan' }}</div>
                    @if($maintenance->item?->category)
                    <div class="text-xs text-gray-500 mt-0.5">{{ $maintenance->item->category->name }}</div>
                    @endif
                </div>
                @php
                    $hasInventoryRoute = Route::has($routePrefix . '.inventory.show');
                @endphp
                @if($hasInventoryRoute && $maintenance->item_id)
                <a href="{{ route($routePrefix . '.inventory.show', $maintenance->item_id) }}"
                   class="text-xs text-blue-600 hover:underline font-medium flex-shrink-0">Lihat Barang →</a>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Jumlah Unit</p>
                    <p class="text-xl font-bold text-gray-900">{{ $maintenance->jumlah }} <span class="text-sm font-normal text-gray-500">unit</span></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Dicatat Oleh</p>
                    <p class="text-sm font-medium text-gray-700">{{ $maintenance->user?->name ?? 'Unknown' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Tanggal Masuk</p>
                    <p class="text-sm text-gray-700">{{ $maintenance->started_at?->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Tanggal Selesai</p>
                    <p class="text-sm text-gray-700">{{ $maintenance->completed_at ? $maintenance->completed_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : '-' }}</p>
                </div>
            </div>

            @if($maintenance->kondisi_masuk)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Kondisi Saat Masuk</p>
                <p class="text-sm text-gray-700 bg-orange-50 border border-orange-100 rounded-lg px-3 py-2">{{ $maintenance->kondisi_masuk }}</p>
            </div>
            @endif

            @if($maintenance->catatan)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Catatan Kerusakan</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg px-3 py-2.5 leading-relaxed">{{ $maintenance->catatan }}</p>
            </div>
            @endif

            @if($maintenance->catatan_selesai)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Catatan Selesai / Hasil Servis</p>
                <p class="text-sm text-gray-700 {{ $maintenance->status === 'completed' ? 'bg-green-50 border border-green-100' : 'bg-red-50 border border-red-100' }} rounded-lg px-3 py-2.5 leading-relaxed">{{ $maintenance->catatan_selesai }}</p>
            </div>
            @endif

        </div>

        @if($maintenance->status === 'in_repair')
        @php $isOp = Auth::user()->role->value === 'operator'; @endphp

        @if($isOp)

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-3">

            <div x-data="{ open: false }" class="flex-1">
                <button @click="open = true" type="button"
                        class="w-full py-2.5 text-sm font-semibold bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tandai Selesai
                </button>
                <template x-teleport="body">
                    <div x-show="open"
                         x-cloak
                         class="fixed inset-0 z-[9999] overflow-y-auto"
                         role="dialog" aria-modal="true"
                         @keydown.escape.window="open = false">
                        <div x-show="open"
                             x-transition:enter="ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             @click="open = false"
                             class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity"></div>

                        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
                            <div x-show="open"
                                 x-transition:enter="ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                                 @click.stop
                                 class="relative transform text-left bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 max-w-md w-full flex flex-col max-h-[85vh] my-auto overflow-hidden">

                                <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-gray-50/70 dark:bg-slate-850">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center font-bold text-white shadow-sm flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Tandai Selesai Servis</h3>
                                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Stok akan dikembalikan ke inventori</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="open = false"
                                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                                            title="Tutup Modal (Esc)">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route($routePrefix . '.maintenance.complete', $maintenance) }}"
                                      class="flex flex-col flex-1 min-h-0 overflow-hidden">
                                    @csrf @method('PATCH')
                                    <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                                        <div class="bg-emerald-50 dark:bg-emerald-950/30 rounded-xl p-3.5 flex items-start gap-3 border border-emerald-100 dark:border-emerald-800/40">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-xs text-emerald-800 dark:text-emerald-300 leading-relaxed">
                                                {{ $maintenance->jumlah }} unit barang <strong>{{ $maintenance->item?->nama }}</strong> akan dikembalikan ke stok.
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Catatan Hasil Servis <span class="font-normal text-gray-400">(opsional)</span></label>
                                            <textarea name="catatan_selesai" rows="3"
                                                      placeholder="Catatan hasil servis (opsional)..."
                                                      class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"></textarea>
                                        </div>
                                    </div>
                                    <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                                        <button type="button" @click="open = false"
                                                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 rounded-xl shadow-md shadow-emerald-500/25 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Selesai & Kembalikan Stok
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-data="{ open: false }">
                <button @click="open = true" type="button"
                        class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold bg-white dark:bg-slate-800 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Scrap
                </button>
                <template x-teleport="body">
                    <div x-show="open"
                         x-cloak
                         class="fixed inset-0 z-[9999] overflow-y-auto"
                         role="dialog" aria-modal="true"
                         @keydown.escape.window="open = false">
                        <div x-show="open"
                             x-transition:enter="ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             @click="open = false"
                             class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity"></div>

                        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
                            <div x-show="open"
                                 x-transition:enter="ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                                 @click.stop
                                 class="relative transform text-left bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 max-w-md w-full flex flex-col max-h-[85vh] my-auto overflow-hidden">

                                <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-gray-50/70 dark:bg-slate-850">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-red-600 flex items-center justify-center font-bold text-white shadow-sm flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Konfirmasi Scrap</h3>
                                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="open = false"
                                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                                            title="Tutup Modal (Esc)">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route($routePrefix . '.maintenance.scrap', $maintenance) }}"
                                      class="flex flex-col flex-1 min-h-0 overflow-hidden">
                                    @csrf @method('PATCH')
                                    <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                                        <div class="bg-red-50 dark:bg-red-950/30 rounded-xl p-3.5 flex items-start gap-3 border border-red-100 dark:border-red-800/40">
                                            <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <p class="text-xs text-red-700 dark:text-red-300 leading-relaxed">
                                                {{ $maintenance->jumlah }} unit <strong>{{ $maintenance->item?->nama }}</strong> akan di-scrap. <span class="font-bold text-red-600 dark:text-red-400">Stok TIDAK akan dikembalikan.</span>
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Alasan Scrap</label>
                                            <textarea name="catatan_selesai" rows="2"
                                                      placeholder="Alasan scrap..."
                                                      class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"></textarea>
                                        </div>
                                    </div>
                                    <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                                        <button type="button" @click="open = false"
                                                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 rounded-xl shadow-md shadow-red-500/25 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Ya, Scrap
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>
        @else

        <div class="px-6 py-4 bg-blue-50 border-t border-blue-100">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Menunggu eksekusi dari Operator</p>
                    <p class="text-xs text-blue-600 mt-0.5">Barang ini sedang dalam antrean servis. Operator akan menandai selesai atau scrap, dan kamu akan mendapat notifikasi otomatis.</p>
                </div>
            </div>
        </div>
        @endif

        @endif
    </div>

</div>
@endsection
