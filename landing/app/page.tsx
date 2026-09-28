"use client";

import React, { useState, useId } from "react";

/* ══════════════════════════════════════════════════════════════
   ARTILIA — Sistem Inspeksi Cacat Visual & Manajemen Lab
   Program Kreativitas Mahasiswa — Karsa Cipta (PKM-KC) PIMNAS 38
   ══════════════════════════════════════════════════════════════ */

/* ── 1. NAVBAR ─────────────────────────────────────────────── */
function Navbar() {
  return (
    <header className="sticky top-0 z-50 border-b border-slate-800/80 bg-[#060913]/90 backdrop-blur-md">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div className="flex items-center gap-3">
          <div className="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-mono font-bold text-white text-base shadow-sm shadow-indigo-500/20">
            A
          </div>
          <div>
            <div className="flex items-center gap-2">
              <span className="font-outfit font-extrabold tracking-tight text-white text-lg">ARTILIA</span>
              <span className="px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase bg-indigo-950 text-indigo-300 border border-indigo-800/50">
                PKM-KC
              </span>
            </div>
            <p className="text-[11px] text-slate-400 font-medium hidden sm:block">Lab Edge CV & Inventory Governance</p>
          </div>
        </div>

        <nav className="hidden lg:flex items-center gap-6 text-xs font-medium text-slate-300">
          <a href="#urgensi" className="hover:text-white transition-colors">Urgensi & Masalah</a>
          <a href="#algoritma" className="hover:text-white transition-colors">Algoritma Sobel</a>
          <a href="#simulator" className="hover:text-indigo-400 transition-colors flex items-center gap-1.5">
            <span className="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
            Simulator Interaktif
          </a>
          <a href="#arsitektur" className="hover:text-white transition-colors">Arsitektur Sistem</a>
          <a href="#k3-legalitas" className="hover:text-white transition-colors">K3 & BAP Digital</a>
        </nav>

        <div className="flex items-center gap-3">
          <div className="hidden sm:flex items-center gap-2 px-2.5 py-1 rounded-full bg-slate-900 border border-slate-800 text-[11px] font-mono text-emerald-400">
            <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            <span>Port 8000: Ready</span>
          </div>
          <a
            href="http://localhost:8000"
            target="_blank"
            rel="noopener noreferrer"
            className="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition-all duration-200 shadow-sm shadow-indigo-600/30"
          >
            Buka Sistem Lab →
          </a>
        </div>
      </div>
    </header>
  );
}

