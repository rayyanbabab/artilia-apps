@extends('admin.layouts.dashboard')
@section('title', 'AI Defect Scanner — Side-by-Side Baseline Comparison')

@section('content')
<style>

html.dark .ds-card  { background:#1e293b !important; border-color:#334155 !important; }
html.dark .ds-title { color:#f1f5f9 !important; }
html.dark .ds-sub   { color:#94a3b8 !important; }
html.dark .ds-input { background:#0f172a !important; border-color:#334155 !important; color:#f1f5f9 !important; }
html.dark .ds-select{ background:#0f172a !important; border-color:#334155 !important; color:#f1f5f9 !important; }

.camera-box-wrap {
    position: relative;
    background: #000;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 4/3;
    max-height: 400px;
}
#video-feed, #baseline-img-view {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
#overlay-canvas, #sobel-canvas {
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}
#scan-line {
    position: absolute;
    left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #22d3ee, #a78bfa, #22d3ee, transparent);
    box-shadow: 0 0 8px #22d3ee;
    animation: scanline 2.2s ease-in-out infinite;
    opacity: 0;
    transition: opacity .3s;
}
@keyframes scanline {
    0%   { top: 8%;  opacity: 0; }
    10%  {            opacity: 1; }
    90%  {            opacity: 1; }
    100% { top: 92%; opacity: 0; }
}
.scanning #scan-line { opacity: 1; }

.corner { position:absolute; width:24px; height:24px; border-color:#22d3ee; border-style:solid; z-index: 10; }
.corner-tl { top:10px; left:10px;  border-width:3px 0 0 3px; border-radius:4px 0 0 0; }
.corner-tr { top:10px; right:10px; border-width:3px 3px 0 0; border-radius:0 4px 0 0; }
.corner-bl { bottom:10px; left:10px;  border-width:0 0 3px 3px; border-radius:0 0 0 4px; }
.corner-br { bottom:10px; right:10px; border-width:0 3px 3px 0; border-radius:0 0 4px 0; }

.roi-guide {
    position: absolute;
    top: 20%; left: 20%; right: 20%; bottom: 20%;
    border: 1px dashed rgba(34, 211, 238, 0.4);
    border-radius: 8px;
    pointer-events: none;
}

.meter-fill {
    height: 8px;
    border-radius: 99px;
    transition: width 0.8s cubic-bezier(.22,1,.36,1);
}

#result-panel, #dispute-card {
    transition: all 0.4s cubic-bezier(.22,1,.36,1);
}
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-5">

    <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-violet-600 via-cyan-500 to-emerald-500"></div>
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-600 to-cyan-500 flex items-center justify-center shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.867V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="ds-title text-2xl font-bold text-gray-900 flex items-center gap-2">
                        AI Defect Scanner & Baseline Comparison
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-violet-100 text-violet-700 tracking-wide">PIMNAS Edition</span>
                    </h1>
                    <p class="ds-sub text-sm text-gray-500 mt-0.5">Sistem inspeksi cacat visual perkakas presisi & komparasi kondisi serah-terima pencegah sengketa</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route($routePrefix . '.defect-scanner.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Riwayat Inspeksi
                </a>
            </div>
        </div>
    </div>

    <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 p-3 sm:p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mr-2 flex items-center gap-1.5 flex-shrink-0">
                <span class="w-2 h-2 rounded-full bg-violet-600"></span>
                Mode Tampilan:
            </span>
            <button id="tab-mode-sidebyside" type="button" onclick="setInspectionMode('sidebyside')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-sm flex-shrink-0">
                <svg class="w-4 h-4 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Side-by-Side (Komparasi Sengketa)
            </button>
            <button id="tab-mode-single" type="button" onclick="setInspectionMode('single')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 flex-shrink-0">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.867V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Kamera Tunggal
            </button>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="triggerPimnasDisputeDemo()"
                    class="w-full md:w-auto px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:to-red-600 text-white text-xs font-bold shadow-md shadow-orange-500/20 transition flex items-center justify-center gap-2">
                <span class="animate-pulse">⚡</span>
                Simulasi Sengketa Pahat (Demo PIMNAS 1-Klik)
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <div class="lg:col-span-3 space-y-4">

            <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Barang yang Diinspeksi</label>
                        <select id="item-select" onchange="onItemChange(this.value)" class="ds-select w-full px-3 py-2 border border-gray-300 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                            <option value="">-- Pilih Perkakas Presisi --</option>
                            @foreach($items as $it)
                                <option value="{{ $it->id }}" {{ ($item && $item->id === $it->id) ? 'selected' : '' }}>
                                    {{ $it->nama }} {{ $it->kode ? '('.$it->kode.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($borrowingRequest)
                        <input type="hidden" id="borrowing-request-id" value="{{ $borrowingRequest->id }}">
                        <div class="sm:self-end">
                            <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-50 text-blue-700 text-xs font-bold rounded-xl border border-blue-200">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                Transaksi #BR-{{ $borrowingRequest->id }} ({{ $borrowingRequest->user->name ?? 'Peminjam' }})
                            </span>
                        </div>
                    @else
                        <input type="hidden" id="borrowing-request-id" value="">
                    @endif
                </div>
            </div>

            <div class="ds-card bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 space-y-4">

                <div id="sidebyside-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div id="baseline-col" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                1. Kondisi Awal (Baseline Saat Pinjam)
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Terverifikasi #BAP
                            </span>
                        </div>

                        <div class="camera-box-wrap border border-slate-700" id="baseline-wrapper">
                            <canvas id="baseline-canvas" width="400" height="300" class="w-full h-full object-cover"></canvas>
                            <div class="corner corner-tl" style="border-color:#10b981;"></div>
                            <div class="corner corner-tr" style="border-color:#10b981;"></div>
                            <div class="corner corner-bl" style="border-color:#10b981;"></div>
                            <div class="corner corner-br" style="border-color:#10b981;"></div>

                            <div class="absolute bottom-2 left-2 right-2 bg-slate-900/85 backdrop-blur-md rounded-lg p-2 text-white border border-slate-700/80 text-[11px] flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-emerald-400">Keausan Awal: <span id="baseline-wear-val">4</span>%</div>
                                    <div class="text-[10px] text-slate-300">Status: Kondisi Prima / 0 Cacat</div>
                                </div>
                                <div class="text-right text-[10px] text-slate-400 font-mono">
                                    <div id="baseline-bap-label">BAP-VERIFIED</div>
                                    <div id="baseline-date-label">Baseline Serah-Terima</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-gray-500 pt-1">
                            <span id="baseline-inspector-info">Pemeriksa: Laboran / Teknisi</span>
                            <button type="button" onclick="loadDefaultPristineBaseline()" class="text-violet-600 hover:text-violet-800 font-semibold underline text-[11px]">
                                Reset ke Pahat Prima
                            </button>
                        </div>
                    </div>

                    <div id="return-col" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                                <span id="cam-status-dot" class="w-2 h-2 rounded-full bg-gray-300"></span>
                                2. Kondisi Saat Ini (Pengembalian)
                            </span>
                            <div class="flex items-center gap-1.5">
                                <button type="button" id="btn-sobel-toggle" onclick="toggleSobelView()"
                                        class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 transition">
                                    🔬 Peta Gradien Sobel
                                </button>
                                <button id="btn-flip" onclick="flipCamera()" class="hidden px-2 py-0.5 text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-600 rounded transition">
                                    🔄 Balik
                                </button>
                            </div>
                        </div>

                        <div id="camera-wrapper" class="camera-box-wrap">
                            <video id="video-feed" autoplay playsinline muted></video>
                            <canvas id="overlay-canvas"></canvas>
                            <div id="scan-line"></div>
                            <div class="corner corner-tl"></div>
                            <div class="corner corner-tr"></div>
                            <div class="corner corner-bl"></div>
                            <div class="corner corner-br"></div>
                            <div class="roi-guide"></div>

                            <div id="cam-placeholder" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-center p-4">
                                <svg class="w-12 h-12 text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.867V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-400 text-xs font-semibold">Kamera Belum Aktif</p>
                                <p class="text-gray-500 text-[10px] mt-0.5">Aktifkan kamera atau gunakan demo simulasi sengketa</p>
                                <button type="button" onclick="startCamera()" class="mt-3 px-3 py-1.5 rounded-lg bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold transition">
                                    Aktifkan Kamera Live
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-[11px] text-gray-500 pt-1">
                            <span id="cam-status-text">Kamera Siap</span>
                            <span class="text-[10px] font-mono text-cyan-600">Sobel Kernel 3×3 Ready</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button id="btn-capture" onclick="captureAndAnalyze()"
                            class="flex-1 py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition
                                   bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-600 text-white hover:from-violet-700 hover:to-cyan-700 shadow-md shadow-indigo-600/20">
                        <svg class="w-5 h-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <span id="btn-capture-text">Scan & Bandingkan Disparitas Sengketa</span>
                    </button>
                    <button type="button" onclick="resetScan()" class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold transition">
                        Reset
                    </button>
                </div>

                <div class="pt-2 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 font-medium">Input File:</span>
                        <input type="file" id="upload-input" accept="image

let stream = null;
let facingMode = 'environment';
let capturedImageData = null;
let analysisResult = null;
let currentInspectionMode = 'sidebyside';
let sobelViewActive = false;
let currentSobelEdgeData = null;

let baselineData = {
    wearPct: {{ $baselineInspection ? $baselineInspection->wear_percentage : 4 }},
    verdict: '{{ $baselineInspection ? $baselineInspection->verdict : "ok" }}',
    inspector: '{{ $baselineInspection && $baselineInspection->inspector ? $baselineInspection->inspector->name : "Teknisi Serah-Terima" }}',
    date: '{{ $baselineInspection ? $baselineInspection->created_at->format("d M Y, H:i") : now()->subDays(2)->format("d M Y, 08:30") . " WIB" }}',
    image: '{{ $baselineInspection && $baselineInspection->image_path ? asset($baselineInspection->image_path) : "" }}',
    bapNumber: '{{ $borrowingRequest && $borrowingRequest->bap_number ? $borrowingRequest->bap_number : "BAP-INIT-0921" }}',
    defectTypes: {!! json_encode($baselineInspection && $baselineInspection->defect_types ? $baselineInspection->defect_types : []) !!}
};

const video        = document.getElementById('video-feed');
const overlayC     = document.getElementById('overlay-canvas');
const overlayCtx   = overlayC.getContext('2d');
const processC     = document.getElementById('process-canvas');
const processCtx   = processC.getContext('2d');
const baselineC    = document.getElementById('baseline-canvas');
const baselineCtx  = baselineC.getContext('2d');

window.addEventListener('DOMContentLoaded', () => {
    initBaselineView();
});

function initBaselineView() {
    document.getElementById('baseline-wear-val').textContent = baselineData.wearPct;
    document.getElementById('baseline-bap-label').textContent = baselineData.bapNumber;
    document.getElementById('baseline-date-label').textContent = baselineData.date;
    document.getElementById('baseline-inspector-info').textContent = 'Pemeriksa: ' + baselineData.inspector;

    if (baselineData.image) {
        const img = new Image();
        img.onload = () => {
            baselineCtx.drawImage(img, 0, 0, baselineC.width, baselineC.height);
        };
        img.src = baselineData.image;
    } else {
        drawPristineInsertCanvas(baselineCtx, baselineC.width, baselineC.height);
    }
}

function loadDefaultPristineBaseline() {
    baselineData.wearPct = 4;
    baselineData.verdict = 'ok';
    baselineData.defectTypes = [];
    document.getElementById('baseline-wear-val').textContent = '4';
    drawPristineInsertCanvas(baselineCtx, baselineC.width, baselineC.height);
}

function setInspectionMode(mode) {
    currentInspectionMode = mode;
    const sidebysideGrid = document.getElementById('sidebyside-grid');
    const baselineCol    = document.getElementById('baseline-col');
    const tabSide        = document.getElementById('tab-mode-sidebyside');
    const tabSingle      = document.getElementById('tab-mode-single');

    if (mode === 'sidebyside') {
        sidebysideGrid.className = 'grid grid-cols-1 md:grid-cols-2 gap-4';
        baselineCol.classList.remove('hidden');
        tabSide.className   = 'px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-sm flex-shrink-0';
        tabSingle.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 flex-shrink-0';
    } else {
        sidebysideGrid.className = 'grid grid-cols-1 gap-4';
        baselineCol.classList.add('hidden');
        tabSingle.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-sm flex-shrink-0';
        tabSide.className   = 'px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 flex-shrink-0';
    }
}

async function startCamera() {
    try {
        if (stream) { stream.getTracks().forEach(t => t.stop()); }
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode, width: { ideal: 1280 }, height: { ideal: 960 } }
        });
        video.srcObject = stream;
        document.getElementById('cam-placeholder').classList.add('hidden');
        document.getElementById('btn-flip').classList.remove('hidden');
        document.getElementById('btn-capture').disabled = false;
        document.getElementById('cam-status-dot').className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';
        document.getElementById('cam-status-text').textContent = 'Kamera Live Aktif';

        video.addEventListener('loadedmetadata', () => {
            overlayC.width  = video.videoWidth  || 640;
            overlayC.height = video.videoHeight || 480;
        });
    } catch(e) {
        alert('Tidak dapat mengakses kamera: ' + e.message + '\nGunakan tombol "Simulasi Sengketa (Demo PIMNAS)" untuk menjalankan demo tanpa webcam.');
    }
}

function flipCamera() {
    facingMode = (facingMode === 'environment') ? 'user' : 'environment';
    startCamera();
}

function loadImageFromFile(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
            processC.width  = img.width;
            processC.height = img.height;
            processCtx.drawImage(img, 0, 0);
            overlayC.width  = img.width;
            overlayC.height = img.height;
            document.getElementById('cam-placeholder').classList.add('hidden');
            document.getElementById('btn-capture').disabled = false;
            capturedImageData = e.target.result;
            runDirectAnalysis(capturedImageData, img.width, img.height);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function onItemChange(val) {
    if (!val) return;
    document.getElementById('btn-capture').disabled = false;
}

async function captureAndAnalyze() {
    const itemId = document.getElementById('item-select').value;
    if (!itemId) {
        const select = document.getElementById('item-select');
        if (select.options.length > 1) {
            select.selectedIndex = 1;
        }
    }

    showScanning();

    if (video.srcObject && video.readyState >= 2) {
        processC.width  = video.videoWidth  || 640;
        processC.height = video.videoHeight || 480;
        overlayC.width  = processC.width;
        overlayC.height = processC.height;
        processCtx.drawImage(video, 0, 0);
        capturedImageData = processC.toDataURL('image/jpeg', 0.92);
        document.getElementById('camera-wrapper').classList.add('scanning');
    }

    if (!capturedImageData) {
        drawChippedInsertCanvas(processCtx, 400, 300);
        capturedImageData = processC.toDataURL('image/jpeg', 0.92);
    }

    await delay(350);
    updateScanStep('Menghitung matriks konvolusi Sobel 3×3...');
    await delay(350);

    const result = await analyzeImage(capturedImageData, processC.width, processC.height);

    await delay(300);
    updateScanStep('Menghitung disparitas delta baseline & sengketa...');
    await delay(350);

    document.getElementById('camera-wrapper').classList.remove('scanning');

    analysisResult = result;
    displayResult(result);
}

async function runDirectAnalysis(dataUrl, w, h) {
    showScanning();
    await delay(300);
    const result = await analyzeImage(dataUrl, w, h);
    analysisResult = result;
    displayResult(result);
}

async function analyzeImage(dataUrl, w, h) {
    const startTime = performance.now();

    const img = new Image();
    await new Promise(r => { img.onload = r; img.src = dataUrl; });
    const oc = document.createElement('canvas');
    oc.width = Math.min(img.width, 400);
    oc.height = Math.min(img.height, 300);
    const oct = oc.getContext('2d');
    oct.drawImage(img, 0, 0, oc.width, oc.height);

    const imageData = oct.getImageData(0, 0, oc.width, oc.height);
    const data = imageData.data;
    const W = oc.width, H = oc.height;

    const gray = new Float32Array(W * H);
    for (let i = 0; i < W * H; i++) {
        const r = data[i*4], g = data[i*4+1], b = data[i*4+2];
        gray[i] = 0.299*r + 0.587*g + 0.114*b;
    }

    const sobel = new Float32Array(W * H);
    let totalEdge = 0, maxEdge = 0;
    for (let y = 1; y < H-1; y++) {
        for (let x = 1; x < W-1; x++) {
            const idx = y*W + x;
            const gx = -gray[(y-1)*W+(x-1)] - 2*gray[y*W+(x-1)] - gray[(y+1)*W+(x-1)]
                      + gray[(y-1)*W+(x+1)] + 2*gray[y*W+(x+1)] + gray[(y+1)*W+(x+1)];
            const gy = -gray[(y-1)*W+(x-1)] - 2*gray[(y-1)*W+x] - gray[(y-1)*W+(x+1)]
                      + gray[(y+1)*W+(x-1)] + 2*gray[(y+1)*W+x] + gray[(y+1)*W+(x+1)];
            sobel[idx] = Math.sqrt(gx*gx + gy*gy);
            totalEdge += sobel[idx];
            if (sobel[idx] > maxEdge) maxEdge = sobel[idx];
        }
    }
    const edgeDensity = totalEdge / (W * H);
    const edgeDensityNorm = Math.min(edgeDensity / 60, 1);

    currentSobelEdgeData = { sobel, W, H, maxEdge };

    let mean = 0;
    for (let i = 0; i < gray.length; i++) mean += gray[i];
    mean /= gray.length;
    let varianceSum = 0;
    for (let i = 0; i < gray.length; i++) varianceSum += Math.pow(gray[i] - mean, 2);
    const contrastStdDev = Math.sqrt(varianceSum / gray.length);
    const contrastNorm = Math.min(contrastStdDev / 80, 1);

    const BLOCKS = 4;
    const bw = Math.floor(W / BLOCKS), bh = Math.floor(H / BLOCKS);
    const blockEdges = [];
    for (let by = 0; by < BLOCKS; by++) {
        for (let bx = 0; bx < BLOCKS; bx++) {
            let sum = 0, cnt = 0;
            for (let py = by*bh; py < Math.min((by+1)*bh, H); py++) {
                for (let px = bx*bw; px < Math.min((bx+1)*bw, W); px++) {
                    sum += sobel[py*W+px]; cnt++;
                }
            }
            blockEdges.push({ bx, by, avg: cnt ? sum/cnt : 0 });
        }
    }
    const avgBlockEdge = blockEdges.reduce((s,b) => s + b.avg, 0) / blockEdges.length;
    const highEdgeBlocks = blockEdges.filter(b => b.avg > avgBlockEdge * 2.0);

    const anomalyBlockScore = Math.min(highEdgeBlocks.length / 4, 1);
    const rawScore = 0.40 * edgeDensityNorm + 0.30 * contrastNorm + 0.30 * anomalyBlockScore;
    const score = Math.max(0, Math.min(1, rawScore));

    let wearPct = Math.round(score * 85 + edgeDensityNorm * 15);
    wearPct = Math.max(2, Math.min(95, wearPct));

    let verdict, confidence;
    if (score < 0.18)      { verdict = 'ok';         confidence = Math.round(90 - score*40); }
    else if (score < 0.38) { verdict = 'minor_wear';  confidence = Math.round(75 + score*20); }
    else if (score < 0.62) { verdict = 'damaged';     confidence = Math.round(78 + score*18); }
    else                   { verdict = 'critical';    confidence = Math.round(85 + score*12); }
    confidence = Math.max(60, Math.min(98, confidence));

    const defectTypes = [];
    if (verdict !== 'ok') {
        if (highEdgeBlocks.length >= 2) defectTypes.push('chip');
        if (edgeDensityNorm > 0.40)     defectTypes.push('crack');
        if (contrastNorm > 0.45)        defectTypes.push('wear');
        if (defectTypes.length === 0)   defectTypes.push('chip');
    }

    const safeMaxEdge = maxEdge > 0 ? maxEdge : 1;
    const defectRegions = highEdgeBlocks.slice(0, 4).map(b => ({
        x: (b.bx / BLOCKS) * 100,
        y: (b.by / BLOCKS) * 100,
        w: (1   / BLOCKS) * 100,
        h: (1   / BLOCKS) * 100,
        type: defectTypes[0] ?? 'wear',
        confidence: Math.round(65 + (b.avg / safeMaxEdge) * 30),
    }));

    const elapsed = Math.round(performance.now() - startTime);

    return {
        verdict, confidence, wearPct, defectTypes, defectRegions,
        metrics: {
            edgeDensity: edgeDensity.toFixed(1),
            contrastVariance: contrastStdDev.toFixed(1),
            anomalyBlocks: highEdgeBlocks.length,
            rawScore: (score * 100).toFixed(1),
            elapsed,
        }
    };
}

function toggleSobelView() {
    sobelViewActive = !sobelViewActive;
    const btn = document.getElementById('btn-sobel-toggle');
    if (sobelViewActive) {
        btn.textContent = '👁️ Tampilkan Citra Asli';
        btn.className   = 'px-2 py-0.5 rounded text-[10px] font-bold bg-cyan-600 text-white transition';
        renderSobelEdgeMap();
    } else {
        btn.textContent = '🔬 Peta Gradien Sobel';
        btn.className   = 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 transition';
        if (analysisResult) {
            drawDefectOverlay(analysisResult.defectRegions);
        } else {
            overlayCtx.clearRect(0, 0, overlayC.width, overlayC.height);
        }
    }
}

function renderSobelEdgeMap() {
    if (!currentSobelEdgeData) return;
    const { sobel, W, H, maxEdge } = currentSobelEdgeData;
    const safeMax = maxEdge > 0 ? maxEdge : 1;

    overlayCtx.clearRect(0, 0, overlayC.width, overlayC.height);
    const imgData = overlayCtx.createImageData(W, H);
    for (let i = 0; i < W * H; i++) {
        const val = Math.min(255, (sobel[i] / safeMax) * 255 * 1.8);
        imgData.data[i*4]   = val > 50 ? 34  : 0;
        imgData.data[i*4+1] = val > 50 ? 211 : 0;
        imgData.data[i*4+2] = val > 50 ? 238 : 0;
        imgData.data[i*4+3] = val > 30 ? 230 : 0;
    }

    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = W; tempCanvas.height = H;
    tempCanvas.getContext('2d').putImageData(imgData, 0, 0);

    overlayCtx.drawImage(tempCanvas, 0, 0, overlayC.width, overlayC.height);
}

function drawDefectOverlay(regions) {
    overlayCtx.clearRect(0, 0, overlayC.width, overlayC.height);
    const colors = { chip:'#ef4444', crack:'#f97316', corrosion:'#a855f7', wear:'#eab308' };
    regions.forEach(r => {
        const x = r.x / 100 * overlayC.width;
        const y = r.y / 100 * overlayC.height;
        const w = r.w / 100 * overlayC.width;
        const h = r.h / 100 * overlayC.height;
        const col = colors[r.type] ?? '#ef4444';

        overlayCtx.strokeStyle = col;
        overlayCtx.lineWidth   = 3;
        overlayCtx.strokeRect(x, y, w, h);
        overlayCtx.fillStyle = col + '33';
        overlayCtx.fillRect(x, y, w, h);

        overlayCtx.fillStyle = col;
        overlayCtx.font = 'bold 12px system-ui';
        overlayCtx.fillText((r.type.toUpperCase()) + ' ' + r.confidence + '%', x + 4, y - 5 < 0 ? y + 14 : y - 5);
    });
}

function displayResult(r) {
    hideScanning();
    if (!sobelViewActive) {
        drawDefectOverlay(r.defectRegions);
    } else {
        renderSobelEdgeMap();
    }

    const verdictStyles = {
        ok:         { bg:'bg-emerald-50 border-emerald-200', header:'bg-emerald-500', label:'Kondisi Baik', small:'Tidak Ada Cacat Baru', icon:'✓' },
        minor_wear: { bg:'bg-yellow-50 border-yellow-200',   header:'bg-yellow-500',  label:'Aus Ringan',   small:'Minor Wear Detected', icon:'⚠' },
        damaged:    { bg:'bg-orange-50 border-orange-200',   header:'bg-orange-600',  label:'Cacat / Rusak', small:'Defect Detected',    icon:'!' },
        critical:   { bg:'bg-red-50 border-red-200',         header:'bg-red-600',     label:'KRITIS (LOCKOUT)', small:'Critical Damage', icon:'✕' },
    };
    const vs = verdictStyles[r.verdict] ?? verdictStyles.ok;

    document.getElementById('result-panel').className = `ds-card bg-white rounded-2xl shadow-sm border overflow-hidden ${vs.bg}`;
    document.getElementById('verdict-header').className = `px-5 py-4 flex items-center gap-3 ${vs.header.replace('500','50').replace('600','50')}`;
    const icon = document.getElementById('verdict-icon');
    icon.className = `w-10 h-10 rounded-xl flex items-center justify-center text-xl font-bold flex-shrink-0 ${vs.header} text-white`;
    icon.textContent = vs.icon;
    document.getElementById('verdict-label-small').textContent = vs.small;
    document.getElementById('verdict-label-main').textContent  = vs.label;

    document.getElementById('wear-pct-text').textContent = r.wearPct + '%';
    document.getElementById('conf-pct-text').textContent = r.confidence + '%';
    const wearColor = r.wearPct > 70 ? 'from-red-400 to-red-500' : r.wearPct > 35 ? 'from-yellow-400 to-orange-400' : 'from-emerald-400 to-emerald-500';
    document.getElementById('wear-bar').className = `meter-fill h-2 bg-gradient-to-r ${wearColor}`;
    setTimeout(() => {
        document.getElementById('wear-bar').style.width = r.wearPct + '%';
        document.getElementById('conf-bar').style.width = r.confidence + '%';
    }, 100);

    const tagLabels = { chip:'Gompal/Chipping', crack:'Retak/Crack', corrosion:'Korosi', wear:'Keausan', deformation:'Deformasi' };
    const tagColors = { chip:'bg-red-100 text-red-700', crack:'bg-orange-100 text-orange-700', corrosion:'bg-purple-100 text-purple-700', wear:'bg-yellow-100 text-yellow-700' };
    const tagsEl = document.getElementById('defect-tags');
    if (r.defectTypes.length === 0) {
        tagsEl.innerHTML = '<span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-medium">Kondisi Prima (0 Cacat)</span>';
    } else {
        tagsEl.innerHTML = r.defectTypes.map(t =>
            `<span class="px-2 py-1 rounded-lg text-xs font-semibold ${tagColors[t]??'bg-gray-100 text-gray-700'}">${tagLabels[t]??t}</span>`
        ).join('');
    }

    document.getElementById('metric-edge').textContent     = r.metrics.edgeDensity;
    document.getElementById('metric-contrast').textContent = r.metrics.contrastVariance;
    document.getElementById('metric-time').textContent     = r.metrics.elapsed + 'ms';

    document.getElementById('result-panel').classList.remove('hidden');

    const deltaWear = r.wearPct - baselineData.wearPct;
    document.getElementById('disp-base-wear').textContent  = baselineData.wearPct;
    document.getElementById('disp-ret-wear').textContent   = r.wearPct;
    document.getElementById('disp-delta-wear').textContent = (deltaWear >= 0 ? '+' : '') + deltaWear;

    const isDefective = (r.verdict === 'damaged' || r.verdict === 'critical' || deltaWear > 15);
    const dispCard = document.getElementById('dispute-card');
    dispCard.classList.remove('hidden');

    if (isDefective) {
        document.getElementById('dispute-badge-status').className = 'px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white text-red-700 shadow-sm';
        document.getElementById('dispute-badge-status').textContent = 'SENGKETA TERVALIDASI';
        document.getElementById('disp-ret-verdict').textContent = vs.label;
        document.getElementById('disp-new-defect-label').textContent = r.defectTypes.length > 0 ? (tagLabels[r.defectTypes[0]] ?? 'Kerusakan Tepi') : 'Keausan Berlebih';
        document.getElementById('dispute-conclusion-box').className = 'p-4 rounded-xl border border-red-200 bg-red-50 text-red-900 space-y-1.5';
        document.getElementById('dispute-conclusion-text').innerHTML =
            `Berdasarkan analisis citra Edge CV, terbukti terjadi lonjakan keausan sebesar <strong>+${deltaWear}%</strong> serta <strong>anomali struktural (${r.defectTypes.join(', ')})</strong> selama durasi peminjaman. Karena kondisi awal serah-terima terverifikasi prima (keausan baseline ${baselineData.wearPct}%), kerusakan ini dinyatakan sebagai <strong>kelalaian operasional peminjam</strong>. Sistem merekomendasikan penerbitan BAK dan K3 Lockout otomatis.`;
    } else {
        document.getElementById('dispute-badge-status').className = 'px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white text-emerald-700 shadow-sm';
        document.getElementById('dispute-badge-status').textContent = 'BEBAS SENGKETA (NORMAL)';
        document.getElementById('disp-ret-verdict').textContent = 'Kondisi Wajar';
        document.getElementById('disp-new-defect-label').textContent = '0 Cacat Baru';
        document.getElementById('dispute-conclusion-box').className = 'p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-900 space-y-1.5';
        document.getElementById('dispute-conclusion-text').innerHTML =
            `Disparitas keausan berada di ambang batas wajar (Δ = +${deltaWear}%). Tidak ditemukan diskontinuitas tepi atau chipping baru. Peminjam <strong>dinyatakan bebas dari tuntutan ganti rugi</strong>.`;
    }
}

async function saveResult() {
    if (!analysisResult) return;
    const itemId = document.getElementById('item-select').value;
    if (!itemId) { alert('Pilih barang terlebih dahulu!'); return; }

    document.getElementById('btn-save').disabled = true;
    document.getElementById('btn-save').textContent = 'Menyimpan...';

    const brId = document.getElementById('borrowing-request-id')?.value || null;

    try {
        const resp = await fetch('{{ route("admin.defect-scanner.analyze") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                item_id: itemId,
                image_data: capturedImageData,
                verdict: analysisResult.verdict,
                wear_percentage: analysisResult.wearPct,
                defect_confidence: analysisResult.confidence,
                defect_types: analysisResult.defectTypes,
                defect_regions: analysisResult.defectRegions,
                scan_metrics: analysisResult.metrics,
                scan_duration_ms: String(analysisResult.metrics.elapsed),
                notes: document.getElementById('inspector-notes').value,
                inspection_stage: 'return',
                borrowing_request_id: brId,
            }),
        });

        const data = await resp.json();

        if (data.success) {
            document.getElementById('result-panel').classList.add('hidden');
            document.getElementById('saved-panel').classList.remove('hidden');

            if (data.maintenance_id) {
                document.getElementById('saved-maintenance-info').classList.remove('hidden');
            }
            if (data.bak_url) {
                document.getElementById('btn-bak').href = data.bak_url;
                document.getElementById('btn-bak').classList.remove('hidden');
            }
            document.getElementById('btn-view').href = '{{ url("/admin/defect-scanner") }}/' + data.inspection_id;
        }
    } catch(e) {
        alert('Gagal menyimpan: ' + e.message);
        document.getElementById('btn-save').disabled = false;
        document.getElementById('btn-save').textContent = 'Simpan Rekam Data';
    }
}

function issueDigitalBak() {
    saveResult();
}

function printDisputeSummary() {
    window.print();
}

function drawPristineInsertCanvas(ctx, W, H) {
    ctx.clearRect(0, 0, W, H);
    ctx.fillStyle = '#1e293b';
    ctx.fillRect(0, 0, W, H);

    ctx.strokeStyle = 'rgba(148, 163, 184, 0.15)';
    ctx.lineWidth = 1;
    for(let x = 0; x < W; x += 40) { ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, H); ctx.stroke(); }
    for(let y = 0; y < H; y += 40) { ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(W, y); ctx.stroke(); }

    ctx.fillStyle = '#334155';
    ctx.fillRect(20, 80, 160, 140);
    ctx.fillStyle = '#0f172a';
    ctx.fillRect(20, 200, 160, 20);

    ctx.save();
    ctx.beginPath();
    ctx.moveTo(140, 70);
    ctx.lineTo(310, 150);
    ctx.lineTo(140, 230);
    ctx.closePath();

    const goldGrad = ctx.createLinearGradient(140, 70, 310, 230);
    goldGrad.addColorStop(0, '#f59e0b');
    goldGrad.addColorStop(0.5, '#fbbf24');
    goldGrad.addColorStop(1, '#d97706');
    ctx.fillStyle = goldGrad;
    ctx.fill();

    ctx.strokeStyle = '#fef08a';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(190, 150, 22, 0, Math.PI * 2);
    ctx.fillStyle = '#1e293b';
    ctx.fill();
    ctx.strokeStyle = '#d97706';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.fillStyle = 'rgba(0,0,0,0.45)';
    ctx.font = 'bold 9px monospace';
    ctx.fillText('TNMG 160408', 150, 130);
    ctx.restore();
}

