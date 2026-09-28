@extends('admin.layouts.dashboard')
@section('title', 'Detail Inspeksi #' . $inspection->id)
@section('content')
<style>
html.dark .ds-card { background:#1e293b !important; border-color:#334155 !important; }
html.dark .ds-title{ color:#f1f5f9 !important; }
html.dark .ds-sub  { color:#94a3b8 !important; }
html.dark .ds-row-key { color:#64748b !important; }
html.dark .ds-row-val { color:#e2e8f0 !important; }
html.dark .ds-divider { border-color:#1f2937 !important; }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
        <div>
            <h1 class="ds-title text-2xl font-bold text-gray-900 flex items-center gap-2">
                Hasil Inspeksi #{{ $inspection->id }}
                @php $badge = $inspection->verdict_badge; @endphp
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['class'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>{{ $badge['label'] }}
                </span>
            </h1>
            <p class="ds-sub text-sm text-gray-500 mt-1">{{ $inspection->created_at->format('d F Y, H:i') }} WIB · Inspektor: {{ $inspection->inspector->name }}</p>
        </div>
        <div class="flex gap-2">
            @if($inspection->isDefective() && !$inspection->bak_issued)
            <form action="{{ route($routePrefix.'.defect-scanner.issue-bak', $inspection->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition shadow">
                    🗋 Terbitkan BAK
                </button>
            </form>
            @elseif($inspection->bak_issued)
            <a href="{{ route($routePrefix.'.defect-scanner.bak', $inspection->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl transition shadow">
                🖨 Cetak BAK
            </a>
            @endif
            <a href="{{ route($routePrefix.'.defect-scanner.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">
                ← Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-slate-50">
                <h3 class="ds-title text-base font-bold text-gray-800">📷 Foto Bukti Inspeksi</h3>
            </div>
            <div class="p-5">
                @if($inspection->image_path)
                    <img src="{{ asset($inspection->image_path) }}" alt="Bukti Inspeksi"
                         class="w-full rounded-xl object-cover border border-gray-200 max-h-72">
                @else
                    <div class="w-full h-48 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                        <span class="text-sm">Tidak ada foto</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-4">

            <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="ds-title text-base font-bold text-gray-800">🤖 Hasil Analisis AI</h3>

                <div>
                    <div class="flex justify-between text-xs mb-1.5 font-medium">
                        <span class="text-gray-500">Estimasi Keausan</span>
                        <span class="font-bold {{ $inspection->wear_percentage > 70 ? 'text-red-600' : ($inspection->wear_percentage > 40 ? 'text-yellow-600' : 'text-emerald-600') }}">{{ $inspection->wear_percentage }}%</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $inspection->wear_percentage > 70 ? 'bg-red-500' : ($inspection->wear_percentage > 40 ? 'bg-yellow-500' : 'bg-emerald-500') }}"
                             style="width:{{ $inspection->wear_percentage }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs mb-1.5 font-medium">
                        <span class="text-gray-500">Keyakinan Model AI</span>
                        <span class="font-bold text-violet-700">{{ $inspection->defect_confidence }}%</span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-violet-400 to-cyan-500"
                             style="width:{{ $inspection->defect_confidence }}%"></div>
                    </div>
                </div>

                @if(!empty($inspection->defect_types))
                <div>
                    <p class="text-xs font-semibold text-gray-600 mb-2">Jenis Cacat:</p>
                    <div class="flex flex-wrap gap-1.5">
                        @php $tagColors = ['chip'=>'bg-red-100 text-red-700','crack'=>'bg-orange-100 text-orange-700','corrosion'=>'bg-purple-100 text-purple-700','wear'=>'bg-yellow-100 text-yellow-700']; @endphp
                        @foreach($inspection->defect_types as $t)
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $tagColors[$t] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ['chip'=>'Gompal/Chip','crack'=>'Retak/Crack','corrosion'=>'Korosi','wear'=>'Keausan'][$t] ?? $t }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($inspection->scan_metrics))
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <div class="text-[10px] text-gray-400">Edge Density</div>
                        <div class="text-sm font-bold text-gray-700">{{ $inspection->scan_metrics['edgeDensity'] ?? '—' }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <div class="text-[10px] text-gray-400">Contrast σ</div>
                        <div class="text-sm font-bold text-gray-700">{{ $inspection->scan_metrics['contrastVariance'] ?? '—' }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <div class="text-[10px] text-gray-400">Scan Time</div>
                        <div class="text-sm font-bold text-gray-700">{{ $inspection->scan_duration_ms ?? '—' }}ms</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="ds-title text-base font-bold text-gray-800 mb-3">📦 Info Barang</h3>
                <div class="space-y-2 text-sm">
                    <div class="ds-divider flex justify-between py-1.5 border-b border-gray-50">
                        <span class="ds-row-key text-gray-500">Nama Barang</span>
                        <span class="ds-row-val font-semibold text-gray-900">{{ $inspection->item->nama }}</span>
                    </div>
                    <div class="ds-divider flex justify-between py-1.5 border-b border-gray-50">
                        <span class="ds-row-key text-gray-500">Kategori</span>
                        <span class="ds-row-val text-gray-900">{{ $inspection->item->category->nama ?? '—' }}</span>
                    </div>
                    <div class="ds-divider flex justify-between py-1.5 border-b border-gray-50">
                        <span class="ds-row-key text-gray-500">Tahap Inspeksi</span>
                        <span class="ds-row-val text-gray-900">{{ $inspection->inspection_stage === 'return' ? 'Saat Pengembalian' : 'Saat Peminjaman' }}</span>
                    </div>
                    @if($inspection->borrowingRequest)
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="text-gray-500">Peminjam</span>
                        <span class="text-gray-900">{{ $inspection->borrowingRequest->user->name }}</span>
                    </div>
                    @endif
                    @if($inspection->notes)
                    <div class="pt-2">
                        <span class="text-gray-500 text-xs">Catatan:</span>
                        <p class="text-gray-800 mt-1 text-sm italic">"{{ $inspection->notes }}"</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($inspection->maintenance_triggered && $inspection->maintenance)
    <div class="ds-card bg-orange-50 border border-orange-200 rounded-2xl p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">!</div>
            <div>
                <div class="font-bold text-orange-900">Maintenance Otomatis Dibuat</div>
                <div class="text-sm text-orange-700">ID: #{{ $inspection->maintenance_id }} · {{ $inspection->maintenance->description }}</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