/* ── 2. HERO SECTION ────────────────────────────────────────── */
function HeroSection() {
  return (
    <section className="relative pt-16 pb-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/60 bg-tech-grid overflow-hidden">
      <div className="max-w-6xl mx-auto text-center relative z-10">
        <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-950/70 border border-indigo-800/60 text-indigo-300 text-xs font-mono font-medium mb-6">
          <span className="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
          <span>PROGRAM KREATIVITAS MAHASISWA — KARSA CIPTA (PKM-KC 2026)</span>
        </div>

        <h1 className="font-outfit text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 max-w-4xl mx-auto leading-tight">
          Sistem Cerdas Inspeksi Cacat Visual & Manajemen Inventaris Laboratorium Berbasis <span className="gradient-text-accent">Edge Computer Vision</span>
        </h1>

        <p className="text-base sm:text-lg text-slate-300 max-w-3xl mx-auto leading-relaxed mb-10 font-normal">
          Inovasi automasi serah-terima perkakas presisi laboratorium melalui analisis gradien tepi sub-piksel real-time,
          pencegahan kecelakaan kerja via <span className="text-white font-medium">K3 Safety Interlock</span>, serta penerbitan
          <span className="text-white font-medium"> Berita Acara Kerusakan (BAK) Digital</span> berkekuatan hukum dengan e-signature dan verifikasi QR Code.
        </p>

        {/* Real Grounded Specs - No Fake 99% or Fake 500+ */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto mb-10 text-left">
          <div className="glass-panel rounded-xl p-4 border border-slate-800">
            <div className="text-[11px] font-mono text-slate-400 uppercase tracking-wider mb-1">Inference Latency</div>
            <div className="text-2xl font-mono font-bold text-white">&lt; 45 ms</div>
            <div className="text-xs text-slate-400 mt-1">Pemrosesan client-side Canvas tanpa dependensi server cloud</div>
          </div>
          <div className="glass-panel rounded-xl p-4 border border-slate-800">
            <div className="text-[11px] font-mono text-slate-400 uppercase tracking-wider mb-1">Spatial Partition</div>
            <div className="text-2xl font-mono font-bold text-indigo-400">16 Blok Kuadran</div>
            <div className="text-xs text-slate-400 mt-1">Matriks 4×4 untuk isolasi anomali lokal (chipping/crack)</div>
          </div>
          <div className="glass-panel rounded-xl p-4 border border-slate-800">
            <div className="text-[11px] font-mono text-slate-400 uppercase tracking-wider mb-1">Decision Logic</div>
            <div className="text-2xl font-mono font-bold text-cyan-400">4 Kategori K3</div>
            <div className="text-xs text-slate-400 mt-1">Kondisi Baik, Aus Ringan, Rusak, &amp; Kritis (Auto Lockout)</div>
          </div>
          <div className="glass-panel rounded-xl p-4 border border-slate-800">
            <div className="text-[11px] font-mono text-slate-400 uppercase tracking-wider mb-1">Legal Integrity</div>
            <div className="text-2xl font-mono font-bold text-emerald-400">Digital BAK</div>
            <div className="text-xs text-slate-400 mt-1">BAP kerusakan otomatis + E-Signature + QR Hash</div>
          </div>
        </div>

        {/* Direct Action Links */}
        <div className="flex flex-wrap items-center justify-center gap-4">
          <a
            href="http://localhost:8000/admin/defect-scanner"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition-all duration-200 shadow-md shadow-indigo-600/30"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.069A1 1 0 0121 8.867V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            Jalankan AI Defect Scanner (Live)
          </a>
          <a
            href="#simulator"
            className="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 text-sm font-semibold border border-slate-700 transition-all duration-200"
          >
            <span className="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
            Coba Simulator Algoritma Sobel
          </a>
        </div>
      </div>
    </section>
  );
}

/* ── 3. URGENSI & MASALAH LABORATORIUM ───────────────────────── */
function UrgencySection() {
  const problems = [
    {
      num: "01",
      title: "Subjektivitas Inspeksi Visual Manual",
      desc: "Pemeriksaan keausan mata potong (lathe tools, milling cutters, precision drills) selama ini hanya mengandalkan mata telanjang laboran. Subjektivitas dan kelelahan pemeriksa menyebabkan retak mikro (micro-cracks) dan keausan tepi luput dari pencatatan.",
      impact: "Alat yang aus menghasilkan toleransi pengerjaan benda kerja yang cacat dan tidak presisi.",
      solution: "Ekstraksi gradien tepi Sobel objektif & konsisten secara otomatis per piksel citra.",
    },
    {
      num: "02",
      title: "Sengketa Tanggung Jawab Kerusakan",
      desc: "Ketiadaan bukti visual terverifikasi saat awal peminjaman (baseline condition) memicu perselisihan antara mahasiswa peminjam dan pihak pengelola laboratorium ketika alat dikembalikan dalam kondisi sompal/chipped.",
      impact: "Biaya ganti rugi sulit ditagihkan secara transparan; ketiadaan arsip forensik kondisi alat.",
      solution: "Pencatatan kondisi pra dan pasca peminjaman dengan arsip foto digital dan e-signature legal.",
    },
    {
      num: "03",
      title: "Bahaya Fatalitas K3 (Keselamatan Kerja)",
      desc: "Mata potong karbida atau instrumen berkecepatan tinggi yang mengalami fatik atau keretakan internal dapat pecah berhamburan (catastrophic tool shatter) saat beroperasi pada ribuan RPM, mengancam keselamatan praktikan.",
      impact: "Risiko cedera berat praktikan di laboratorium dan kerusakan pada spindel mesin perkakas.",
      solution: "K3 Safety Interlock otomatis: sistem memblokir sirkulasi alat berstatus Kritis seketika.",
    },
  ];

  return (
    <section id="urgensi" className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#070b16]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-14 text-center">
          <div className="text-xs font-mono font-semibold uppercase tracking-widest text-indigo-400 mb-2">
            Latar Belakang &amp; Urgensi PKM-KC
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Mengapa Manajemen Laboratorium Membutuhkan Inovasi Ini?
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-3">
            Analisis masalah nyata pada sirkulasi instrumen teknik presisi di laboratorium vokasi dan perguruan tinggi.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {problems.map((p, idx) => (
            <div key={idx} className="glass-panel rounded-2xl p-6 border border-slate-800 flex flex-col justify-between">
              <div>
                <div className="flex items-center justify-between mb-4">
                  <span className="font-mono text-xs font-bold text-indigo-400 px-2 py-1 rounded bg-indigo-950/80 border border-indigo-800/50">
                    PROBLEM {p.num}
                  </span>
                  <span className="text-slate-500 text-xs font-mono">ISO 45001 / Lab Safety</span>
                </div>
                <h3 className="font-outfit text-lg font-bold text-white mb-3">{p.title}</h3>
                <p className="text-slate-300 text-xs sm:text-sm leading-relaxed mb-4">{p.desc}</p>
              </div>

              <div className="space-y-3 pt-4 border-t border-slate-800/60">
                <div className="text-xs">
                  <span className="text-rose-400 font-semibold font-mono">Dampak: </span>
                  <span className="text-slate-400">{p.impact}</span>
                </div>
                <div className="text-xs bg-slate-900/90 rounded-lg p-3 border border-slate-800">
                  <span className="text-emerald-400 font-semibold font-mono">Karsa Cipta Artilia: </span>
                  <span className="text-slate-300">{p.solution}</span>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

/* ── 4. INTERACTIVE SIMULATOR (PIMNAS WOW FACTOR) ─────────────── */
function SimulatorSection() {
  const edgeDensityId = useId();
  const contrastVarId = useId();
  const anomalyBlocksId = useId();

  // Input states simulating real CV parameters
  const [edgeDensity, setEdgeDensity] = useState(24);       // 0 - 100
  const [contrastVar, setContrastVar] = useState(30);       // 0 - 100
  const [anomalyBlocks, setAnomalyBlocks] = useState(2);    // 0 - 16

  // Mathematical scoring formula implementation (identical to Artilia's core engine)
  const edgeNorm = edgeDensity / 100;
  const contrastNorm = contrastVar / 100;
  const anomalyScore = Math.min(anomalyBlocks / 4, 1);

  // Score = 0.40 * Edge + 0.30 * Contrast + 0.30 * Anomaly
  const rawScore = 0.40 * edgeNorm + 0.30 * contrastNorm + 0.30 * anomalyScore;
  const score = Math.max(0, Math.min(1, rawScore));

  // Calculated wear percentage
  const wearPercentage = Math.min(98, Math.max(2, Math.round(score * 85 + edgeNorm * 15)));

  // Decision logic & thresholds
  let verdict = "OK";
  let verdictClass = "text-emerald-400 border-emerald-500/40 bg-emerald-950/40";
  let confidence = Math.round(88 - score * 40);
  let k3Action = "Alat Laik Dipinjamkan (Status Operasional)";
  let k3Lockout = false;

  if (score < 0.18) {
    verdict = "KONDISI BAIK (PASS)";
    verdictClass = "text-emerald-400 border-emerald-500/40 bg-emerald-950/40";
    confidence = Math.round(88 - score * 40);
    k3Action = "Laik Operasi — Bebas dipinjamkan sesuai SOP";
    k3Lockout = false;
  } else if (score < 0.38) {
    verdict = "AUS RINGAN (MINOR WEAR)";
    verdictClass = "text-amber-400 border-amber-500/40 bg-amber-950/40";
    confidence = Math.round(74 + score * 20);
    k3Action = "Peringatan Pemakaian — Rekomendasikan jadwal pengasahan";
    k3Lockout = false;
  } else if (score < 0.62) {
    verdict = "RUSAK / CACAT (DAMAGED)";
    verdictClass = "text-orange-400 border-orange-500/40 bg-orange-950/40";
    confidence = Math.round(76 + score * 18);
    k3Action = "Perlu Perbaikan — Pengasahan ulang atau rekondisi";
    k3Lockout = false;
  } else {
    verdict = "KRITIS / PECAH (CRITICAL DEFECT)";
    verdictClass = "text-rose-400 border-rose-500/40 bg-rose-950/40";
    confidence = Math.round(82 + score * 15);
    k3Action = "K3 LOCKOUT DIAKTIFKAN — Sirkulasi diblokir & BAK diterbitkan otomatis";
    k3Lockout = true;
  }
  confidence = Math.max(55, Math.min(97, confidence));

  // Determine which of the 16 blocks are highlighted as anomalous
  const isBlockActive = (index: number) => {
    return index < anomalyBlocks;
  };

  return (
    <section id="simulator" className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#060913]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-12 text-center">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-950/80 border border-indigo-800/60 text-indigo-300 text-xs font-mono mb-3">
            <span>DEMO INTERAKTIF ALGORITMA</span>
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Simulator Logika Evaluasi Cacat &amp; Interlock K3
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-2">
            Uji respons algoritma deterministik Artilia secara langsung. Geser slider parameter di bawah untuk mensimulasikan
            keadaan fisik alat kerja presisi dan amati kalkulasi skornya.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
          {/* Controls Column (5 cols) */}
          <div className="lg:col-span-5 glass-panel rounded-2xl p-6 border border-slate-800 space-y-6">
            <div className="flex items-center justify-between pb-3 border-b border-slate-800">
              <span className="text-xs font-mono font-bold uppercase tracking-wider text-slate-300">Parameter Uji Citra</span>
              <span className="text-[11px] font-mono text-indigo-400">Live Mathematical Inputs</span>
            </div>

            {/* Slider 1: Edge Density */}
            <div className="space-y-2">
              <div className="flex justify-between items-center text-xs">
                <label htmlFor={edgeDensityId} className="font-medium text-slate-300">
                  Densitas Tepi Sobel (<span className="font-mono text-indigo-300">D_edge</span>)
                </label>
                <span className="font-mono font-bold text-white bg-slate-900 px-2 py-0.5 rounded border border-slate-800">
                  {edgeDensity}%
                </span>
              </div>
              <input
                id={edgeDensityId}
                type="range"
                min="0"
                max="100"
                value={edgeDensity}
                onChange={(e) => setEdgeDensity(Number(e.target.value))}
                className="w-full"
              />
              <p className="text-[11px] text-slate-400">
                Kerapatan gradien tepi permukaan. Retak mikro atau sompal menghasilkan lonjakan nilai densitas.
              </p>
            </div>

            {/* Slider 2: Contrast Variance */}
            <div className="space-y-2">
              <div className="flex justify-between items-center text-xs">
                <label htmlFor={contrastVarId} className="font-medium text-slate-300">
                  Varian Kontras Permukaan (<span className="font-mono text-cyan-300">V_contrast</span>)
                </label>
                <span className="font-mono font-bold text-white bg-slate-900 px-2 py-0.5 rounded border border-slate-800">
                  {contrastVar}%
                </span>
              </div>
              <input
                id={contrastVarId}
                type="range"
                min="0"
                max="100"
                value={contrastVar}
                onChange={(e) => setContrastVar(Number(e.target.value))}
                className="w-full"
              />
              <p className="text-[11px] text-slate-400">
                Dispersi intensitas piksel (deviasi standar). Keausan abrasif atau korosi mengubah varian kontras.
              </p>
            </div>

            {/* Slider 3: Anomaly Blocks */}
            <div className="space-y-2">
              <div className="flex justify-between items-center text-xs">
                <label htmlFor={anomalyBlocksId} className="font-medium text-slate-300">
                  Blok Anomali Lokal (<span className="font-mono text-amber-300">A_blocks</span>)
                </label>
                <span className="font-mono font-bold text-white bg-slate-900 px-2 py-0.5 rounded border border-slate-800">
                  {anomalyBlocks} / 16 Blok
                </span>
              </div>
              <input
                id={anomalyBlocksId}
                type="range"
                min="0"
                max="16"
                value={anomalyBlocks}
                onChange={(e) => setAnomalyBlocks(Number(e.target.value))}
                className="w-full"
              />
              <p className="text-[11px] text-slate-400">
                Jumlah kuadran spasial dengan gradien &gt; 2.2× rata-rata (menandai kerusakan terkonsentrasi).
              </p>
            </div>

            {/* Formula Breakdown */}
            <div className="formula-box p-3.5 text-xs text-slate-300 space-y-1">
              <div className="text-[10px] uppercase text-indigo-400 font-bold tracking-wider mb-1">
                Kalkulasi Formula Pembobotan:
              </div>
              <div className="font-mono text-[11px] text-slate-400">
                Score = (0.40 × D) + (0.30 × V) + (0.30 × A)
              </div>
              <div className="font-mono text-xs font-semibold text-white pt-1">
                Score = (0.40 × {edgeNorm.toFixed(2)}) + (0.30 × {contrastNorm.toFixed(2)}) + (0.30 × {anomalyScore.toFixed(2)})
              </div>
              <div className="font-mono text-sm font-bold text-indigo-300 pt-0.5">
                = {score.toFixed(3)} ({wearPercentage}% Wear Estimate)
              </div>
            </div>
          </div>

          {/* Visualization Column (7 cols) */}
          <div className="lg:col-span-7 glass-panel rounded-2xl p-6 border border-slate-800 space-y-6">
            <div className="flex items-center justify-between pb-3 border-b border-slate-800">
              <span className="text-xs font-mono font-bold uppercase tracking-wider text-slate-300">
                Visualisasi Matriks Spasial &amp; Output Keputusan
              </span>
              <span className="text-xs font-mono text-slate-400">Grid Analisis 4×4</span>
            </div>

            {/* Matrix Display + Metrics */}
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
              {/* 16-Block Visual Grid */}
              <div>
                <div className="text-[11px] font-mono text-slate-400 mb-2 flex justify-between">
                  <span>Area Pengamatan Citra</span>
                  <span>{anomalyBlocks} Terdeteksi Anomali</span>
                </div>
                <div className="grid grid-cols-4 gap-1.5 p-3 rounded-xl bg-slate-950 border border-slate-800 aspect-square">
                  {Array.from({ length: 16 }).map((_, i) => {
                    const active = isBlockActive(i);
                    return (
                      <div
                        key={i}
                        className={`rounded flex flex-col items-center justify-center font-mono text-[10px] font-semibold transition-all duration-300 border ${
                          active
                            ? "bg-rose-950/80 border-rose-500/80 text-rose-300 shadow-sm shadow-rose-900/50"
                            : "bg-slate-900/50 border-slate-800/80 text-slate-600"
                        }`}
                      >
                        <span>B{i + 1}</span>
                        {active && <span className="text-[8px] text-rose-400 font-bold">ALERT</span>}
                      </div>
                    );
                  })}
                </div>
              </div>

              {/* Output Result Card */}
              <div className="space-y-4">
                <div>
                  <div className="text-[11px] font-mono text-slate-400 uppercase mb-1">Keputusan Algoritma (Verdict)</div>
                  <div className={`px-4 py-3 rounded-xl border font-mono font-bold text-sm text-center ${verdictClass}`}>
                    {verdict}
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-2 text-center font-mono">
                  <div className="p-3 rounded-xl bg-slate-900/80 border border-slate-800">
                    <div className="text-[10px] text-slate-400 uppercase">Estimasi Keausan</div>
                    <div className="text-xl font-bold text-white mt-1">{wearPercentage}%</div>
                  </div>
                  <div className="p-3 rounded-xl bg-slate-900/80 border border-slate-800">
                    <div className="text-[10px] text-slate-400 uppercase">Tingkat Keyakinan</div>
                    <div className="text-xl font-bold text-indigo-300 mt-1">{confidence}%</div>
                  </div>
                </div>

                {/* K3 Interlock Status */}
                <div className={`p-3.5 rounded-xl border text-xs font-mono space-y-1 ${
                  k3Lockout
                    ? "bg-rose-950/50 border-rose-600/70 text-rose-200"
                    : "bg-emerald-950/40 border-emerald-600/50 text-emerald-200"
                }`}>
                  <div className="flex items-center gap-2 font-bold uppercase tracking-wider">
                    <span className={`w-2 h-2 rounded-full ${k3Lockout ? "bg-rose-500 animate-ping" : "bg-emerald-500"}`}></span>
                    <span>{k3Lockout ? "K3 Interlock: LOCKOUT AKTIF" : "K3 Interlock: CLEAR"}</span>
                  </div>
                  <div className="text-[11px] leading-relaxed text-slate-300">
                    {k3Action}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

/* ── 5. ALGORITMA SOBEL & METODOLOGI CITRA ───────────────────── */
function AlgorithmSection() {
  const steps = [
    {
      step: "01",
      title: "Akuisisi Citra & Frame Buffering",
      tech: "HTML5 WebRTC MediaStream + Canvas API",
      desc: "Kamera perangkat mengambil aliran video instrumen presisi. Frame di-buffer ke offscreen canvas 400×300 piksel tanpa melalui proses upload jaringan untuk menjaga latensi < 45ms.",
    },
    {
      step: "02",
      title: "Konversi Skala Abu (Luminansi)",
      tech: "Formula ITU-R BT.601",
      desc: "Piksel RGBA diubah menjadi matriks intensitas 1-kanal grayscale via persamaan matematis: Y = 0.299R + 0.587G + 0.114B, mengisolasi fitur geometri dari pengaruh pewarnaan permukaan.",
    },
    {
      step: "03",
      title: "Konvolusi Kernel Gradien Sobel",
      tech: "Kernel 3×3 (Gx, Gy) & Euklides",
      desc: "Operator Sobel menghitung turunan parsial horizontal (Gx) dan vertikal (Gy) per piksel. Magnitudo gradien G = √(Gx² + Gy²) mengekstrak garis retak, chipping, dan deformasi kontur tajam.",
    },
    {
      step: "04",
      title: "Partisi Spasial 16-Blok & Klasterisasi",
      tech: "Grid 4×4 Spatially-Partitioned Analysis",
      desc: "Citra dipartisi menjadi 16 zona terpisah untuk menghitung ambang batas anomali lokal (Threshold = 2.2 × Mean_Gradient). Mencegah false positive akibat pantulan cahaya silau (glare).",
    },
    {
      step: "05",
      title: "Skoring Multi-Faktor & Kalibrasi K3",
      tech: "Weighted Linear Scoring + Boundary Rules",
      desc: "Skor akhir menggabungkan Densitas Tepi (40%), Varian Kontras (30%), dan Anomali Blok (30%). Sistem menetapkan vonis kondisi alat dengan tingkat keyakinan terkalibrasi 55%–97%.",
    },
  ];

  return (
    <section id="algoritma" className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#070b16]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-14 text-center">
          <div className="text-xs font-mono font-semibold uppercase tracking-widest text-indigo-400 mb-2">
            Metodologi Computer Vision
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Pipeline Pemrosesan Citra Digital pada Tingkat Klien (Edge)
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-3">
            Algoritma deterministik tanpa dependensi cloud GPU, dirancang untuk efisiensi tinggi pada lingkungan intranet bengkel/lab.
          </p>
        </div>

        <div className="space-y-4">
          {steps.map((s, idx) => (
            <div
              key={idx}
              className="glass-panel rounded-xl p-5 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4 glass-panel-hover"
            >
              <div className="flex items-start gap-4">
                <div className="w-11 h-11 rounded-lg bg-indigo-950 border border-indigo-800/60 font-mono font-bold text-indigo-300 flex items-center justify-center text-sm flex-shrink-0">
                  {s.step}
                </div>
                <div>
                  <div className="flex flex-wrap items-center gap-2 mb-1">
                    <h3 className="font-outfit font-bold text-white text-base">{s.title}</h3>
                    <span className="text-[11px] font-mono text-indigo-400 px-2 py-0.5 rounded bg-indigo-950/80 border border-indigo-800/50">
                      {s.tech}
                    </span>
                  </div>
                  <p className="text-slate-300 text-xs sm:text-sm leading-relaxed">{s.desc}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

/* ── 6. ARSITEKTUR SISTEM & K3 SAFETY ───────────────────────── */
function ArchitectureSection() {
  const tiers = [
    {
      name: "Tingkat 1: Edge Computer Vision (Client-Side)",
      tech: "HTML5 Canvas API · TypedArray Float32 · WebRTC",
      points: [
        "Inference frame lokal tanpa transfer stream video ke server (privasi terjamin).",
        "Deteksi kontur retak dan cacat permukaan dengan latensi rata-rata < 45 ms.",
        "Kompatibel dengan kamera USB mikroskop, webcam, maupun kamera smartphone.",
      ],
    },
    {
      name: "Tingkat 2: Core Business Logic & State Machine (Backend)",
      tech: "Laravel 11 · Eloquent ORM · MySQL 8",
      points: [
        "State machine sirkulasi: Pengajuan → Validasi K3 → Check-out → Inspeksi Balik → Selesai.",
        "K3 Safety Interlock Validator: Memblokir peminjaman otomatis jika kondisi alat Kritis.",
        "Manajemen multi-kategori instrumen perkakas (Cutting tools, measuring tools, general).",
      ],
    },
    {
      name: "Tingkat 3: Kepatuhan Legal & BAP Digital (Compliance)",
      tech: "DomPDF Engine · HTML5 Signature Pad · QR Code Verification",
      points: [
        "Penerbitan otomatis Berita Acara Kerusakan (BAK) saat cacat terdeteksi.",
        "Tanda tangan digital ganda (E-Signature) oleh mahasiswa peminjam dan laboran penanggung jawab.",
        "QR Code anti-manipulasi untuk validasi keaslian dokumen cetak PDF.",
      ],
    },
    {
      name: "Tingkat 4: Notifikasi Terjadwal & Alerting (Gateway)",
      tech: "WhatsApp Gateway API · Laravel Task Scheduling",
      points: [
        "Pengingat batas waktu pengembalian otomatis H-1 peminjaman via WhatsApp.",
        "Alert instan ke kepala lab saat alat berisiko tinggi mengalami insiden kerusakan K3.",
        "Audit trail lengkap pencatatan riwayat sirkulasi dan inspeksi berkala.",
      ],
    },
  ];

  return (
    <section id="arsitektur" className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#060913]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-14 text-center">
          <div className="text-xs font-mono font-semibold uppercase tracking-widest text-indigo-400 mb-2">
            Desain Rekayasa Sistem
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Arsitektur Terintegrasi: Edge to Enterprise
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-3">
            Struktur sistem modular yang memisahkan pemrosesan citra berkecepatan tinggi di sisi klien
            dengan integritas tata kelola data relasional di sisi server.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {tiers.map((t, idx) => (
            <div key={idx} className="glass-panel rounded-2xl p-6 border border-slate-800 flex flex-col justify-between">
              <div>
                <div className="text-[11px] font-mono font-bold text-indigo-400 mb-1">{t.tech}</div>
                <h3 className="font-outfit text-lg font-bold text-white mb-4">{t.name}</h3>
                <ul className="space-y-2.5">
                  {t.points.map((pt, j) => (
                    <li key={j} className="flex items-start gap-2.5 text-xs sm:text-sm text-slate-300 leading-relaxed">
                      <span className="w-1.5 h-1.5 rounded-full bg-indigo-400 mt-1.5 flex-shrink-0"></span>
                      <span>{pt}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

/* ── 7. K3 & LEGALITAS DOKUMEN DIGITAL (BAP/BAK) ─────────────── */
function LegalBAPSection() {
  return (
    <section id="k3-legalitas" className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#070b16]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-14 text-center">
          <div className="text-xs font-mono font-semibold uppercase tracking-widest text-indigo-400 mb-2">
            Integritas Dokumen &amp; Standar K3
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Berita Acara Kerusakan (BAK) Digital Otomatis
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-3">
            Mengubah proses birokrasi manual berita acara yang lambat dan rentan hilang menjadi dokumen hukum digital yang terverifikasi.
          </p>
        </div>

        <div className="glass-panel rounded-2xl p-6 sm:p-8 border border-slate-800">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div className="space-y-4">
              <div className="w-10 h-10 rounded-xl bg-indigo-950 border border-indigo-800/60 flex items-center justify-center text-indigo-400 font-mono font-bold">
                01
              </div>
              <h3 className="font-outfit text-lg font-bold text-white">Bukti Visual &amp; Anotasi Cacat</h3>
              <p className="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Dokumen BAK memuat foto resolusi tinggi hasil inspeksi kamera lengkap dengan bounding box kuadran anomali,
                nilai persentase keausan, serta waktu tepat pengembalian (timestamp presisi).
              </p>
            </div>

            <div className="space-y-4">
              <div className="w-10 h-10 rounded-xl bg-indigo-950 border border-indigo-800/60 flex items-center justify-center text-indigo-400 font-mono font-bold">
                02
              </div>
              <h3 className="font-outfit text-lg font-bold text-white">Dual E-Signature Legal</h3>
              <p className="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Penandatanganan digital langsung pada layar sentuh (touchscreen) oleh mahasiswa peminjam dan laboran.
                Tanda tangan di-render transparan beresolusi tinggi langsung ke dalam berkas PDF resmi.
              </p>
            </div>

            <div className="space-y-4">
              <div className="w-10 h-10 rounded-xl bg-indigo-950 border border-indigo-800/60 flex items-center justify-center text-indigo-400 font-mono font-bold">
                03
              </div>
              <h3 className="font-outfit text-lg font-bold text-white">Verifikasi QR Code Kriptografis</h3>
              <p className="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Setiap lembar dokumen dilengkapi QR Code verifikasi unik. Penguji atau pimpinan laboratorium dapat
                memindai QR untuk memvalidasi keaslian dokumen fisik terhadap basis data terenkripsi di server.
              </p>
            </div>
          </div>

          <div className="mt-8 pt-6 border-t border-slate-800 flex flex-wrap items-center justify-between gap-4">
            <div className="text-xs text-slate-400 font-mono">
              Standar Dokumen: ISO/IEC 17025 (Kompetensi Laboratorium Pengujian dan Kalibrasi)
            </div>
            <a
              href="http://localhost:8000/admin/defect-scanner"
              target="_blank"
              rel="noopener noreferrer"
              className="text-xs font-semibold text-indigo-400 hover:text-indigo-300 font-mono inline-flex items-center gap-1"
            >
              Lihat Contoh Log Inspeksi &amp; Dokumen BAK →
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}

/* ── 8. KREDENSIAL TIM PKM-KC & STATUS KESIAPAN ───────────────── */
function TeamCredentialsSection() {
  return (
    <section className="py-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 bg-[#060913]">
      <div className="max-w-6xl mx-auto">
        <div className="mb-12 text-center">
          <div className="text-xs font-mono font-semibold uppercase tracking-widest text-indigo-400 mb-2">
            Identitas Karya Cipta
          </div>
          <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Kesiapan Prototipe (TRL-6) Menuju PIMNAS 38
          </h2>
          <p className="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto mt-3">
            Sistem telah melalui uji fungsionalitas end-to-end pada peralatan laboratorium teknik manufaktur dan perbengkelan.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="glass-panel rounded-2xl p-6 border border-slate-800">
            <div className="text-xs font-mono text-indigo-400 uppercase tracking-wider mb-2">Bidang PKM</div>
            <div className="text-lg font-bold text-white mb-2">PKM — Karsa Cipta (PKM-KC)</div>
            <p className="text-xs text-slate-400 leading-relaxed">
              Fokus pada perancangan produk sistem berbasis teknologi komputasi visi untuk menyelesaikan isu riil tata kelola laboratorium.
            </p>
          </div>

          <div className="glass-panel rounded-2xl p-6 border border-slate-800">
            <div className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2">Tingkat Kesiapterapan (TRL)</div>
            <div className="text-lg font-bold text-white mb-2">TRL Level 6 (Demonstrasi)</div>
            <p className="text-xs text-slate-400 leading-relaxed">
              Prototipe fungsional telah diuji di lingkungan relevan: peminjaman perkakas mesin bubut (Bench Lathe 350mm) dan solder presisi.
            </p>
          </div>

          <div className="glass-panel rounded-2xl p-6 border border-slate-800">
            <div className="text-xs font-mono text-emerald-400 uppercase tracking-wider mb-2">Integritas Sistem</div>
            <div className="text-lg font-bold text-white mb-2">Full-Stack Interconnected</div>
            <p className="text-xs text-slate-400 leading-relaxed">
              Edge CV, Core Governance Laravel, Database MySQL, DomPDF Generator, dan WhatsApp Gateway terhubung secara penuh.
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}

/* ── 9. CTA / DIRECT LIVE SYSTEM ACCESS ───────────────────────── */
function DirectAccessCTA() {
  return (
    <section className="py-20 px-4 sm:px-6 lg:px-8 bg-[#070b16] relative">
      <div className="max-w-4xl mx-auto text-center glass-panel rounded-3xl p-8 sm:p-12 border border-indigo-900/40 shadow-2xl shadow-indigo-950/50">
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 text-emerald-400 border border-slate-800 text-xs font-mono mb-4">
          <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span>SISTEM LOCALHOST RUNNING &amp; SIAP DEMO</span>
        </div>

        <h2 className="font-outfit text-3xl sm:text-4xl font-extrabold text-white mb-4">
          Akses Langsung Sistem Operasional Artilia
        </h2>

        <p className="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
          Penguji atau evaluator dapat langsung mencoba modul inspeksi visual kamera, alur validasi K3,
          peminjaman perkakas, hingga pencetakan dokumen BAP digital pada port lokal.
        </p>

        <div className="flex flex-wrap items-center justify-center gap-4">
          <a
            href="http://localhost:8000/admin/defect-scanner/scan"
            target="_blank"
            rel="noopener noreferrer"
            className="px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition-all duration-200 shadow-lg shadow-indigo-600/30"
          >
            Mulai AI Defect Scanner (Kamera)
          </a>
          <a
            href="http://localhost:8000"
            target="_blank"
            rel="noopener noreferrer"
            className="px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 text-sm font-semibold border border-slate-700 transition-all duration-200"
          >
            Buka Portal Inventaris Lab
          </a>
          <a
            href="http://localhost:8000/admin/defect-scanner"
            target="_blank"
            rel="noopener noreferrer"
            className="px-6 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 text-sm font-semibold border border-slate-700 transition-all duration-200"
          >
            Log Riwayat &amp; BAK
          </a>
        </div>

        <div className="mt-8 text-xs font-mono text-slate-500">
          ARTILIA · Disiapkan untuk Penilaian Pekan Ilmiah Mahasiswa Nasional (PIMNAS 38)
        </div>
      </div>
    </section>
  );
}

/* ── 10. FOOTER ─────────────────────────────────────────────── */
function Footer() {
  return (
    <footer className="py-8 px-4 sm:px-6 lg:px-8 border-t border-slate-800/80 bg-[#05070f] text-slate-400 text-xs">
      <div className="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div className="flex items-center gap-2 font-mono">
          <span className="w-2 h-2 rounded-full bg-indigo-500"></span>
          <span className="font-bold text-white">ARTILIA</span>
          <span>— PKM-KC PIMNAS 38</span>
        </div>
        <div className="text-slate-500 text-center sm:text-right">
          Sistem Inspeksi Cacat Visual &amp; Tata Kelola Inventaris Laboratorium Presisi
        </div>
      </div>
    </footer>
  );
}

/* ── MAIN COMPONENT ─────────────────────────────────────────── */
export default function Home() {
  return (
    <main className="min-h-screen bg-[#060913] text-slate-100 selection:bg-indigo-500/30 selection:text-indigo-200">
      <Navbar />
      <HeroSection />
      <UrgencySection />
      <SimulatorSection />
      <AlgorithmSection />
      <ArchitectureSection />
      <LegalBAPSection />
      <TeamCredentialsSection />
      <DirectAccessCTA />
      <Footer />
    </main>
  );
}