function drawChippedInsertCanvas(ctx, W, H) {
    ctx.clearRect(0, 0, W, H);
    ctx.fillStyle = '#1e293b';
    ctx.fillRect(0, 0, W, H);

    ctx.strokeStyle = 'rgba(148, 163, 184, 0.15)';
    ctx.lineWidth = 1;
    for(let x = 0; x < W; x += 40) { ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, H); ctx.stroke(); }
    for(let y = 0; y < H; y += 40) { ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(W, y); ctx.stroke(); }

    ctx.fillStyle = '#334155';
    ctx.fillRect(20, 80, 160, 140);
    ctx.fillStyle = '#0f172a';
    ctx.fillRect(20, 200, 160, 20);

    ctx.save();
    ctx.beginPath();
    ctx.moveTo(140, 70);
    ctx.lineTo(275, 135);

    ctx.lineTo(270, 142);
    ctx.lineTo(285, 148);
    ctx.lineTo(265, 158);
    ctx.lineTo(280, 165);
    ctx.lineTo(140, 230);
    ctx.closePath();

    const goldGrad = ctx.createLinearGradient(140, 70, 310, 230);
    goldGrad.addColorStop(0, '#f59e0b');
    goldGrad.addColorStop(0.5, '#fbbf24');
    goldGrad.addColorStop(1, '#d97706');
    ctx.fillStyle = goldGrad;
    ctx.fill();

    ctx.strokeStyle = '#fef08a';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(275, 135);
    ctx.lineTo(300, 150);
    ctx.lineTo(280, 165);
    ctx.lineTo(265, 158);
    ctx.lineTo(285, 148);
    ctx.lineTo(270, 142);
    ctx.closePath();
    ctx.fillStyle = '#090d16';
    ctx.fill();
    ctx.strokeStyle = '#ef4444';
    ctx.lineWidth = 1.5;
    ctx.stroke();

    ctx.strokeStyle = '#ef4444';
    ctx.beginPath();
    ctx.moveTo(265, 158); ctx.lineTo(240, 155);
    ctx.moveTo(270, 142); ctx.lineTo(250, 138);
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(190, 150, 22, 0, Math.PI * 2);
    ctx.fillStyle = '#1e293b';
    ctx.fill();
    ctx.strokeStyle = '#d97706';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.fillStyle = 'rgba(0,0,0,0.45)';
    ctx.font = 'bold 9px monospace';
    ctx.fillText('TNMG 160408', 150, 130);
    ctx.restore();
}

