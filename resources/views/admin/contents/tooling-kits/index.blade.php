@extends('admin.layouts.dashboard')

@section('title', 'Manajemen Paket Perkakas (Tooling Kit SPK)')

@section('content')
<style>

html.dark .kit-card    { background-color: #1e293b !important; border-color: #334155 !important; }
html.dark .kit-title   { color: #f1f5f9 !important; }
html.dark .kit-sub     { color: #94a3b8 !important; }
html.dark .kit-item-box{ background-color: #0f172a !important; border-color: #334155 !important; }
html.dark .kit-input   { background-color: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important; }
html.dark .kit-modal-bg{ background-color: #1e293b !important; border-color: #334155 !important; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-5"
     x-data="{
        createModal: false,
        kitRows: [{ item_id: '', jumlah: 1, catatan: '' }],
        addRow()    { this.kitRows.push({ item_id: '', jumlah: 1, catatan: '' }); },
        removeRow(i){ if (this.kitRows.length > 1) this.kitRows.splice(i, 1); }
     }">

    <div class="kit-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-1 bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600"></div>
        <div class="p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-amber-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 002 2v2a2 2 0 01-2 2M5 9V7a2 2 0 012-2h6a2 2 0 012 2v2M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h1 class="kit-title text-xl font-bold text-gray-900 tracking-tight">Tooling Kit SPK</h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                Prodi Manufaktur & Mesin
                            </span>
                        </div>
                        <p class="kit-sub text-sm text-gray-500 mt-0.5">Paket perkakas standar per jenis pengerjaan benda kerja untuk peminjaman cepat teknisi</p>
                    </div>
                </div>
                <button @click="createModal = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-amber-200 transition-all flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Paket SPK Baru
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        @forelse($kits as $kit)
        <div class="kit-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">

            <div class="p-5 flex-1">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-mono text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-lg">
                                {{ $kit->kode }}
                            </span>
                            @if($kit->is_active)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </div>
                        <h3 class="kit-title text-base font-bold text-gray-900 mt-2 leading-snug">{{ $kit->nama }}</h3>
                        <p class="text-xs text-indigo-600 font-semibold mt-0.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $kit->target_machine ?? 'Umum / Konvensional' }}
                        </p>
                        @if($kit->deskripsi)
                            <p class="kit-sub text-xs text-gray-400 mt-1.5 leading-relaxed">{{ $kit->deskripsi }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-1 flex-shrink-0">
                        <form method="POST" action="{{ route($routePrefix . '.tooling-kits.toggle-status', $kit->id) }}">
                            @csrf
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="{{ $kit->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </button>
                        </form>
                        <form method="POST" action="{{ route($routePrefix . '.tooling-kits.destroy', $kit->id) }}" onsubmit="return confirm('Hapus paket ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Paket">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="kit-item-box bg-gray-50 rounded-xl p-3.5 border border-gray-100 mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="kit-title text-xs font-bold text-gray-700">
                            Daftar Perkakas
                        </p>
                        <span class="text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-lg">{{ $kit->kitItems->count() }} item</span>
                    </div>
                    <div class="space-y-1.5 max-h-44 overflow-y-auto pr-0.5">
                        @foreach($kit->kitItems as $kItem)
                        <div class="kit-card flex items-center justify-between text-xs py-1.5 px-2.5 rounded-lg bg-white border border-gray-100">
                            <div class="flex items-center gap-2 overflow-hidden min-w-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                                <span class="kit-title font-medium text-gray-800 truncate">{{ $kItem->item->nama ?? 'Item tidak ditemukan' }}</span>
                                @if($kItem->catatan)
                                    <span class="kit-sub text-[10px] text-gray-400 truncate hidden sm:block">({{ $kItem->catatan }})</span>
                                @endif
                            </div>
                            <span class="font-extrabold text-gray-900 bg-amber-50 border border-amber-200 text-[11px] px-2 py-0.5 rounded-lg flex-shrink-0 ml-2">{{ $kItem->jumlah }}×</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 002 2v2a2 2 0 01-2 2M5 9V7a2 2 0 012-2h6a2 2 0 012 2v2M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/></svg>
            </div>
            <p class="text-base font-bold text-gray-800">Belum Ada Paket Tooling Kit</p>
            <p class="text-xs text-gray-400 mt-1 max-w-md mx-auto leading-relaxed">
                Buat paket standar proses permesinan (paket bubut poros, frais roda gigi, dll.) untuk mempercepat peminjaman teknisi.
            </p>
            <button @click="createModal = true" class="mt-4 px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                + Buat Paket Sekarang
            </button>
        </div>
        @endforelse
    </div>

    @if($kits->hasPages())
    <div class="kit-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        {{ $kits->links() }}
    </div>
    @endif

    <template x-teleport="body">
        <div x-show="createModal"
             x-cloak
             class="fixed inset-0 z-[9999] overflow-y-auto"
             role="dialog"
             aria-modal="true"
             @keydown.escape.window="createModal = false">

            <div x-show="createModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="createModal = false"
                 class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity"></div>

            <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">

                <div x-show="createModal"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2 sm:translate-y-0"
                     @click.stop
                     class="relative transform text-left bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 max-w-2xl w-full flex flex-col max-h-[85vh] my-auto overflow-hidden">

                    <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-gray-50/70 dark:bg-slate-850">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center font-bold text-white shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Buat Paket Perkakas SPK Baru</h3>
                                <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Tentukan alat potong, alat ukur, dan pencekam untuk 1 jenis pengerjaan</p>
                            </div>
                        </div>
                        <button type="button" @click="createModal = false"
                                class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                                title="Tutup Modal (Esc)">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route($routePrefix . '.tooling-kits.store') }}" method="POST"
                          class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        @csrf

                        <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Kode Paket <span class="text-rose-500">*</span></label>
                                    <input type="text" name="kode" placeholder="Contoh: KIT-LATHE-01" required
                                           class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 uppercase focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Nama Paket Pengerjaan <span class="text-rose-500">*</span></label>
                                    <input type="text" name="nama" placeholder="Contoh: Pemesinan Poros Bertingkat" required
                                           class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Mesin Target</label>
                                    <input type="text" name="target_machine" placeholder="Contoh: Mesin Bubut Konvensional"
                                           class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">Deskripsi Pengerjaan</label>
                                    <input type="text" name="deskripsi" placeholder="Keterangan proses pengerjaan benda kerja"
                                           class="w-full text-xs rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white py-2 px-3 focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                                </div>
                            </div>

                            <div class="pt-2 border-t border-gray-100 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-2.5">
                                    <label class="block text-xs font-bold text-gray-800 dark:text-slate-200">Daftar Perkakas dalam Paket <span class="text-rose-500">*</span></label>
                                    <button type="button" @click="addRow()" class="inline-flex items-center gap-1 text-xs font-bold text-amber-600 hover:text-amber-700 dark:text-amber-400 px-2.5 py-1 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-950/60 rounded-lg transition-colors border border-amber-200 dark:border-amber-800">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Alat
                                    </button>
                                </div>
                                <div class="space-y-2 max-h-52 overflow-y-auto pr-1">
                                    <template x-for="(row, index) in kitRows" :key="index">
                                        <div class="flex items-center gap-2 p-2.5 bg-gray-50/80 dark:bg-slate-800/60 rounded-xl border border-gray-200/80 dark:border-slate-700">
                                            <div class="flex-1 min-w-0">
                                                <select :name="'item_ids[' + index + ']'" x-model="row.item_id" required
                                                        class="w-full text-xs rounded-lg border-gray-200 dark:border-slate-700 focus:ring-amber-500 focus:border-amber-500 py-1.5 px-2 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                                    <option value="">— Pilih Perkakas/Alat —</option>
                                                    @foreach($availableItems as $item)
                                                        <option value="{{ $item->id }}">{{ $item->kode ? '['.$item->kode.'] ' : '' }}{{ $item->nama }} (Stok: {{ $item->stok_peminjaman }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-16">
                                                <input type="number" :name="'quantities[' + index + ']'" x-model="row.jumlah" min="1" required placeholder="Jml"
                                                       class="w-full text-xs rounded-lg border-gray-200 dark:border-slate-700 focus:ring-amber-500 focus:border-amber-500 py-1.5 px-2 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-center font-bold">
                                            </div>
                                            <div class="w-28">
                                                <input type="text" :name="'notes[' + index + ']'" x-model="row.catatan" placeholder="Catatan"
                                                       class="w-full text-xs rounded-lg border-gray-200 dark:border-slate-700 focus:ring-amber-500 focus:border-amber-500 py-1.5 px-2 bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                                            </div>
                                            <button type="button" @click="removeRow(index)" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/40 rounded-lg transition-colors flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="createModal = false"
                                    class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 active:scale-95 rounded-xl shadow-md shadow-amber-500/25 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Paket Perkakas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection
