@extends('user.layouts.dashboard-user')

@section('title', 'Permintaan Pengadaan Saya')

@section('user')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Pengadaan Inventaris
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Permintaan Pengadaan</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400 mt-0.5">Ajukan permintaan barang atau perkakas baru yang belum tersedia di bengkel</p>
        </div>
        <a href="{{ route('user.procurement.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-md shadow-orange-500/20 hover:shadow-orange-500/30 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Ajukan Pengadaan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm px-4 py-3 rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-3 sm:gap-4">
        @php
            $pending  = (int)($counts['pending']  ?? 0);
            $approved = (int)($counts['approved'] ?? 0);
            $rejected = (int)($counts['rejected'] ?? 0);
        @endphp
        <div class="relative overflow-hidden bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-4 sm:p-5 text-center transition-all hover:shadow-md">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-yellow-500"></div>
            <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 dark:text-amber-400 tracking-tight">{{ $pending }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Pending Review</p>
        </div>
        <div class="relative overflow-hidden bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-4 sm:p-5 text-center transition-all hover:shadow-md">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
            <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $approved }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Disetujui</p>
        </div>
        <div class="relative overflow-hidden bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm p-4 sm:p-5 text-center transition-all hover:shadow-md">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-rose-400 to-red-500"></div>
            <p class="text-2xl sm:text-3xl font-extrabold text-rose-500 dark:text-rose-400 tracking-tight">{{ $rejected }}</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-1">Ditolak</p>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($procurements as $item)
            <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm hover:border-orange-200 dark:hover:border-orange-500/30 hover:shadow-md transition-all duration-200 p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-start gap-3.5 flex-1 min-w-0">
                        <div class="w-11 h-11 bg-orange-50 dark:bg-orange-500/10 rounded-xl flex items-center justify-center flex-shrink-0 border border-orange-100/50 dark:border-orange-500/20">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm truncate">{{ $item->nama_barang }}</h3>
                                <span class="text-xs text-gray-400 dark:text-slate-500">• {{ $item->created_at->locale('id')->isoFormat('D MMM YYYY') }}</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                <span class="inline-flex items-center gap-1 text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-2 py-0.5 rounded-md font-medium">
                                    <svg class="w-3 h-3 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                    {{ $item->jumlah }} unit
                                </span>
                                @if($item->alasan)
                                    <span class="text-xs text-gray-500 dark:text-slate-400 truncate max-w-xs">{{ $item->alasan }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-3 pt-3 sm:pt-0 border-t sm:border-t-0 border-gray-100 dark:border-slate-800">

                        @if($item->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Review
                            </span>
                        @elseif($item->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/50">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800/50">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                Ditolak
                            </span>
                        @endif

                        <a href="{{ route('user.procurement.show', $item->id) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-slate-200 bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-slate-700 rounded-xl transition-colors">
                            <span>Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm py-16 text-center px-4">
                <div class="w-16 h-16 bg-orange-50 dark:bg-orange-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-orange-100 dark:border-orange-500/20">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-base font-semibold text-gray-800 dark:text-slate-200 mb-1">Belum ada permintaan pengadaan</p>
                <p class="text-xs sm:text-sm text-gray-400 dark:text-slate-400 max-w-sm mx-auto mb-6">Ajukan permintaan jika Anda membutuhkan peralatan atau consumable yang belum terdaftar di bengkel</p>
                <a href="{{ route('user.procurement.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 rounded-xl shadow-md shadow-orange-500/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajukan Permintaan Pertama
                </a>
            </div>
        @endforelse
    </div>

    @if($procurements->hasPages())
        <div class="mt-4">{{ $procurements->links() }}</div>
    @endif

</div>
@endsection