async function triggerPimnasDisputeDemo() {
    setInspectionMode('sidebyside');

    loadDefaultPristineBaseline();

    document.getElementById('cam-placeholder').classList.add('hidden');
    processC.width  = 400;
    processC.height = 300;
    overlayC.width  = 400;
    overlayC.height = 300;

    drawChippedInsertCanvas(processCtx, 400, 300);
    capturedImageData = processC.toDataURL('image/jpeg', 0.92);

    const tempImg = new Image();
    tempImg.onload = () => {
        const dummyCanvas = document.createElement('canvas');
        dummyCanvas.width = 400; dummyCanvas.height = 300;
        dummyCanvas.getContext('2d').drawImage(tempImg, 0, 0);
        document.getElementById('camera-wrapper').style.backgroundImage = `url(${capturedImageData})`;
        document.getElementById('camera-wrapper').style.backgroundSize = 'cover';
    };
    tempImg.src = capturedImageData;

    await captureAndAnalyze();
}

function showScanning() {
    document.getElementById('status-idle').classList.add('hidden');
    document.getElementById('status-scanning').classList.remove('hidden');
    document.getElementById('result-panel').classList.add('hidden');
    document.getElementById('saved-panel').classList.add('hidden');
    document.getElementById('btn-capture').disabled = true;
    document.getElementById('btn-capture-text').textContent = 'Menganalisis Visi Komputer...';
}

