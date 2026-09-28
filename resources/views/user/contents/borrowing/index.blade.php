@extends('user.layouts.dashboard-user')
@section('title', 'Katalog Peminjaman Alat')
@section('user')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 rounded-full px-3 py-1">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                    Katalog Aktif
                </span>
                <span class="text-xs text-gray-400 dark:text-slate-400">
                    {{ count($items) }} jenis alat tersedia
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Katalog Peminjaman Alat</h1>
            <p class="text-sm text-gray-400 dark:text-slate-400 mt-1">Pilih perlengkapan atau perkakas teknik yang ingin kamu pinjam untuk praktikum &amp; kerja bengkel</p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">

            <a href="{{ route('user.borrowing.cart') }}"
               class="relative inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 text-gray-700 dark:text-slate-200 text-xs font-bold transition-all shadow-sm">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Keranjang
                @if(($sidebarCartCount ?? 0) > 0)
                    <span class="inline-flex items-center justify-center px-1.5 py-0.2 text-[10px] font-bold text-white bg-rose-500 rounded-full">{{ $sidebarCartCount }}</span>
                @endif
            </a>
            <a href="{{ route('user.borrowing.my-requests') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Status Pinjaman
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl text-xs font-semibold">
            <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800/50 text-rose-800 dark:text-rose-300 px-4 py-3 rounded-xl text-xs font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <p>&bull; {{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if(isset($toolingKits) && $toolingKits->count() > 0)
        <div class="bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-orange-500/10 dark:from-amber-950/20 dark:to-orange-950/20 rounded-2xl border border-amber-200/70 dark:border-amber-700/30 p-5 space-y-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 002 2v2a2 2 0 01-2 2M5 9V7a2 2 0 012-2h6a2 2 0 012 2v2M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">Paket Perkakas Job Order (SPK)</h2>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Pinjam seperangkat alat pemesinan lengkap sekaligus dengan 1 klik</p>
                    </div>
                </div>
                <span class="text-[10px] font-extrabold text-amber-800 dark:text-amber-300 bg-amber-100 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/40 px-2.5 py-1 rounded-full">
                    Standar Manufaktur
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-1">
                @foreach($toolingKits as $kit)
                <div class="bg-white dark:bg-slate-850 rounded-2xl border border-amber-200/60 dark:border-amber-800/30 p-4 shadow-sm flex flex-col justify-between space-y-3 hover:shadow-md transition-all">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-[10px] font-bold text-amber-800 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded">{{ $kit->kode }}</span>
                            <span class="text-[11px] text-gray-400 dark:text-slate-400">{{ $kit->target_machine ?? 'Mesin Umum' }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $kit->nama }}</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $kit->deskripsi }}</p>

                        <div class="mt-2.5 pt-2 border-t border-gray-100 dark:border-slate-800 text-[11px] text-gray-600 dark:text-slate-300 space-y-1">
                            <p class="font-bold text-gray-700 dark:text-slate-300">Termasuk:</p>
                            @foreach($kit->kitItems as $kItem)
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="truncate">&bull; {{ $kItem->item->nama ?? '-' }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $kItem->jumlah }}x</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.borrowing.kit.borrow', $kit->id) }}" class="pt-2">
                        @csrf
                        <button type="submit"
                                class="w-full py-2 px-3 bg-amber-600 hover:bg-amber-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Pinjam 1 Paket ke Keranjang
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($items->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($items as $item)
                <div class="group bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 overflow-hidden flex flex-col">

                    <div class="relative h-44 w-full overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-900 flex-shrink-0">
                        @if ($item->gambar)
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}"
                                 class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400 dark:text-slate-400">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-[11px] text-gray-400 dark:text-slate-500">Tanpa Gambar</span>
                                </div>
                            </div>
                        @endif

                        @php $stok = $item->stok_peminjaman; @endphp
                        <div class="absolute top-2.5 right-2.5">
                            <span class="inline-flex items-center gap-1 {{ $stok > 3 ? 'bg-emerald-500' : ($stok > 0 ? 'bg-amber-500' : 'bg-rose-500') }} text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full shadow">
                                <span class="w-1.5 h-1.5 bg-white/80 rounded-full"></span>
                                {{ $stok }} tersedia
                            </span>
                        </div>

                        @if($item->category)
                            <div class="absolute bottom-2.5 left-2.5">
                                <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                    {{ $item->category->nama }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">

                        <div class="flex-1 flex flex-col gap-1 mb-3">

                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $item->nama }}</h3>

                            <p class="text-xs text-gray-400 dark:text-slate-400 line-clamp-1 min-h-[1rem]">
                                @if($item->keterangan)
                                    {{ Str::limit($item->keterangan, 60) }}
                                @else
                                    &nbsp;
                                @endif
                            </p>

                            @if($item->location)
                                @php $locName = $item->location->nama ?? $item->location->name ?? ''; @endphp
                                @if($locName)
                                    <div class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-slate-400 mt-1">
                                        <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $locName }}
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="space-y-2 pt-2 border-t border-gray-50 dark:border-slate-800">

                            <form action="{{ route('user.borrowing.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden bg-gray-50 dark:bg-slate-800 flex-shrink-0">
                                        <button type="button" onclick="decrementQty(this)"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors text-base font-bold">
                                            &minus;
                                        </button>
                                        <input type="number" name="jumlah" value="1" min="1" max="{{ $stok }}"
                                               class="w-9 h-8 text-center text-xs font-bold text-gray-800 dark:text-white bg-transparent border-0 focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button" onclick="incrementQty(this, {{ $stok }})"
                                                class="w-8 h-8 flex items-center justify-center text-gray-500 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors text-base font-bold">
                                            +
                                        </button>
                                    </div>
                                    <button type="submit"
                                            class="flex-1 inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold h-8 px-2 rounded-xl transition-all shadow-sm active:scale-95">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        + Keranjang
                                    </button>
                                </div>
                            </form>

                            <div class="flex gap-2">
                                <a href="{{ route('user.borrowing.show-item', $item->id) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold h-8 px-2 rounded-xl transition-colors">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                                <a href="{{ route('user.borrowing.create', $item->id) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-bold h-8 px-2 rounded-xl transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    Pinjam Cepat
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        @if($items instanceof \Illuminate\Contracts\Pagination\Paginator && $items->hasPages())
            <div class="flex justify-center mt-6">
                {{ $items->links() }}
            </div>
        @endif

    @else

        <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm px-6 py-20 text-center">
            <div class="flex items-center justify-center w-16 h-16 bg-blue-50 dark:bg-blue-500/10 rounded-2xl mx-auto mb-4 text-blue-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Katalog Masih Kosong</h3>
            <p class="text-xs text-gray-400 dark:text-slate-400 max-w-xs mx-auto">Saat ini belum ada peralatan yang siap dipinjamkan di dalam katalog.</p>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
function decrementQty(btn) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    const min = parseInt(input.min) || 1;
    if (parseInt(input.value) > min) input.value = parseInt(input.value) - 1;
}
function incrementQty(btn, max) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
}
</script>
@endpush
