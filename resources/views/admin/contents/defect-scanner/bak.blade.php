<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BAK {{ $inspection->bak_number ?? 'Draft' }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #111; background: #fff; }

.page { max-width: 800px; margin: 0 auto; padding: 30mm 25mm; }

.kop { display:flex; align-items:center; gap:20px; border-bottom: 3px solid #1e3a5f; padding-bottom:12px; margin-bottom:20px; }
.kop-logo { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#0891b2); display:flex; align-items:center; justify-content:center; color:#fff; font-size:22pt; font-weight:900; flex-shrink:0; }
.kop-text h1 { font-size:18pt; font-weight:900; color:#1e3a5f; letter-spacing:2px; }
.kop-text p  { font-size:9pt; color:#555; margin-top:2px; }
.kop-text .sub { font-size:10pt; color:#1e3a5f; font-weight:bold; margin-top:4px; }

.doc-title { text-align:center; margin:24px 0 20px; }
.doc-title h2 { font-size:14pt; font-weight:900; text-transform:uppercase; letter-spacing:2px; color:#1e3a5f; text-decoration:underline; }
.doc-title .nomor { font-size:11pt; color:#333; margin-top:4px; }

.bak-badge { text-align:center; margin-bottom:20px; }
.bak-badge span { display:inline-block; padding:6px 20px; background:#1e3a5f; color:#fff; font-size:13pt; font-weight:bold; letter-spacing:4px; border-radius:4px; }

.verdict-banner { padding:10px 16px; border-radius:6px; margin-bottom:20px; display:flex; align-items:center; gap:12px; }
.verdict-ok       { background:#d1fae5; border:2px solid #10b981; color:#065f46; }
.verdict-minor    { background:#fef9c3; border:2px solid #eab308; color:#713f12; }
.verdict-damaged  { background:#ffedd5; border:2px solid #f97316; color:#7c2d12; }
.verdict-critical { background:#fee2e2; border:2px solid #ef4444; color:#7f1d1d; }
.verdict-icon { font-size:24pt; line-height:1; }
.verdict-text h3 { font-size:13pt; font-weight:900; }
.verdict-text p  { font-size:9pt; margin-top:2px; }

.section { margin-bottom:20px; }
.section-title { font-size:11pt; font-weight:900; color:#1e3a5f; text-transform:uppercase; letter-spacing:1px; border-bottom:1.5px solid #1e3a5f; padding-bottom:4px; margin-bottom:10px; }

table.info { width:100%; border-collapse:collapse; }
table.info td { padding:5px 8px; vertical-align:top; }
table.info td:first-child { width:35%; color:#555; font-style:italic; }
table.info td:nth-child(2){ width:5%; text-align:center; }
table.info td:last-child { font-weight:600; color:#111; }
table.info tr:nth-child(even) td { background:#f8faff; }

.metrics { display:flex; gap:12px; }
.metric-box { flex:1; border:1.5px solid #ddd; border-radius:6px; padding:10px; text-align:center; }
.metric-box .val { font-size:18pt; font-weight:900; color:#1e3a5f; }
.metric-box .lbl { font-size:8pt; color:#777; margin-top:2px; }

.wear-bar-bg { height:10px; background:#e5e7eb; border-radius:99px; overflow:hidden; margin-top:6px; }
.wear-bar-fill { height:100%; border-radius:99px; }

.defect-chip { display:inline-block; padding:3px 10px; border-radius:99px; font-size:9pt; font-weight:700; margin:2px; }

.photo-box { border:1.5px solid #ddd; border-radius:8px; overflow:hidden; text-align:center; background:#f8f8f8; }
.photo-box img { max-width:100%; max-height:220px; object-fit:contain; display:block; margin:0 auto; }
.photo-box .no-photo { padding:40px; color:#999; font-style:italic; }

.signatures { display:flex; gap:30px; margin-top:10px; }
.sig-box { flex:1; text-align:center; }
.sig-box .sig-title { font-size:9pt; font-weight:bold; color:#333; border-bottom:1.5px solid #333; padding-bottom:4px; margin-bottom:50px; }
.sig-box .sig-name { font-size:10pt; font-weight:900; text-decoration:underline; }
.sig-box .sig-role { font-size:8pt; color:#555; }

.qr-area { border:1.5px dashed #aaa; border-radius:8px; padding:12px; text-align:center; color:#aaa; font-size:8pt; margin-top:10px; }

.doc-footer { margin-top:30px; padding-top:10px; border-top:1px solid #ddd; font-size:8pt; color:#888; text-align:center; }

@media print {
    .no-print { display:none !important; }
    body { font-size:11pt; }
    .page { padding: 15mm 20mm; }
}
</style>
</head>
<body>

<div class="no-print" style="background:#1e3a5f;color:#fff;padding:12px 24px;display:flex;align-items:center;justify-between;gap:12px;">
    <span style="font-size:13pt;font-weight:bold;">Preview BAK — {{ $inspection->bak_number ?? 'DRAFT' }}</span>
    <div style="display:flex;gap:10px;">
        @if(!$inspection->bak_issued)
        <form action="{{ route($routePrefix.'.defect-scanner.issue-bak', $inspection->id) }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" style="padding:8px 16px;background:#ef4444;color:#fff;border:none;border-radius:8px;font-weight:bold;cursor:pointer;">Terbitkan BAK Resmi</button>
        </form>
        @endif
        <button onclick="window.print()" style="padding:8px 16px;background:#10b981;color:#fff;border:none;border-radius:8px;font-weight:bold;cursor:pointer;">🖨 Cetak / Simpan PDF</button>
        <a href="{{ route($routePrefix.'.defect-scanner.show', $inspection->id) }}" style="padding:8px 16px;background:#fff;color:#1e3a5f;border:none;border-radius:8px;font-weight:bold;text-decoration:none;">← Kembali</a>
    </div>
</div>

<div class="page">

    <div class="kop">
        <div class="kop-logo">A</div>
        <div class="kop-text">
            <h1>ARTILIA</h1>
            <p class="sub">Sistem Manajemen Inventaris & K3 Laboratorium Teknik</p>
            <p>Laboratorium Teknik · Universitas / Institusi · Telp. (021) xxx-xxxx</p>
        </div>
    </div>

    <div class="doc-title">
        <h2>Berita Acara Kerusakan (BAK)</h2>
        <p class="nomor">Formulir Resmi Bukti Kerusakan Alat Laboratorium</p>
    </div>

    @if($inspection->bak_issued)
    <div class="bak-badge">
        <span>{{ $inspection->bak_number }}</span>
    </div>
    @else
    <div class="bak-badge">
        <span style="background:#f97316;">DRAFT — BELUM DITERBITKAN</span>
    </div>
    @endif

    @php
        $verdict = $inspection->verdict;
        $vClass  = match($verdict) { 'ok'=>'verdict-ok','minor_wear'=>'verdict-minor','damaged'=>'verdict-damaged','critical'=>'verdict-critical', default=>'verdict-minor' };
        $vIcon   = match($verdict) { 'ok'=>'✓','minor_wear'=>'⚠','damaged'=>'!','critical'=>'✕', default=>'?' };
        $vLabel  = match($verdict) { 'ok'=>'Kondisi Baik — Tidak Ada Kerusakan','minor_wear'=>'Keausan Ringan — Perlu Monitoring','damaged'=>'CACAT / RUSAK — Perlu Perbaikan','critical'=>'KONDISI KRITIS — Hentikan Penggunaan', default=>'Tidak Diketahui' };
        $badge   = $inspection->verdict_badge;
    @endphp
    <div class="verdict-banner {{ $vClass }}">
        <div class="verdict-icon">{{ $vIcon }}</div>
        <div class="verdict-text">
            <h3>{{ $vLabel }}</h3>
            <p>Verdict AI dengan keyakinan {{ $inspection->defect_confidence }}% · Keausan estimasi {{ $inspection->wear_percentage }}%</p>
        </div>
    </div>

    <div class="metrics" style="margin-bottom:20px;">
        <div class="metric-box">
            <div class="val">{{ $inspection->wear_percentage }}%</div>
            <div class="lbl">Estimasi Keausan</div>
            <div class="wear-bar-bg">
                <div class="wear-bar-fill" style="width:{{ $inspection->wear_percentage }}%;background:{{ $inspection->wear_percentage > 70 ? '#ef4444' : ($inspection->wear_percentage > 40 ? '#eab308' : '#10b981') }};"></div>
            </div>
        </div>
        <div class="metric-box">
            <div class="val">{{ $inspection->defect_confidence }}%</div>
            <div class="lbl">Keyakinan AI</div>
        </div>
        <div class="metric-box">
            <div class="val">{{ count($inspection->defect_types ?? []) }}</div>
            <div class="lbl">Jenis Cacat</div>
        </div>
        <div class="metric-box">
            <div class="val" style="font-size:12pt;">{{ $inspection->created_at->format('d/m/Y') }}</div>
            <div class="lbl">Tanggal Inspeksi</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">I. Identifikasi Barang</div>
        <table class="info">
            <tr><td>Nama Barang</td><td>:</td><td>{{ $inspection->item->nama }}</td></tr>
            <tr><td>Kode Barang</td><td>:</td><td>{{ $inspection->item->kode ?? '—' }}</td></tr>
            <tr><td>Kategori</td><td>:</td><td>{{ $inspection->item->category->nama ?? '—' }}</td></tr>
            <tr><td>Tahap Inspeksi</td><td>:</td><td>{{ $inspection->inspection_stage === 'return' ? 'Pengembalian Alat' : 'Peminjaman Alat' }}</td></tr>
            @if($inspection->borrowingRequest)
            <tr><td>Peminjam</td><td>:</td><td>{{ $inspection->borrowingRequest->user->name ?? '—' }}</td></tr>
            <tr><td>No. Permintaan</td><td>:</td><td>BR #{{ $inspection->borrowing_request_id }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <div class="section-title">II. Hasil Analisis AI (Computer Vision)</div>
        <table class="info">
            <tr><td>Metode Analisis</td><td>:</td><td>Sobel Edge Detection + Statistical Anomaly Analysis</td></tr>
            <tr><td>Edge Density</td><td>:</td><td>{{ $inspection->scan_metrics['edgeDensity'] ?? '—' }}</td></tr>
            <tr><td>Contrast Variance</td><td>:</td><td>{{ $inspection->scan_metrics['contrastVariance'] ?? '—' }}</td></tr>
            <tr><td>Anomaly Blocks</td><td>:</td><td>{{ $inspection->scan_metrics['anomalyBlocks'] ?? '—' }} / 16 blok</td></tr>
            <tr><td>Durasi Scan</td><td>:</td><td>{{ $inspection->scan_duration_ms ?? '—' }} ms</td></tr>
            <tr>
                <td>Jenis Cacat</td><td>:</td>
                <td>
                    @if(!empty($inspection->defect_types))
                        @foreach($inspection->defect_types as $t)
                            <span class="defect-chip" style="background:{{ ['chip'=>'#fee2e2','crack'=>'#ffedd5','corrosion'=>'#f3e8ff','wear'=>'#fef9c3'][$t]??'#f3f4f6' }};color:{{ ['chip'=>'#b91c1c','crack'=>'#c2410c','corrosion'=>'#7e22ce','wear'=>'#713f12'][$t]??'#374151' }};">
                                {{ ['chip'=>'Gompal/Chipping','crack'=>'Retak/Crack','corrosion'=>'Korosi','wear'=>'Keausan Normal'][$t] ?? $t }}
                            </span>
                        @endforeach
                    @else
                        Tidak ada cacat terdeteksi
                    @endif
                </td>
            </tr>
        </table>
        @if($inspection->notes)
        <p style="margin-top:8px;font-style:italic;color:#555;">"{{ $inspection->notes }}"</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">III. Foto Bukti Inspeksi</div>
        <div class="photo-box">
            @if($inspection->image_path)
                <img src="{{ asset($inspection->image_path) }}" alt="Foto Bukti">
                <p style="font-size:8pt;color:#888;padding:4px 0;">Gambar dianalisis oleh sistem AI Artilia pada {{ $inspection->created_at->format('d/m/Y H:i') }} WIB</p>
            @else
                <div class="no-photo">— Tidak ada foto tersimpan —</div>
            @endif
        </div>
    </div>

    <div class="section">
        <div class="section-title">IV. Rekomendasi & Tindak Lanjut</div>
        <table class="info">
            @if($inspection->maintenance_triggered)
            <tr><td>Status</td><td>:</td><td style="color:#b45309;font-weight:900;">Maintenance Otomatis Dibuat (ID #{{ $inspection->maintenance_id }})</td></tr>
            @endif
            <tr>
                <td>Rekomendasi</td><td>:</td>
                <td>
                    @if($verdict === 'ok') Alat dapat langsung digunakan kembali.
                    @elseif($verdict === 'minor_wear') Lakukan pelumasan/kalibrasi, monitoring berkala.
                    @elseif($verdict === 'damaged') Hentikan penggunaan, segera lakukan perbaikan/penggantian komponen.
                    @else Hentikan penggunaan segera. Isolasi alat. Lapor ke kepala laboratorium.
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">V. Pengesahan</div>
        <p style="font-size:10pt;margin-bottom:16px;">
            Dengan ditandatanganinya dokumen ini, menyatakan bahwa hasil inspeksi visual oleh sistem AI Artilia
            telah diverifikasi dan diakui sebagai bukti resmi kondisi alat laboratorium.
        </p>
        <div class="signatures">
            <div class="sig-box">
                <div class="sig-title">Mahasiswa / Peminjam</div>
                <div class="sig-name">{{ $inspection->borrowingRequest?->user?->name ?? '______________________' }}</div>
                <div class="sig-role">NIM: _______________</div>
            </div>
            <div class="sig-box">
                <div class="sig-title">Toolman / Inspektor</div>
                <div class="sig-name">{{ $inspection->inspector->name }}</div>
                <div class="sig-role">Petugas Laboratorium</div>
            </div>
            <div class="sig-box">
                <div class="sig-title">Kepala Laboratorium</div>
                <div class="sig-name">______________________</div>
                <div class="sig-role">Mengetahui & Menyetujui</div>
            </div>
        </div>
    </div>

    <div class="qr-area">
        Dokumen ini dihasilkan secara digital oleh Sistem ARTILIA v2.0 · AI Defect Scanner Module<br>
        Nomor BAK: <strong>{{ $inspection->bak_number ?? 'DRAFT' }}</strong> ·
        Diterbitkan: {{ $inspection->bak_issued_at?->format('d F Y, H:i') ?? now()->format('d F Y, H:i') }} WIB<br>
        Verifikasi ke: <em>artilia.system/bak/{{ $inspection->id }}</em>
    </div>

    <div class="doc-footer">
        ARTILIA — Sistem Manajemen Inventaris & K3 Laboratorium Teknik | Dokumen ini sah tanpa tanda tangan basah jika memiliki nomor BAK resmi
    </div>
</div>
</body>
</html>