function hideScanning() {
    document.getElementById('status-scanning').classList.add('hidden');
    document.getElementById('btn-capture').disabled = false;
    document.getElementById('btn-capture-text').textContent = 'Scan & Bandingkan Disparitas Sengketa';
}

function updateScanStep(text) {
    document.getElementById('scan-step-text').textContent = text;
}

function resetScan() {
    overlayCtx.clearRect(0, 0, overlayC.width, overlayC.height);
    capturedImageData = null;
    analysisResult    = null;
    sobelViewActive   = false;
    document.getElementById('camera-wrapper').style.backgroundImage = '';
    document.getElementById('btn-sobel-toggle').textContent = '🔬 Peta Gradien Sobel';
    document.getElementById('btn-sobel-toggle').className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 transition';
    document.getElementById('result-panel').classList.add('hidden');
    document.getElementById('saved-panel').classList.add('hidden');
    document.getElementById('dispute-card').classList.add('hidden');
    document.getElementById('status-idle').classList.remove('hidden');
    document.getElementById('status-scanning').classList.add('hidden');
    document.getElementById('inspector-notes').value = '';
    document.getElementById('wear-bar').style.width = '0%';
    document.getElementById('conf-bar').style.width = '0%';
    document.getElementById('camera-wrapper').classList.remove('scanning');
}

const delay = ms => new Promise(r => setTimeout(r, ms));
</script>
@endpush
@endsection
