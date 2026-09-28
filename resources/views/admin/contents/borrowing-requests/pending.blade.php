@extends('admin.layouts.dashboard')
@section('title', 'Permintaan Peminjaman Pending')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Permintaan Pending</h1>
                <p class="text-gray-600 mt-2">Permintaan peminjaman yang menunggu persetujuan</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route($routePrefix . '.borrowing-requests.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Semua Permintaan</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
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

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Ajukan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($requests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $request->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->item->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->item->supplier->nama ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->jumlah }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->tanggal_pinjam->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $request->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route($routePrefix . '.borrowing-requests.show', $request->id) }}"
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <button type="button"
                                                    class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded-lg transition-colors"
                                                    onclick="openApproveModal({{ $request->id }}, '{{ $request->user->name }}', '{{ $request->item->nama }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                            <button type="button"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                                    onclick="openRejectModal({{ $request->id }}, '{{ $request->user->name }}', '{{ $request->item->nama }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-6">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada permintaan pending</h3>
                    <p class="text-gray-500">Semua permintaan peminjaman sudah diproses.</p>
                </div>
            @endif
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

                    <div>
                        <label for="approve_admin_notes" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">
                            Catatan Admin (Opsional)
                        </label>
                        <textarea id="approve_admin_notes" name="admin_notes" rows="3"
                                  class="w-full text-xs sm:text-sm rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800 text-gray-900 dark:text-white p-3 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-none placeholder-gray-400 dark:placeholder-slate-500"
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
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
                                  placeholder="Jelaskan alasan penolakan secara jelas..."></textarea>
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
@endsection

@push('scripts')
<script>
function openApproveModal(id, userName, itemName) {
    const el = document.getElementById('approveModal');
    if (!el) return;
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    const form = document.getElementById('approveForm');
    form.action = `/admin/borrowing-requests/${id}/approve`;
    document.getElementById('approveText').textContent = `Setujui permintaan peminjaman dari ${userName} untuk barang ${itemName}?`;
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
    document.getElementById('rejectText').textContent = `Tolak permintaan peminjaman dari ${userName} untuk barang ${itemName}?`;
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
