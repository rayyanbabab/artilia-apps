@props([
    'filter' => null,
    'routePrefix' => null,
])

@php
    $rp = $routePrefix ?? (auth()->user()?->role instanceof \App\Enums\UsersRole ? (auth()->user()->role->value === 'operator' ? 'staff' : 'admin') : ((string)(auth()->user()?->role ?? '') === 'operator' ? 'staff' : 'admin'));
    $activeFilter = $filter ?? null;
@endphp

<div class="mb-5 space-y-4">
    <!-- Header Row -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Log Mutasi & Kondisi Barang</h2>
                @if($activeFilter)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                        Filter: {{ ucfirst($activeFilter) }}
                        <a href="{{ route($rp . '.inventory.tab.history') }}" class="ml-1 text-blue-600 hover:text-blue-900 dark:text-blue-300 dark:hover:text-blue-100" title="Hapus filter">
                            &times;
                        </a>
                    </span>
                @endif
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Audit trail seluruh perpindahan kuantitas, penerimaan barang, pengeluaran stok, dan status fisik
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button"
                    onclick="printHistoryReport()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Log</span>
            </button>
        </div>
    </div>

    <!-- Quick Status Filter Pills -->
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
        <span class="text-gray-400 dark:text-gray-500 font-medium whitespace-nowrap mr-1">Status:</span>

        <a href="{{ route($rp . '.inventory.tab.history') }}"
           class="inline-flex items-center px-3 py-1 rounded-lg font-medium whitespace-nowrap transition-colors {{ empty($activeFilter) ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900 shadow-sm' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
            Semua
        </a>

        @foreach ([
            'damaged' => ['label' => 'Rusak (Damaged)', 'color' => 'rose'],
            'lost' => ['label' => 'Hilang (Lost)', 'color' => 'red'],
            'expired' => ['label' => 'Kadaluwarsa', 'color' => 'amber'],
            'sold' => ['label' => 'Terjual (Sold)', 'color' => 'blue']
        ] as $statusKey => $statusConfig)
            @php $isSelected = $activeFilter === $statusKey; @endphp
            <a href="{{ route($rp . '.inventory.tab.history.status', $statusKey) }}"
               class="inline-flex items-center px-3 py-1 rounded-lg font-medium whitespace-nowrap transition-colors {{ $isSelected ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                {{ $statusConfig['label'] }}
            </a>
        @endforeach
    </div>
</div>

<script>
    function printHistoryReport() {
        const tableElement = document.querySelector('#history-table-container');
        if (!tableElement) {
            window.print();
            return;
        }

        const printWindow = window.open('', '_blank', 'height=800,width=1050');
        if (!printWindow) {
            alert('Pop-up terblokir. Harap izinkan pop-up untuk mencetak laporan.');
            return;
        }

        const activeFilterLabel = '{{ $activeFilter ? ucfirst($activeFilter) : "Semua Log Transaksi" }}';
        const currentDate = '{{ now()->translatedFormat("d F Y - H:i") }} WIB';
        const loggedUser = '{{ auth()->user()?->name ?? "Petugas Bengkel" }}';
        const companyName = '{{ $companyName ?? "Artilia" }}';

        const printHtml = `
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Laporan Mutasi Inventaris - ${companyName}</title>
                <style>
                    * { box-sizing: border-box; }
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                        color: #1e293b;
                        padding: 30px;
                        margin: 0;
                        font-size: 11px;
                        line-height: 1.4;
                    }
                    .header-box {
                        border-bottom: 2px solid #0f172a;
                        padding-bottom: 12px;
                        margin-bottom: 20px;
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-end;
                    }
                    .header-title h1 {
                        font-size: 18px;
                        margin: 0 0 4px 0;
                        color: #0f172a;
                        font-weight: 800;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    .header-title p {
                        margin: 0;
                        color: #64748b;
                        font-size: 11px;
                    }
                    .meta-info {
                        text-align: right;
                        font-size: 10px;
                        color: #475569;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 10px;
                    }
                    th {
                        background-color: #f1f5f9;
                        color: #0f172a;
                        font-weight: 700;
                        text-align: left;
                        padding: 8px 10px;
                        border: 1px solid #cbd5e1;
                        font-size: 10px;
                        text-transform: uppercase;
                        letter-spacing: 0.3px;
                    }
                    td {
                        padding: 8px 10px;
                        border: 1px solid #e2e8f0;
                        vertical-align: top;
                    }
                    tr:nth-child(even) {
                        background-color: #f8fafc;
                    }
                    .badge {
                        display: inline-block;
                        padding: 2px 6px;
                        border-radius: 4px;
                        font-weight: 600;
                        font-size: 9px;
                        text-transform: uppercase;
                    }
                    .badge-in { background-color: #dcfce7; color: #166534; }
                    .badge-out { background-color: #fee2e2; color: #991b1b; }
                    .badge-good { background-color: #e0f2fe; color: #075985; }
                    .badge-warn { background-color: #fef3c7; color: #92400e; }
                    .badge-danger { background-color: #fee2e2; color: #991b1b; }
                    .signatures {
                        margin-top: 40px;
                        display: flex;
                        justify-content: space-between;
                        page-break-inside: avoid;
                    }
                    .signature-box {
                        width: 200px;
                        text-align: center;
                    }
                    .sig-line {
                        margin-top: 55px;
                        border-bottom: 1px solid #0f172a;
                        font-weight: 600;
                    }
                    @media print {
                        body { padding: 15px; }
                        @page { size: landscape; margin: 12mm; }
                    }
                </style>
            </head>
            <body>
                <div class="header-box">
                    <div class="header-title">
                        <h1>${companyName} : Log Riwayat Mutasi Inventaris</h1>
                        <p>Dokumen resmi rekapitulasi transaksi masuk, keluar, dan penyesuaian kondisi fisik barang</p>
                    </div>
                    <div class="meta-info">
                        <div><strong>Tanggal Cetak:</strong> ${currentDate}</div>
                        <div><strong>Petugas:</strong> ${loggedUser}</div>
                        <div><strong>Filter:</strong> ${activeFilterLabel}</div>
                    </div>
                </div>

                ${tableElement.innerHTML}

                <div class="signatures">
                    <div class="signature-box">
                        <div>Petugas Logistik / Gudang</div>
                        <div class="sig-line">${loggedUser}</div>
                    </div>
                    <div class="signature-box">
                        <div>Kepala Bengkel / Workshop Head</div>
                        <div class="sig-line">( ____________________ )</div>
                    </div>
                </div>
            </body>
            </html>
        `;

        printWindow.document.open();
        printWindow.document.write(printHtml);
        printWindow.document.close();
        printWindow.focus();

        setTimeout(() => {
            printWindow.print();
        }, 300);
    }
</script>
