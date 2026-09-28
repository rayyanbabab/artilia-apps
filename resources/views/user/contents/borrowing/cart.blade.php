@extends('user.layouts.dashboard-user')

@section('title', 'Keranjang Peminjaman')

@section('user')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 rounded-full px-3 py-1">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                    Keranjang Aktif
                </span>
                <span class="text-xs text-gray-400 dark:text-slate-400">
                    {{ $cartItems->count() }} item terpilih
                </span>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Keranjang Peminjaman</h1>
            <p class="text-sm text-gray-400 dark:text-slate-400 mt-1">Periksa kembali daftar peralatan dan tentukan tanggal peminjaman sebelum checkout</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
            <a href="{{ route('user.borrowing.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Alat Lain
            </a>
            <a href="{{ route('user.borrowing.my-requests') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Status Pengajuan
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

    @if($cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Barang ({{ $cartItems->count() }})</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-400">Peralatan yang telah kamu pilih dari katalog</p>
                    </div>
                    <form id="empty-cart-form" action="{{ route('user.borrowing.cart.clear') }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition-colors" onclick="openModal('modal-empty-cart')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Kosongkan Keranjang
                    </button>
                </div>
                <div class="p-5 space-y-3.5">
                    @foreach($cartItems as $cartItem)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl border border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/40 hover:bg-gray-50 dark:hover:bg-slate-800/70 transition-all">

                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-100 dark:bg-slate-700 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-700">
                                @if($cartItem->item->gambar)
                                    <img src="{{ asset($cartItem->item->gambar) }}" alt="{{ $cartItem->item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $cartItem->item->nama }}</h4>
                                <p class="text-xs text-gray-400 dark:text-slate-400 mt-0.5">
                                    Stok tersedia: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $cartItem->item->stok_peminjaman }} unit</span>
                                </p>
                                @if($cartItem->item->category)
                                    <span class="inline-block mt-1 text-[10px] font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/40 px-2 py-0.2 rounded">
                                        {{ $cartItem->item->category->nama }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-3 flex-shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100 dark:border-slate-700/50">
                            <form action="{{ route('user.borrowing.cart.update', $cartItem->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden bg-white dark:bg-slate-900">
                                    <input type="number" name="jumlah" value="{{ $cartItem->jumlah }}" min="1" max="{{ $cartItem->item->stok_peminjaman }}"
                                           class="w-16 px-2.5 py-1 text-center text-xs font-bold text-gray-900 dark:text-white bg-transparent border-0 focus:ring-0">
                                </div>
                                <button type="submit" class="px-2.5 py-1 text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/40 rounded-xl transition-colors">
                                    Update
                                </button>
                            </form>

                            <form id="remove-cart-item-{{ $cartItem->id }}" action="{{ route('user.borrowing.cart.remove', $cartItem->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition-colors border border-gray-200 dark:border-slate-700 hover:border-rose-200"
                                    title="Hapus dari keranjang"
                                    onclick="openModal('modal-remove-item-{{ $cartItem->id }}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden sticky top-20">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Formulir Pengajuan</h3>
                    <p class="text-xs text-gray-400 dark:text-slate-400">Lengkapi data rencana penggunaan</p>
                </div>
                <form action="{{ route('user.borrowing.cart.checkout') }}" method="POST" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label for="tanggal_pinjam" class="block text-xs font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Tanggal Pinjam <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               class="w-full text-xs font-semibold px-3 py-2 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50/50 dark:bg-slate-900 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition"
                               id="tanggal_pinjam"
                               name="tanggal_pinjam"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                               required>
                    </div>

                    <div>
                        <label for="tanggal_kembali_rencana" class="block text-xs font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Rencana Kembali <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               class="w-full text-xs font-semibold px-3 py-2 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50/50 dark:bg-slate-900 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition"
                               id="tanggal_kembali_rencana"
                               name="tanggal_kembali_rencana"
                               value="{{ old('tanggal_kembali_rencana') }}"
                               required>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">
                            💡 Batas peminjaman maksimal <strong>{{ $maxBorrowDays }} hari</strong>.
                        </p>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-xs font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Keperluan / Tujuan Pinjam
                        </label>
                        <textarea class="w-full text-xs px-3 py-2 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50/50 dark:bg-slate-900 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition resize-none"
                                  id="keterangan"
                                  name="keterangan"
                                  rows="2"
                                  placeholder="Contoh: Praktikum permesinan CNC...">{{ old('keterangan') }}</textarea>
                    </div>

                    <div>
                        <label for="kondisi_pinjam" class="block text-xs font-bold text-gray-700 dark:text-slate-300 mb-1">
                            Kondisi Awal Alat (Opsional)
                        </label>
                        <textarea class="w-full text-xs px-3 py-2 border border-gray-200 dark:border-slate-700 rounded-xl bg-gray-50/50 dark:bg-slate-900 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 transition resize-none"
                                  id="kondisi_pinjam"
                                  name="kondisi_pinjam"
                                  rows="2"
                                  placeholder="Catatan kondisi awal jika ada...">{{ old('kondisi_pinjam') }}</textarea>
                    </div>

                    <div class="border-t border-gray-100 dark:border-slate-800 pt-3.5 space-y-2">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Total Macam Barang:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $cartItems->count() }} item</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 dark:text-slate-400">
                            <span>Total Unit Pinjam:</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">{{ $cartItems->sum('jumlah') }} unit</span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/25 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Semua Pengajuan Pinjam
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else

    <div class="bg-white dark:bg-slate-850 rounded-2xl border border-gray-100 dark:border-slate-800 p-12 sm:p-16 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Keranjang Masih Kosong</h3>
        <p class="text-xs text-gray-400 dark:text-slate-400 mb-6 max-w-sm mx-auto">Kamu belum menambahkan alat atau perkakas apapun ke dalam keranjang peminjaman.</p>
        <a href="{{ route('user.borrowing.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Buka Katalog Alat
        </a>
    </div>
    @endif
