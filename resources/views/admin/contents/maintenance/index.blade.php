@extends('admin.layouts.dashboard')

@section('content')
@php
    $role = Auth::user()?->role;
    $roleVal = $role instanceof \App\Enums\UsersRole ? $role->value : (string) ($role ?? 'admin');
    $isOp = $roleVal === 'operator';
    $routePrefix = $routePrefix ?? ($isOp ? 'staff' : 'admin');
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6"
     x-data="{
        completeModal: { open: false, id: null, name: '', jumlah: 0, action: '' },
        scrapModal:    { open: false, id: null, name: '', jumlah: 0, action: '' },
        openComplete(id, name, jumlah, action) {
            this.completeModal = { open: true, id, name, jumlah, action };
        },
        openScrap(id, name, jumlah, action) {
            this.scrapModal = { open: true, id, name, jumlah, action };
        }
     }">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Maintenance & Perbaikan</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola barang yang sedang dalam proses servis atau perbaikan</p>
                </div>
            </div>
            @if(!$isOp)
            <a href="{{ route($routePrefix . '.maintenance.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Masukkan ke Servis
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white rounded-xl border border-orange-100 shadow-sm p-4 sm:p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Sedang Diservis</p>
                <p class="text-2xl font-bold text-orange-700">{{ $statistics['in_repair'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-blue-100 shadow-sm p-4 sm:p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Total Unit Servis</p>
                <p class="text-2xl font-bold text-blue-700">{{ $statistics['total_unit'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-green-100 shadow-sm p-4 sm:p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Selesai Diservis</p>
                <p class="text-2xl font-bold text-green-700">{{ $statistics['completed'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-red-100 shadow-sm p-4 sm:p-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">Dihapus (Scrap)</p>
                <p class="text-2xl font-bold text-red-700">{{ $statistics['scrapped'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-4">
        <form method="GET" action="{{ route($routePrefix . '.maintenance.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Cari Barang</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama barang..."
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 bg-gray-50 focus:bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status</label>
                <select name="status" class="px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 bg-white text-gray-700">
                    <option value="">Semua Status</option>
                    <option value="in_repair"  {{ request('status') === 'in_repair'  ? 'selected' : '' }}>🔧 Sedang Diservis</option>
                    <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="scrapped"   {{ request('status') === 'scrapped'   ? 'selected' : '' }}>🗑 Scrap</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'item_id']))
                <a href="{{ route($routePrefix . '.maintenance.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Daftar Maintenance</h3>
            <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $maintenances->total() }} record</span>
        </div>

        @if($maintenances->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Barang</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Catatan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Tanggal Masuk</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Selesai</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($maintenances as $m)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900 text-sm truncate max-w-[180px]">{{ $m->item?->nama ?? '-' }}</div>
                            <div class="text-xs text-blue-600 font-mono mt-0.5">{{ $m->item?->kode ?? '' }}</div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-800 font-bold text-sm">{{ $m->jumlah }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $m->statusColor() }}">
                                @if($m->status === 'in_repair' && $isOp)
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                @endif
                                {{ $m->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-4 py-4 hidden sm:table-cell">
                            <span class="text-gray-500 text-xs line-clamp-2 max-w-[160px] block">{{ $m->catatan ?: '-' }}</span>
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <span class="text-xs text-gray-600 whitespace-nowrap">{{ $m->started_at?->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                        </td>
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $m->completed_at ? $m->completed_at->setTimezone('Asia/Jakarta')->format('d M Y') : '—' }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">

                                <a href="{{ route($routePrefix . '.maintenance.show', $m) }}"
                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if($m->status === 'in_repair' && $isOp)

                                <button type="button"
                                        @click="openComplete({{ $m->id }}, '{{ addslashes($m->item?->nama) }}', {{ $m->jumlah }}, '{{ route($routePrefix . '.maintenance.complete', $m) }}')"
                                        class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Tandai Selesai">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>

                                <button type="button"
                                        @click="openScrap({{ $m->id }}, '{{ addslashes($m->item?->nama) }}', {{ $m->jumlah }}, '{{ route($routePrefix . '.maintenance.scrap', $m) }}')"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Scrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($maintenances->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
            {{ $maintenances->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-16 px-6">
            <div class="w-16 h-16 mx-auto mb-4 bg-orange-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Belum Ada Data Maintenance</h3>
            <p class="text-sm text-gray-400 mb-5">Tidak ada barang yang sedang dalam servis saat ini.</p>
            @if(!$isOp)
            <a href="{{ route($routePrefix . '.maintenance.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Masukkan Barang ke Servis
            </a>
            @endif
        </div>
        @endif
    </div>

    @if($isOp)

    <template x-teleport="body">
        <div x-show="completeModal.open"
             x-cloak
             class="fixed inset-0 z-[9999] overflow-y-auto"
             role="dialog" aria-modal="true"
             @keydown.escape.window="completeModal.open = false">

            <div x-show="completeModal.open"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="completeModal.open = false"
                 class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity"></div>

            <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="completeModal.open"
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
                        <button type="button" @click="completeModal.open = false"
                                class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                                title="Tutup Modal (Esc)">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="completeModal.action"
                          class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf @method('PATCH')
                        <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                            <div class="bg-emerald-50 dark:bg-emerald-950/30 rounded-xl p-3.5 flex items-start gap-3 border border-emerald-100 dark:border-emerald-800/40">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-emerald-800 dark:text-emerald-300 leading-relaxed">
                                    Barang <strong x-text="completeModal.name"></strong>
                                    sebanyak <strong x-text="completeModal.jumlah + ' unit'"></strong>
                                    akan ditandai selesai dan stok dikembalikan.
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Catatan Hasil Servis <span class="font-normal text-gray-400">(opsional)</span></label>
                                <textarea name="catatan_selesai" rows="3"
                                          placeholder="Contoh: Layar berhasil diganti, semua fungsi berjalan normal..."
                                          class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"></textarea>
                            </div>
                        </div>
                        <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="completeModal.open = false"
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
    @endif

    @if($isOp)

    <template x-teleport="body">
        <div x-show="scrapModal.open"
             x-cloak
             class="fixed inset-0 z-[9999] overflow-y-auto"
             role="dialog" aria-modal="true"
             @keydown.escape.window="scrapModal.open = false">

            <div x-show="scrapModal.open"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="scrapModal.open = false"
                 class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity"></div>

            <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="scrapModal.open"
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
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Konfirmasi Scrap / Afkir</h3>
                                <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                            </div>
                        </div>
                        <button type="button" @click="scrapModal.open = false"
                                class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                                title="Tutup Modal (Esc)">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="scrapModal.action"
                          class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf @method('PATCH')
                        <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                            <div class="bg-red-50 dark:bg-red-950/30 rounded-xl p-3.5 flex items-start gap-3 border border-red-100 dark:border-red-800/40">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p class="text-xs text-red-700 dark:text-red-300 leading-relaxed">
                                    Barang <strong x-text="scrapModal.name"></strong>
                                    (<span x-text="scrapModal.jumlah"></span> unit) akan di-scrap.
                                    <span class="font-bold text-red-600 dark:text-red-400">Stok TIDAK akan dikembalikan.</span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Alasan Scrap <span class="font-normal text-gray-400">(opsional)</span></label>
                                <textarea name="catatan_selesai" rows="3"
                                          placeholder="Contoh: Barang tidak dapat diperbaiki, kerusakan terlalu parah..."
                                          class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"></textarea>
                            </div>
                        </div>
                        <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="scrapModal.open = false"
                                    class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 rounded-xl shadow-md shadow-red-500/25 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Ya, Scrap Barang Ini
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
    @endif

</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
