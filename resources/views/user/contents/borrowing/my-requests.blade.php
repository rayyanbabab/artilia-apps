@extends('user.layouts.dashboard-user')

@section('title', 'Status Peminjaman Saya')

@section('user')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 rounded-full px-3 py-1">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                    Permintaan Aktif
                </span>
                <span class="text-xs text-gray-400 dark:text-slate-400">
                    {{ method_exists($requests, 'total') ? $requests->total() : count($requests) }} total pengajuan
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Status Peminjaman Saya</h1>
            <p class="text-sm text-gray-400 dark:text-slate-400 mt-1">Lacak status persetujuan, barang yang sedang dipinjam, dan jadwal pengembalian</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
            <a href="{{ route('user.borrowing.history') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Selesai
            </a>
            <a href="{{ route('user.borrowing.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Pinjam Alat Lain
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

    <div>
        @if($requests->count() > 0)
            <div class="space-y-3">
                @foreach($requests as $request)
                    <div class="bg-white dark:bg-slate-850 border border-gray-100 dark:border-slate-800 rounded-2xl p-5 hover:border-blue-200 dark:hover:border-blue-900 shadow-sm hover:shadow-md transition-all">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-4">

                                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 flex items-center justify-center flex-shrink-0 text-blue-600 dark:text-blue-400 shadow-sm">
                                        @if($request->item?->gambar)
                                            <img src="{{ asset($request->item->gambar) }}" alt="{{ $request->item->nama }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $request->item?->nama ?? '-' }}</h3>
                                            @if($request->item?->kode_barang ?? $request->item?->kode)
                                                <span class="text-[10px] font-mono text-gray-400 bg-gray-100 dark:bg-slate-800 px-2 py-0.2 rounded">
                                                    {{ $request->item?->kode_barang ?? $request->item?->kode }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2 mt-2">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                {{ $request->jumlah }} unit
                                            </span>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-medium bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $request->tanggal_pinjam->format('d M') }} &ndash; {{ $request->tanggal_kembali_rencana->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-gray-400 dark:text-slate-400 mt-1.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Diajukan: {{ $request->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-row lg:flex-col items-center lg:items-end justify-between lg:justify-center gap-2.5 pt-3 lg:pt-0 border-t lg:border-t-0 border-gray-100 dark:border-slate-800">

                                @switch($request->status)
                                    @case('pending')
                                        @if($request->tanggal_pinjam->lt(today()))
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/40">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Kedaluwarsa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/40">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Persetujuan
                                            </span>
                                        @endif
                                        @break
                                    @case('approved')
                                        @if($request->tanggal_kembali_rencana->isPast())
                                            @php
                                                $daysLate = (int) ceil($request->tanggal_kembali_rencana->diffInDays(now(), true));
                                                $daysLate = max(1, $daysLate);
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/30 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/40">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                                Terlambat {{ $daysLate }} hari
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Disetujui (Sedang Dipinjam)
                                            </span>
                                        @endif
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/30 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-700">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                @endswitch

                                <a href="{{ route('user.borrowing.show', $request->id) }}"
                                   class="inline-flex items-center gap-1 px-3.5 py-1.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-xl text-xs font-bold text-gray-700 dark:text-slate-200 transition-colors shadow-sm">
                                    Detail &amp; BAP
                                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 py-14 px-6 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto mb-4 bg-blue-50 dark:bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Belum Ada Pengajuan Peminjaman</h3>
                <p class="text-xs text-gray-400 dark:text-slate-400 mb-6 max-w-sm mx-auto">Kamu belum memiliki permintaan peminjaman alat yang sedang aktif.</p>
                <a href="{{ route('user.borrowing.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Peminjaman Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