</div>

@push('scripts')
@if($cartItems->count() > 0)
    <x-popup id="modal-empty-cart" title="Kosongkan Keranjang"
        message="Apakah kamu yakin ingin mengosongkan seluruh isi keranjang?"
        formId="empty-cart-form"
        confirmText="Ya, Kosongkan"
        confirmClass="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition-colors shadow-sm"
        cancelText="Batal" />

    @foreach($cartItems as $cartItem)
        <x-popup id="modal-remove-item-{{ $cartItem->id }}" title="Hapus Barang"
            message="Hapus alat '{{ $cartItem->item->nama }}' dari keranjang?"
            formId="remove-cart-item-{{ $cartItem->id }}"
            confirmText="Ya, Hapus"
            confirmClass="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition-colors shadow-sm"
            cancelText="Batal" />
    @endforeach
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalPinjam  = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali_rencana');
    const maxBorrowDays  = {{ $maxBorrowDays ?? 7 }};

    function updateReturnDate() {
        if (!tanggalPinjam || !tanggalKembali || !tanggalPinjam.value) return;
        const pinjam  = new Date(tanggalPinjam.value);

        const minDate = new Date(pinjam);
        minDate.setDate(minDate.getDate() + 1);
        tanggalKembali.min = minDate.toISOString().split('T')[0];

        const maxDate = new Date(pinjam);
        maxDate.setDate(maxDate.getDate() + maxBorrowDays);
        tanggalKembali.max = maxDate.toISOString().split('T')[0];

        if (!tanggalKembali.dataset.userEdited || !tanggalKembali.value || new Date(tanggalKembali.value) <= pinjam) {
            tanggalKembali.value = maxDate.toISOString().split('T')[0];
        }
    }

    if (tanggalPinjam && tanggalKembali) {
        tanggalPinjam.addEventListener('change', updateReturnDate);
        tanggalKembali.addEventListener('change', function() {
            this.dataset.userEdited = '1';
        });
        updateReturnDate();
    }
});
</script>
@endpush
@endsection
