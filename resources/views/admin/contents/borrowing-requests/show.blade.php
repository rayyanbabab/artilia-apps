@extends('admin.layouts.dashboard')

@section('title', 'Detail Permintaan Peminjaman')

@section('content')
<style>

html.dark .br-card { background-color: #1e293b !important; border-color: #334155 !important; }

html.dark .br-header-blue   { background: linear-gradient(to right, rgba(59,130,246,0.15), rgba(99,102,241,0.15)) !important; border-color: #334155 !important; }
html.dark .br-header-green  { background: linear-gradient(to right, rgba(16,185,129,0.15), rgba(5,150,105,0.15)) !important; border-color: #334155 !important; }
html.dark .br-header-purple { background: linear-gradient(to right, rgba(139,92,246,0.15), rgba(236,72,153,0.15)) !important; border-color: #334155 !important; }
html.dark .br-header-amber  { background: linear-gradient(to right, rgba(245,158,11,0.15), rgba(249,115,22,0.15)) !important; border-color: #334155 !important; }
html.dark .br-header-gray   { background: linear-gradient(to right, rgba(75,85,99,0.3), rgba(55,65,81,0.3)) !important; border-color: #334155 !important; }

html.dark .br-card-title { color: #e2e8f0 !important; }
html.dark .br-card-sub   { color: #64748b !important; }

html.dark .br-row-key { color: #64748b !important; }
html.dark .br-row-val { color: #e2e8f0 !important; }
html.dark .br-row-val-sm { color: #94a3b8 !important; }

html.dark .br-row-divider { border-color: #1f2937 !important; }

html.dark .br-page-title { color: #f1f5f9 !important; }
html.dark .br-page-sub   { color: #64748b !important; }

html.dark .br-badge-yellow { background-color: rgba(234,179,8,0.2) !important; color: #fde047 !important; }
html.dark .br-badge-green  { background-color: rgba(16,185,129,0.2) !important; color: #6ee7b7 !important; }
html.dark .br-badge-red    { background-color: rgba(239,68,68,0.2) !important; color: #fca5a5 !important; }
html.dark .br-badge-blue   { background-color: rgba(59,130,246,0.2) !important; color: #93c5fd !important; }
html.dark .br-badge-gray   { background-color: rgba(75,85,99,0.3) !important; color: #9ca3af !important; }

html.dark .br-info-green { background-color: rgba(16,185,129,0.1) !important; border-color: rgba(16,185,129,0.3) !important; }
html.dark .br-info-green p { color: #6ee7b7 !important; }
html.dark .br-info-blue  { background-color: rgba(59,130,246,0.1) !important; border-color: rgba(59,130,246,0.3) !important; }
html.dark .br-info-blue h4, html.dark .br-info-blue span { color: #93c5fd !important; }
html.dark .br-info-blue .br-row-divider-inner { border-color: rgba(59,130,246,0.2) !important; }
html.dark .br-info-red   { background-color: rgba(239,68,68,0.1) !important; border-color: rgba(239,68,68,0.3) !important; }
html.dark .br-info-red p { color: #fca5a5 !important; }

html.dark .br-admin-notes { background-color: rgba(37,99,235,0.12) !important; border-color: rgba(37,99,235,0.3) !important; }
html.dark .br-admin-notes h4 { color: #93c5fd !important; }
html.dark .br-admin-notes p  { color: #bfdbfe !important; }

html.dark .br-textarea {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #f1f5f9 !important;
}
html.dark .br-textarea::placeholder { color: #475569 !important; }
html.dark .br-textarea:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 2px rgba(59,130,246,0.3) !important; }

html.dark .br-btn-cancel { background-color: #1e293b !important; border-color: #334155 !important; color: #94a3b8 !important; }
html.dark .br-btn-cancel:hover { background-color: #334155 !important; }

html.dark .br-modal-label { color: #94a3b8 !important; }
html.dark .br-modal-hint  { color: #64748b !important; }

html.dark .br-modal-bg { background-color: #1e293b !important; }

html.dark .br-loc-text { color: #a5b4fc !important; }
html.dark .br-loc-badge { background-color: rgba(99,102,241,0.2) !important; color: #a5b4fc !important; }

html.dark .br-stok-badge { background-color: rgba(59,130,246,0.2) !important; color: #93c5fd !important; }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h1 class="br-page-title text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Detail Permintaan #{{ $request->id }}
                </h1>
                <p class="br-page-sub text-gray-600 mt-2">Informasi lengkap permintaan peminjaman dari {{ $request->user->name }}</p>
            </div>
            <div>
                <a href="{{ route($routePrefix . '.borrowing-requests.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="mb-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-6">
        @switch($request->status)
            @case('pending')
                <div class="br-badge-yellow inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Menunggu Persetujuan
                </div>
                @break
            @case('approved')
                <div class="br-badge-green inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Disetujui
                </div>
                @break
            @case('rejected')
                <div class="br-badge-red inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Ditolak
                </div>
                @break
            @case('completed')
                <div class="br-badge-blue inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Selesai
                </div>
                @break
            @case('cancelled')
                <div class="br-badge-gray inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Dibatalkan
                </div>
                @break
        @endswitch
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <div class="br-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="br-header-blue bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <h3 class="br-card-title text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Informasi Permintaan
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">ID Permintaan</span>
                        <span class="br-row-val text-sm font-bold text-gray-900">#{{ $request->id }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Pemohon</span>
                        <div class="text-right">
                            <div class="br-row-val text-sm font-bold text-gray-900">{{ $request->user->name }}</div>
                            <div class="br-row-val-sm text-xs text-gray-500">{{ $request->user->email }}</div>
                        </div>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Tanggal Ajukan</span>
                        <span class="br-row-val text-sm text-gray-900">{{ $request->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Jumlah</span>
                        <span class="br-row-val text-sm font-bold text-gray-900">{{ $request->jumlah }} pcs</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Tanggal Pinjam</span>
                        <span class="br-row-val text-sm text-gray-900">{{ $request->tanggal_pinjam->format('d/m/Y') }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Rencana Kembali</span>
                        <span class="br-row-val text-sm text-gray-900">{{ $request->tanggal_kembali_rencana->format('d/m/Y') }}</span>
                    </div>
                    @if($request->approved_by)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Diproses oleh</span>
                        <span class="text-sm text-gray-900">{{ $request->approvedBy->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600">Tanggal Diproses</span>
                        <span class="text-sm text-gray-900">{{ $request->approved_at ? $request->approved_at->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="br-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="br-header-green bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <h3 class="br-card-title text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Informasi Barang
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Nama Barang</span>
                        <span class="br-row-val text-sm font-bold text-gray-900">{{ $request->item->nama }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Supplier</span>
                        <span class="br-row-val text-sm text-gray-900">{{ $request->item->supplier->nama ?? 'N/A' }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Kategori</span>
                        <span class="br-row-val text-sm text-gray-900">{{ $request->item->category->nama ?? 'N/A' }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Kode Barang</span>
                        <span class="br-row-val text-sm font-bold text-gray-900">{{ $request->item->id ? 'ITM-' . str_pad($request->item->id, 4, '0', STR_PAD_LEFT) : 'N/A' }}</span>
                    </div>
                    <div class="br-row-divider flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Stok Peminjaman</span>
                        <span class="br-stok-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $request->item->stok_peminjaman }} tersedia
                        </span>
                    </div>
                    @if($request->item->location)
                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Lokasi Barang
                        </span>
                        <div class="text-right">
                            <div class="br-loc-text text-sm font-bold text-indigo-700">
                                @if($request->item->location->parent)
                                    {{ $request->item->location->parent->name }} &rsaquo; {{ $request->item->location->name }}
                                @else
                                    {{ $request->item->location->name }}
                                @endif
                            </div>
                            @if($request->item->location->kode)
                            <span class="br-loc-badge inline-block mt-0.5 text-[10px] font-bold font-mono bg-indigo-100 text-indigo-600 px-1.5 py-0.5 rounded">
                                {{ $request->item->location->kode }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($request->item->keterangan)
                    <div class="pt-2 border-t border-gray-100">
                        <span class="br-row-key text-sm font-medium text-gray-600">Deskripsi</span>
                        <p class="br-row-val text-sm text-gray-900 mt-1">{{ $request->item->keterangan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($request->keterangan || $request->kondisi_pinjam)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        @if($request->keterangan)
        <div class="br-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="br-header-purple bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <h3 class="br-card-title text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Keterangan/Tujuan Peminjaman
                </h3>
            </div>
            <div class="p-6">
                <p class="br-row-val text-gray-700 leading-relaxed">{{ $request->keterangan }}</p>
            </div>
        </div>
        @endif

        @if($request->kondisi_pinjam)
        <div class="br-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="br-header-amber bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-gray-100">
                <h3 class="br-card-title text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kondisi Barang Saat Dipinjam
                </h3>
            </div>
            <div class="p-6">
                <p class="br-row-val text-gray-700 leading-relaxed">{{ $request->kondisi_pinjam }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($request->admin_notes)
    <div class="mb-8">
        <div class="br-admin-notes bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-blue-900 mb-2">Catatan Admin</h4>
                    <p class="text-blue-800 leading-relaxed">{{ $request->admin_notes }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($request->status === 'pending')
    <div class="br-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="br-header-gray bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
            <h3 class="br-card-title text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                </svg>
                Tindakan Admin
            </h3>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button type="button"
                        onclick="openApproveModal({{ $request->id }}, '{{ $request->user->name }}', '{{ $request->item->nama }}')"
                        class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Setujui Permintaan
                </button>
                <button type="button"
                        onclick="openRejectModal({{ $request->id }}, '{{ $request->user->name }}', '{{ $request->item->nama }}')"
                        class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Permintaan
                </button>
            </div>
        </div>
    </div>

    <div id="approveModal" class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm overflow-y-auto hidden z-[9999]" role="dialog" aria-modal="true">
        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
            <div class="relative transform text-left bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 max-w-lg w-full flex flex-col max-h-[85vh] my-auto overflow-hidden animate-in">

                <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-gray-50/70 dark:bg-slate-850">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Setujui Permintaan Peminjaman</h3>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Konfirmasi persetujuan & alokasi stok peminjaman</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeApproveModal()" class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition" title="Tutup Modal (Esc)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form id="approveForm" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                    @csrf
                    <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">

                        <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm leading-relaxed flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p id="approveText" class="font-medium"></p>
                        </div>

                        <div class="p-4 rounded-xl bg-blue-50/70 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/40">
                            <h4 class="text-xs font-bold text-blue-900 dark:text-blue-300 mb-2.5 flex items-center gap-1.5 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Analisis Ketersediaan Stok
                            </h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between items-center py-1 border-b border-blue-100 dark:border-blue-900/40">
                                    <span class="text-gray-600 dark:text-slate-400">Stok Peminjaman Saat Ini</span>
                                    <span class="font-bold text-gray-900 dark:text-white font-mono">{{ $request->item->stok_peminjaman }} pcs</span>
                                </div>
                                <div class="flex justify-between items-center py-1 border-b border-blue-100 dark:border-blue-900/40">
                                    <span class="text-gray-600 dark:text-slate-400">Jumlah Diminta</span>
                                    <span class="font-bold text-blue-600 dark:text-blue-400 font-mono">{{ $request->jumlah }} pcs</span>
                                </div>
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-gray-600 dark:text-slate-400">Sisa Stok Pasca-Approval</span>
                                    <span class="font-bold font-mono {{ ($request->item->stok_peminjaman - $request->jumlah) >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $request->item->stok_peminjaman - $request->jumlah }} pcs
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="approve_admin_notes" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">
                                Catatan Admin (Opsional)
                            </label>
                            <textarea id="approve_admin_notes" name="admin_notes" rows="3"
                                      class="w-full text-xs sm:text-sm rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white p-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-none placeholder-gray-400 dark:placeholder-slate-500"
                                      placeholder="Tambahkan catatan atau instruksi khusus untuk peminjam..."></textarea>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Catatan ini akan dikirimkan kepada peminjam sebagai notifikasi.</p>
                        </div>
                    </div>

                    <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                        <button type="button" onclick="closeApproveModal()"
                                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 rounded-xl shadow-md shadow-emerald-500/25 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setujui Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 bg-gray-950/60 backdrop-blur-sm overflow-y-auto hidden z-[9999]" role="dialog" aria-modal="true">
        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 text-center">
            <div class="relative transform text-left bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 max-w-lg w-full flex flex-col max-h-[85vh] my-auto overflow-hidden animate-in">

                <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-gray-50/70 dark:bg-slate-850">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-tight">Tolak Permintaan Peminjaman</h3>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">Berikan alasan resmi penolakan permohonan</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeRejectModal()" class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition" title="Tutup Modal (Esc)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form id="rejectForm" method="POST" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                    @csrf
                    <div class="p-5 sm:p-6 overflow-y-auto min-h-0 space-y-4 flex-1">
                        <div class="p-3.5 rounded-xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800/40 text-rose-800 dark:text-rose-300 text-xs sm:text-sm leading-relaxed flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-rose-600 dark:text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p id="rejectText" class="font-medium"></p>
                        </div>

                        <div>
                            <label for="reject_admin_notes" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">
                                Alasan Penolakan <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="reject_admin_notes" name="admin_notes" rows="3" required
                                      class="w-full text-xs sm:text-sm rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white p-3 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition resize-none placeholder-gray-400 dark:placeholder-slate-500"
                                      placeholder="Jelaskan dengan detail alasan penolakan permintaan ini..."></textarea>
                            <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Alasan ini akan dikirimkan kepada peminjam sebagai notifikasi.</p>
                        </div>
                    </div>

                    <div class="px-5 py-3.5 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-slate-800 bg-gray-50/80 dark:bg-slate-850 flex items-center justify-end gap-2.5 flex-shrink-0">
                        <button type="button" onclick="closeRejectModal()"
                                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-200/60 dark:hover:bg-slate-800 rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 active:scale-95 rounded-xl shadow-md shadow-rose-500/25 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif($request->status === 'approved')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tindakan Lanjutan
            </h3>
        </div>
        <div class="p-6">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-green-800">Status: Permintaan Disetujui</p>
                        <p class="text-sm text-green-700">User dapat mengambil barang sesuai jadwal yang telah ditentukan.</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-center gap-3 flex-wrap">

                <a href="{{ route($routePrefix . '.borrowing-requests.bap', $request->id) }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Buka BAP Digital
                </a>

                <a href="{{ route($routePrefix . '.defect-scanner.scan-br', $request->id) }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-700 hover:from-violet-700 hover:to-purple-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.867V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Inspeksi Cacat AI
                </a>
                <button type="button" onclick="openModal('complete-req-{{ $request->id }}')"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Selesaikan Peminjaman
                </button>
            </div>
        </div>
    </div>
    @endif

    @if(in_array($request->status, ['completed', 'approved']) && $request->isSigned())
    <div class="br-card mt-6 bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-50/80 to-blue-50/80 px-6 py-4 border-b border-indigo-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-indigo-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Berita Acara Peminjaman (BAP) Digital Ditandatangani
            </h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                Terverifikasi
            </span>
        </div>
        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
            <div class="space-y-1 text-sm">
                <p class="text-gray-900">No. BAP: <strong class="font-mono text-indigo-700 font-bold">{{ $request->bap_number }}</strong></p>
                <p class="text-gray-600 text-xs">Ditandatangani oleh <strong class="text-gray-800">{{ $request->signed_by_name }}</strong> pada {{ $request->signed_at?->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
            </div>
            <a href="{{ route($routePrefix . '.borrowing-requests.bap', $request->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat & Cetak BAP
            </a>
        </div>
    </div>
    @endif

</div>
</div>

@endsection

@push('scripts')
    @if($request->status === 'approved')
        <x-popup id="complete-req-{{ $request->id }}" title="Selesaikan Peminjaman"
            message="Yakin ingin menyelesaikan peminjaman ini? Stok akan dikembalikan."
            formId="complete-req-form-{{ $request->id }}"
            confirmText="Selesaikan"
            confirmClass="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg"
            cancelText="Batal" />
        <form id="complete-req-form-{{ $request->id }}" action="{{ route($routePrefix . '.borrowing-requests.complete', $request->id) }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endif
<script>
function openApproveModal(id, userName, itemName) {
    const el = document.getElementById('approveModal');
    if (!el) return;
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    const form = document.getElementById('approveForm');
    form.action = `/admin/borrowing-requests/${id}/approve`;
    document.getElementById('approveText').textContent = `Setujui permintaan peminjaman dari ${userName} untuk ${itemName}?`;
    el.classList.remove('hidden');
}

function closeApproveModal() {
    const el = document.getElementById('approveModal');
    if (el) el.classList.add('hidden');
    const notes = document.getElementById('approve_admin_notes');
    if (notes) notes.value = '';
}

function openRejectModal(id, userName, itemName) {
    const el = document.getElementById('rejectModal');
    if (!el) return;
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    const form = document.getElementById('rejectForm');
    form.action = `/admin/borrowing-requests/${id}/reject`;
    document.getElementById('rejectText').textContent = `Tolak permintaan peminjaman dari ${userName} untuk ${itemName}?`;
    el.classList.remove('hidden');
}

function closeRejectModal() {
    const el = document.getElementById('rejectModal');
    if (el) el.classList.add('hidden');
    const notes = document.getElementById('reject_admin_notes');
    if (notes) notes.value = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
    }
});
</script>
@endpush
