@extends('admin.layouts.dashboard')
@section('title', 'Riwayat Inspeksi Visual — AI Defect Scanner')
@section('content')
<style>
html.dark .ds-card { background:#1e293b !important; border-color:#334155 !important; }
html.dark .ds-title{ color:#f1f5f9 !important; }
html.dark .ds-sub  { color:#94a3b8 !important; }
html.dark .ds-th   { background:#0f172a !important; color:#94a3b8 !important; border-color:#1f2937 !important; }
html.dark .ds-tr:hover { background:rgba(51,65,85,.4) !important; }
html.dark .ds-td   { color:#e2e8f0 !important; border-color:#1f2937 !important; }
html.dark .ds-input{ background:#0f172a !important; border-color:#334155 !important; color:#f1f5f9 !important; }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-violet-600 via-cyan-500 to-emerald-500"></div>
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-600 to-cyan-500 flex items-center justify-center shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h1 class="ds-title text-2xl font-bold text-gray-900">Riwayat Inspeksi Visual</h1>
                    <p class="ds-sub text-sm text-gray-500 mt-0.5">Log hasil AI Defect & Wear Scanner</p>
                </div>
            </div>
            <a href="{{ route($routePrefix . '.defect-scanner.scan') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-cyan-600 hover:from-violet-700 hover:to-cyan-700 text-white text-sm font-bold rounded-xl transition shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Scan Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php
        $statCards = [
            ['label'=>'Total Inspeksi', 'value'=>$stats['total'],    'color'=>'text-violet-700', 'bg'=>'bg-violet-50',  'border'=>'border-violet-200'],
            ['label'=>'Kondisi OK',     'value'=>$stats['ok'],       'color'=>'text-emerald-700','bg'=>'bg-emerald-50', 'border'=>'border-emerald-200'],
            ['label'=>'Cacat Terdeteksi','value'=>$stats['defective'],'color'=>'text-red-700',   'bg'=>'bg-red-50',     'border'=>'border-red-200'],
            ['label'=>'BAK Diterbitkan','value'=>$stats['bak'],      'color'=>'text-orange-700', 'bg'=>'bg-orange-50',  'border'=>'border-orange-200'],
        ];
        @endphp
        @foreach($statCards as $sc)
        <div class="ds-card {{ $sc['bg'] }} rounded-2xl border {{ $sc['border'] }} p-4 text-center">
            <div class="text-3xl font-extrabold {{ $sc['color'] }}">{{ $sc['value'] }}</div>
            <div class="text-xs font-semibold text-gray-600 mt-1">{{ $sc['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap gap-3 items-center">
            <form method="GET" class="flex flex-wrap gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                       class="ds-input px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-violet-500 focus:border-violet-500 w-48">
                <select name="verdict" onchange="this.form.submit()"
                        class="ds-input px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-violet-500">
                    <option value="">Semua Verdict</option>
                    <option value="ok"         {{ request('verdict')=='ok'?'selected':'' }}>Kondisi Baik</option>
                    <option value="minor_wear" {{ request('verdict')=='minor_wear'?'selected':'' }}>Aus Ringan</option>
                    <option value="damaged"    {{ request('verdict')=='damaged'?'selected':'' }}>Rusak</option>
                    <option value="critical"   {{ request('verdict')=='critical'?'selected':'' }}>Kritis</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl transition">Filter</button>
                @if(request()->hasAny(['search','verdict']))
                    <a href="{{ route($routePrefix.'.defect-scanner.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm rounded-xl transition">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="ds-th">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">#ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Barang</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Verdict AI</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Keausan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Keyakinan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Inspektor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100">BAK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider bg-gray-50 text-gray-500 border-b border-gray-100"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($inspections as $ins)
                    @php $badge = $ins->verdict_badge; @endphp
                    <tr class="ds-tr hover:bg-gray-50/60 transition-colors">
                        <td class="ds-td px-4 py-3 font-mono text-xs text-gray-500">#{{ $ins->id }}</td>
                        <td class="ds-td px-4 py-3">
                            <div class="font-semibold text-gray-900">{{ $ins->item->nama ?? '—' }}</div>
                            @if($ins->borrowingRequest)
                            <div class="text-xs text-gray-400">BR #{{ $ins->borrowingRequest->id }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $ins->wear_percentage > 70 ? 'bg-red-500' : ($ins->wear_percentage > 40 ? 'bg-yellow-500' : 'bg-emerald-500') }}"
                                         style="width:{{ $ins->wear_percentage }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-700">{{ $ins->wear_percentage }}%</span>
                            </div>
                        </td>
                        <td class="ds-td px-4 py-3 text-sm font-medium text-violet-700">{{ $ins->defect_confidence }}%</td>
                        <td class="ds-td px-4 py-3 text-xs text-gray-600">{{ $ins->inspector->name ?? '—' }}</td>
                        <td class="ds-td px-4 py-3 text-xs text-gray-500">{{ $ins->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($ins->bak_issued)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">{{ $ins->bak_number }}</span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route($routePrefix.'.defect-scanner.show', $ins->id) }}"
                               class="text-violet-600 hover:text-violet-800 text-xs font-semibold">Detail →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p class="font-medium">Belum ada data inspeksi</p>
                            <a href="{{ route($routePrefix.'.defect-scanner.scan') }}" class="text-violet-600 hover:underline text-sm mt-1 inline-block">Mulai scan pertama →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inspections->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $inspections->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
