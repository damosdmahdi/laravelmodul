@extends('layouts.belajar')

@section('title', 'Materi Lanjutan: 7 Konsep Inti Arsitektur Laravel Modern - Belajar Laravel SMK')

@push('styles')
<style>
    /* ========================================================
       TEMA UTAMA & TYPOGRAPHY
       ======================================================== */
    .section-badge {
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 50rem;
    }
    .topic-nav-link {
        font-size: 0.85rem;
        color: #475569;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .topic-nav-link:hover, .topic-nav-link.active {
        background-color: #3b82f6;
        color: #ffffff !important;
        font-weight: 600;
    }

    /* ========================================================
       SIMULATOR CONTAINER & DISPLAY
       ======================================================== */
    .sim-card {
        background: #090d16;
        color: #e2e8f0;
        border-radius: 14px;
        border: 1px solid #1e293b;
        overflow: hidden;
        box-shadow: 0 12px 30px -5px rgba(0, 0, 0, 0.5);
    }
    .sim-header {
        background: #111827;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #1f2937;
    }
    .sim-body {
        padding: 22px;
    }

    /* ========================================================
       CODE VIEWER BERSIH
       ======================================================== */
    .code-viewer {
        background: #050811;
        border-radius: 10px;
        padding: 16px;
        font-family: 'Fira Code', Consolas, monospace;
        font-size: 0.85rem;
        line-height: 1.65;
        color: #cbd5e1;
        overflow-x: auto;
        border: 1px solid #1e293b;
    }
    .code-viewer .kw { color: #f43f5e; font-weight: 600; }
    .code-viewer .fn { color: #38bdf8; font-weight: 600; }
    .code-viewer .str { color: #4ade80; }
    .code-viewer .cm { color: #64748b; font-style: italic; }
    .code-viewer .cls { color: #fbbf24; font-weight: 600; }
    .code-viewer .var { color: #e2e8f0; }

    /* ========================================================
       DO'S & DON'TS
       ======================================================== */
    .card-dos {
        background: #f0fdf4;
        border-left: 5px solid #10b981;
        border-radius: 8px;
    }
    .card-donts {
        background: #fef2f2;
        border-left: 5px solid #ef4444;
        border-radius: 8px;
    }

    /* ========================================================
       ANIMASI MEKANIKAL KHUSUS (BUKAN SEKADAR KOTAK WARNA!)
       ======================================================== */
    /* 1. Database Table Scanner Pointer */
    .db-scan-pointer {
        position: absolute;
        left: 0;
        width: 100%;
        height: 38px;
        background: rgba(56, 189, 248, 0.25);
        border: 2px solid #38bdf8;
        border-radius: 6px;
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
        pointer-events: none;
        transition: top 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        display: none;
        z-index: 10;
    }
    .db-scan-pointer.match {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.3);
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
    }
    .db-scan-pointer.fail {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.3);
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
    }

    /* 2. Network Cable & Packets (N+1 Battle) */
    .network-stage {
        background: #020617;
        border: 1px solid #1e293b;
        border-radius: 12px;
        position: relative;
        padding: 20px;
        overflow: hidden;
    }
    .cable-line {
        height: 6px;
        background: #334155;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }
    .data-packet-orb {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        position: absolute;
        top: -4px;
        display: none;
        box-shadow: 0 0 10px currentColor;
    }
    @keyframes travelRight {
        0% { left: 0%; opacity: 0; }
        15% { opacity: 1; }
        85% { opacity: 1; }
        100% { left: 95%; opacity: 0; }
    }
    @keyframes travelLeft {
        0% { left: 95%; opacity: 0; }
        15% { opacity: 1; }
        85% { opacity: 1; }
        100% { left: 0%; opacity: 0; }
    }

    /* 3. Symlink Bridge Visualizer */
    .storage-partition {
        background: #0f172a;
        border: 2px dashed #334155;
        border-radius: 10px;
        padding: 14px;
        position: relative;
    }
    .symlink-arrow {
        position: relative;
        font-weight: 700;
        color: #38bdf8;
    }

    /* 4. Transaction Staging & Rollback Sweeper */
    .tx-staging-box {
        background: #030712;
        border: 2px solid #374151;
        border-radius: 10px;
        padding: 12px;
        position: relative;
        overflow: hidden;
    }
    .tx-row-item {
        background: #111827;
        border: 1px solid #1f2937;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 6px;
        transition: all 0.3s ease;
    }
    .tx-row-item.staged {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
    }
    .tx-row-item.committed {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.15);
    }
    .tx-row-item.rolled-back {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.15);
        text-decoration: line-through;
        opacity: 0.5;
        transform: translateX(-10px);
    }

    /* 5. Onion Rings for Middleware */
    .onion-wrapper {
        position: relative;
        width: 280px;
        height: 280px;
        margin: 0 auto;
    }
    .onion-ring {
        position: absolute;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 6px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .onion-ring-3 {
        width: 270px;
        height: 270px;
        border: 2px solid #3b82f6;
        background: rgba(59, 130, 246, 0.08);
        color: #93c5fd;
    }
    .onion-ring-2 {
        width: 195px;
        height: 195px;
        border: 2px solid #8b5cf6;
        background: rgba(139, 92, 246, 0.12);
        color: #c4b5fd;
    }
    .onion-ring-1 {
        width: 120px;
        height: 120px;
        border: 2px solid #f59e0b;
        background: rgba(245, 158, 11, 0.15);
        color: #fde68a;
    }
    .onion-core {
        position: absolute;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #10b981;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.68rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);
    }
    .request-bullet {
        position: absolute;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #38bdf8;
        box-shadow: 0 0 12px #38bdf8;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 20;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- HERO HEADER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border-left: 6px solid #6366f1;">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge text-white fw-bold px-3 py-1" style="background-color: #6366f1;">
                            <i class="bi bi-stars me-1"></i>MATERI LANJUTAN &bull; LEVEL MENENGAH - MAHIR
                        </span>
                        <span class="badge bg-secondary">Standar Industri &amp; Produksi</span>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">
                        7 Konsep Inti Arsitektur Laravel Modern
                    </h2>
                    <p class="text-light text-opacity-80 mb-3 fs-6">
                        Pelajaran komprehensif tentang bagaimana framework Laravel bekerja secara mekanis di balik layar. Disertai <strong>analogi nyata</strong>, <strong>bedah implementasi kode</strong>, <strong>Do's &amp; Don'ts</strong>, serta <strong>simulator interaktif visual</strong> untuk memudahkan guru menjelaskan dan siswa memahami alur data yang sebenarnya.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#topik-1" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-link-45deg text-primary me-1"></i>1. SEO Slugs &amp; Binding</a>
                        <a href="#topik-2" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-lightning-charge text-warning me-1"></i>2. N+1 &amp; Eager Loading</a>
                        <a href="#topik-3" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-hdd-network text-info me-1"></i>3. Storage &amp; Symlink</a>
                        <a href="#topik-4" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-arrow-repeat text-success me-1"></i>4. DB Transactions</a>
                        <a href="#topik-5" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-magic text-danger me-1"></i>5. Accessors/Mutators</a>
                        <a href="#topik-6" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-eye text-purple me-1" style="color:#c084fc;"></i>6. Observers &amp; Events</a>
                        <a href="#topik-7" class="badge bg-dark border border-secondary text-light px-3 py-2 text-decoration-none"><i class="bi bi-shield-lock text-emerald me-1" style="color:#34d399;"></i>7. Middleware Pipeline</a>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="bg-dark bg-opacity-60 p-3 rounded-3 border border-secondary border-opacity-25 text-start">
                        <h6 class="fw-bold text-warning mb-2"><i class="bi bi-mortarboard-fill me-1"></i>Pedoman Bagi Guru &amp; Siswa:</h6>
                        <p class="small text-light opacity-75 mb-3">
                            Materi ini tidak berfokus pada ujian atau tes skor, melainkan memberikan pemahaman mendalam tentang **arsitektur framework** yang sesungguhnya digunakan oleh developer senior di industri software.
                        </p>
                        <a href="#topik-1" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="bi bi-arrow-down-circle me-1"></i> Mulai Pembahasan Topik 1
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK JUMP NAVBAR (STICKY) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 sticky-top bg-white py-2" style="top: 65px; z-index: 1020;">
        <div class="card-body py-1 px-3">
            <div class="d-flex align-items-center gap-1 overflow-auto py-1">
                <span class="small fw-bold text-muted me-2 text-nowrap"><i class="bi bi-compass me-1"></i>Navigasi Materi:</span>
                <a href="#topik-1" class="topic-nav-link text-nowrap"><i class="bi bi-1-circle text-primary"></i>1. Slug &amp; Binding</a>
                <a href="#topik-2" class="topic-nav-link text-nowrap"><i class="bi bi-2-circle text-warning"></i>2. N+1 &amp; Eager Loading</a>
                <a href="#topik-3" class="topic-nav-link text-nowrap"><i class="bi bi-3-circle text-info"></i>3. Storage &amp; Symlink</a>
                <a href="#topik-4" class="topic-nav-link text-nowrap"><i class="bi bi-4-circle text-success"></i>4. DB Transactions</a>
                <a href="#topik-5" class="topic-nav-link text-nowrap"><i class="bi bi-5-circle text-danger"></i>5. Accessor &amp; Mutator</a>
                <a href="#topik-6" class="topic-nav-link text-nowrap"><i class="bi bi-6-circle text-primary"></i>6. Observers &amp; Events</a>
                <a href="#topik-7" class="topic-nav-link text-nowrap"><i class="bi bi-7-circle text-secondary"></i>7. Middleware Pipeline</a>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- TOPIK 1: ROUTE MODEL BINDING & SLUGS (URL BERSIH SEO)    -->
    <!-- ========================================================= -->
    <section id="topik-1" class="mb-5 pt-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-primary section-badge">Topik 1 dari 7</span>
            <h3 class="fw-bold mb-0">Route Model Binding &amp; Custom Key (Slug vs ID)</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="bi bi-compass-fill me-2"></i>Bedah Konsep: URL Bersih, Aman, dan Ramah SEO
                    </h5>
                    <p class="text-secondary small mb-3">
                        Di aplikasi tingkat pemula, rute biasanya mengekspos ID mentah dari primary key database: <code class="text-danger">/produk/45</code> atau <code class="text-danger">/umkm/3</code>. Di aplikasi profesional skala industri, URL wajib berbentuk <strong>Slug</strong>: <code class="text-success">/umkm/kue-enak-bu-sri</code>.
                    </p>

                    <h6 class="fw-bold text-dark mb-2">Mengapa Hal Ini Sangat Krusial di Industri?</h6>
                    <ul class="small text-secondary ps-3 mb-3">
                        <li class="mb-2"><strong>1. SEO (Search Engine Optimization):</strong> Robot perayap Google mengindeks kata kunci langsung dari struktur URL. Kata <em>"kue-enak-bu-sri"</em> bernilai jauh lebih tinggi bagi algoritma pencarian dibanding angka <code>45</code>.</li>
                        <li class="mb-2"><strong>2. Pencegahan Serangan IDOR (Insecure Direct Object References):</strong> Jika URL menggunakan angka urut <code>/invoice/1001</code>, penyerang dapat membuat bot untuk mengikis (*scraping*) <code>/invoice/1002</code>, <code>/invoice/1003</code> dst. Slug berbasis teks unik mencegah tebakan berurutan semacam ini.</li>
                        <li class="mb-2"><strong>3. Integritas Tautan (Shareability):</strong> Saat tautan dibagikan ke WhatsApp atau media sosial, penerima langsung mengetahui identitas toko tanpa perlu membuka halamannya terlebih dahulu.</li>
                    </ul>

                    <h6 class="fw-bold text-dark mt-3 mb-2"><i class="bi bi-code-slash me-1 text-primary"></i>Implementasi di Laravel (Implicit vs Scoped Binding):</h6>
                    <div class="code-viewer mb-3">
                        <span class="cm">// 1. Sintaks Rute dengan Custom Key (routes/web.php)</span><br>
                        Route::<span class="fn">get</span>(<span class="str">'/umkm/{portfolio:slug}'</span>, [PortfolioController::<span class="kw">class</span>, <span class="str">'show'</span>]);<br><br>
                        <span class="cm">// 2. Controller Otomatis Menerima Object Hasil Query (Type Hinting)</span><br>
                        <span class="kw">public function</span> <span class="fn">show</span>(<span class="cls">Portfolio</span> $portfolio)<br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Laravel otomatis menjalankan:</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// SELECT * FROM `portfolios` WHERE `slug` = ? AND `deleted_at` IS NULL LIMIT 1</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Jika data TIDAK ADA -> otomatis lempar ModelNotFoundException (HTTP 404)!</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">view</span>(<span class="str">'umkm.show'</span>, <span class="fn">compact</span>(<span class="str">'portfolio'</span>));<br>
                        }<br><br>
                        <span class="cm">// 3. Scoped Binding (Relasi Otomatis Bersarang)</span><br>
                        <span class="cm">// Memastikan produk действительно milik portfolio tersebut!</span><br>
                        Route::<span class="fn">get</span>(<span class="str">'/umkm/{portfolio:slug}/produk/{product:id}'</span>, ...);
                    </div>

                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i> <strong>Tips Otomasi Slug:</strong> Gunakan event <code>creating</code> pada model atau helper <code>Str::slug($namaUsaha)</code> untuk memastikan spasi dan tanda baca otomatis diubah menjadi karakter URL yang valid.
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 1: SCANNER DATABASE BERANIMASI -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-info"><i class="bi bi-hdd-network-fill me-1"></i>Simulator 1: URL Router &amp; Database Row Scanner</span>
                        <span class="badge bg-primary">Interactive Engine</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-2">
                            Ketikkan slug atau pilih tombol preset di bawah untuk melihat bagaimana pointer scanner SQL Laravel memindai baris database satu demi satu:
                        </p>

                        <!-- URL Address Bar Simulator -->
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text bg-dark text-info border-secondary font-monospace" style="font-size:0.75rem;">https://domain.id/umkm/</span>
                            <input type="text" id="simSlugInput" class="form-control bg-dark text-white border-secondary font-monospace" value="kue-enak-bu-sri">
                            <button class="btn btn-primary fw-bold px-3" type="button" onclick="runPhysicalSlugScanner()">
                                <i class="bi bi-search me-1"></i> Scan DB
                            </button>
                        </div>

                        <!-- Presets -->
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <span class="small text-muted me-1 align-self-center">Coba Preset:</span>
                            <button class="btn btn-xs btn-outline-info py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('kopi-kita')">kopi-kita (Row 1)</button>
                            <button class="btn btn-xs btn-outline-success py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('kue-enak-bu-sri')">kue-enak-bu-sri (Row 2)</button>
                            <button class="btn btn-xs btn-outline-warning py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('batik-indah')">batik-indah (Row 3)</button>
                            <button class="btn btn-xs btn-outline-danger py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('warung-fiktif-404')">warung-fiktif-404 (Tidak Ada)</button>
                        </div>

                        <!-- Visual DB Table with Scanner Pointer -->
                        <div class="mb-3 position-relative bg-black p-2 rounded-3 border border-secondary">
                            <div class="small fw-bold text-muted mb-2 font-monospace" style="font-size:0.72rem;">
                                <i class="bi bi-table text-warning me-1"></i>TABEL: `portfolios` (DI DALAM DATABASE SQLITE/MYSQL)
                            </div>

                            <!-- Pointer Laser Beam -->
                            <div id="dbScannerBeam" class="db-scan-pointer" style="top: 32px;"></div>

                            <table class="table table-dark table-sm table-borderless mb-0 font-monospace small" style="font-size:0.75rem;">
                                <thead>
                                    <tr class="text-secondary border-bottom border-secondary">
                                        <th style="width: 15%;">ID</th>
                                        <th style="width: 45%;">SLUG (Indexed Unique)</th>
                                        <th style="width: 40%;">NAMA USAHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="dbRow1" style="height: 38px;">
                                        <td>1</td>
                                        <td class="text-info">kopi-kita</td>
                                        <td>Kopi Kita Nusantara</td>
                                    </tr>
                                    <tr id="dbRow2" style="height: 38px;">
                                        <td>2</td>
                                        <td class="text-info">kue-enak-bu-sri</td>
                                        <td>Kue Enak Bu Sri</td>
                                    </tr>
                                    <tr id="dbRow3" style="height: 38px;">
                                        <td>3</td>
                                        <td class="text-info">batik-indah</td>
                                        <td>Batik Indah Tradisional</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Result Live Terminal -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 100px;" id="simSlugScannerLog">
                            <span class="text-muted">// Klik tombol "Scan DB" untuk melihat jalannya pemindaian laser SQL...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DO'S & DON'TS TOPIK 1 -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card-dos p-3">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-check-circle-fill me-2"></i>Do's (Praktik Terbaik Industri)</h6>
                    <ul class="small text-dark mb-0 ps-3">
                        <li>Tambahkan index unik pada kolom slug di migration: <code>$table-&gt;string('slug')-&gt;unique();</code> agar pemindaian database berlangsung instan O(1) B-Tree index.</li>
                        <li>Gunakan Type-Hinting Model: <code>public function show(Portfolio $portfolio)</code> agar kode rapi dan terhindar dari boilerplate <code>abort(404)</code> manual.</li>
                        <li>Tangani custom 404 dengan menyediakan view <code>resources/views/errors/404.blade.php</code>.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-donts p-3">
                    <h6 class="fw-bold text-danger mb-2"><i class="bi bi-x-circle-fill me-2"></i>Don'ts (Kesalahan Fatal Pemula)</h6>
                    <ul class="small text-dark mb-0 ps-3">
                        <li><strong>JANGAN</strong> menulis query manual berulang: <code>$p = Portfolio::where('slug', $slug)-&gt;first(); if(!$p) { abort(404); }</code> di setiap method controller!</li>
                        <li><strong>JANGAN</strong> membiarkan pengguna menginput slug secara manual tanpa sanitasi (cegah spasi, karakter khusus non-alphanumeric, dan huruf kapital).</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 2: RELASI ELOQUENT & MASALAH N+1 QUERY             -->
    <!-- ========================================================= -->
    <section id="topik-2" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-warning text-dark section-badge">Topik 2 dari 7</span>
            <h3 class="fw-bold mb-0">Relasi Eloquent &amp; Pencegahan Bahaya "N+1 Query Problem"</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-warning mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Mekanisme Masalah N+1: Mengapa Server DB Bisa Tumbang?
                    </h5>
                    <p class="text-secondary small mb-3">
                        Bayangkan sebuah sistem menampilkan daftar <strong>50 UMKM</strong>, dan di setiap card UMKM ingin ditampilkan daftar produk atau jumlah produknya.
                    </p>

                    <div class="alert alert-danger py-2 small mb-3">
                        <strong>KASUS 1: LAZY LOADING (N+1 Query - Anti-Pattern):</strong><br>
                        <code>$umkms = Portfolio::all();</code> &rarr; <strong>Query #1:</strong> <code>SELECT * FROM portfolios;</code> (mengambil 50 baris).<br>
                        Lalu di dalam file Blade Anda melakukan:<br>
                        <code>&#64;foreach($umkms as $u) @{{ $u->products->count() }} &#64;endforeach</code><br>
                        Setiap kali perulangan berjalan, Laravel mengirimkan request query baru lewat jaringan ke database!<br>
                        Total Query: <strong>1 + 50 = 51 Kali Query Bolak-Balik Jaringan!</strong> Jika ada 1.000 data, server database mengalami lonjakan CPU hingga 100% dan *crash*.
                    </div>

                    <div class="alert alert-success py-2 small mb-3">
                        <strong>KASUS 2: EAGER LOADING (Solusi Terbaik):</strong><br>
                        Gunakan metode <code>with()</code> di Controller:<br>
                        <code>$umkms = Portfolio::with('products')-&gt;get();</code><br>
                        Laravel hanya mengirimkan <strong>2 QUERY SAJA</strong>:<br>
                        1. <code>SELECT * FROM portfolios;</code><br>
                        2. <code>SELECT * FROM portfolio_products WHERE portfolio_id IN (1, 2, ..., 50);</code><br>
                        Semua data produk di-hydrate langsung ke dalam RAM server PHP. Di Blade, data dibaca dari memori lokal (0 query tambahan!).
                    </div>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-tools me-1 text-warning"></i>Tips Optimasi Lanjutan di Laravel:</h6>
                    <div class="code-viewer">
                        <span class="cm">// 1. Eager Loading Kolom Tertentu Saja (Hemat RAM):</span><br>
                        $umkms = <span class="cls">Portfolio</span>::<span class="fn">with</span>(<span class="str">'products:id,portfolio_id,nama_produk,harga'</span>)-&gt;<span class="fn">get</span>();<br><br>
                        <span class="cm">// 2. Menghitung Jumlah Relasi Tanpa Mengambil Datanya (Super Cepat):</span><br>
                        $umkms = <span class="cls">Portfolio</span>::<span class="fn">withCount</span>(<span class="str">'products'</span>)-&gt;<span class="fn">get</span>();<br>
                        <span class="cm">// Menghasilkan kolom virtual: $u->products_count</span><br><br>
                        <span class="cm">// 3. Deteksi Otomatis Saat Coding (AppServiceProvider.php):</span><br>
                        <span class="cls">Model</span>::<span class="fn">preventLazyLoading</span>(!<span class="fn">app</span>()-&gt;<span class="fn">isProduction</span>());
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 2: VISUALISASI JARINGAN PAKET N+1 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-warning"><i class="bi bi-cpu-fill me-1"></i>Simulator 2: Visualisasi Alur Paket Data (PHP vs Database Daemon)</span>
                        <span class="badge bg-warning text-dark">Network Traffic Monitor</span>
                    </div>
                    <div class="sim-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small text-light">Simulasikan Jumlah Data Toko:</span>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-light active" id="btnRows10" onclick="setNRows(10)">10 Data</button>
                                <button type="button" class="btn btn-outline-light" id="btnRows25" onclick="setNRows(25)">25 Data</button>
                                <button type="button" class="btn btn-outline-light" id="btnRows50" onclick="setNRows(50)">50 Data</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="startPacketSimulation('lazy')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Jalankan Lazy Loading (N+1)
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success w-100 py-2 small fw-bold" onclick="startPacketSimulation('eager')">
                                    <i class="bi bi-lightning-charge me-1"></i> Jalankan Eager Loading (with)
                                </button>
                            </div>
                        </div>

                        <!-- Mechanical Network Diagram -->
                        <div class="network-stage mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="text-center" style="width: 100px;">
                                    <i class="bi bi-hdd-rack fs-3 text-primary d-block"></i>
                                    <span class="badge bg-primary text-white" style="font-size:0.65rem;">PHP-FPM Worker</span>
                                </div>
                                <div class="flex-grow-1 px-3">
                                    <div class="d-flex justify-content-between text-muted" style="font-size:0.68rem;">
                                        <span>Socket TCP / Cable</span>
                                        <span id="packetCounterLabel">0 Request / 0 Response</span>
                                    </div>
                                    <div class="cable-line my-1">
                                        <div id="orbReq" class="data-packet-orb bg-danger text-danger"></div>
                                        <div id="orbRes" class="data-packet-orb bg-info text-info"></div>
                                    </div>
                                    <div class="text-center" style="font-size:0.65rem; color:#64748b;" id="packetStatusText">
                                        Status Kabel: Idle (Menunggu Eksekusi)
                                    </div>
                                </div>
                                <div class="text-center" style="width: 100px;">
                                    <i class="bi bi-database fs-3 text-warning d-block" id="dbServerIcon"></i>
                                    <span class="badge bg-warning text-dark" style="font-size:0.65rem;" id="dbServerBadge">Database Daemon</span>
                                </div>
                            </div>

                            <!-- Live Thermometer & Meter -->
                            <div class="bg-dark p-2 rounded-2 border border-secondary mt-2">
                                <div class="row align-items-center g-2 text-center" style="font-size:0.75rem;">
                                    <div class="col-4">
                                        <span class="text-muted d-block" style="font-size:0.68rem;">Total Query:</span>
                                        <strong class="text-white fs-6" id="metricQueryCount">0</strong>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-muted d-block" style="font-size:0.68rem;">Beban CPU DB:</span>
                                        <strong class="text-success" id="metricCpuLoad">5% (Dingin)</strong>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-muted d-block" style="font-size:0.68rem;">Waktu Eksekusi:</span>
                                        <strong class="text-white" id="metricLatency">0 ms</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Live SQL Log Output -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.75rem; max-height: 120px; overflow-y: auto;" id="simN1Logs">
                            <span class="text-muted">// Klik tombol untuk melihat paket query yang ditembakkan secara real-time...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 3: FILE STORAGE & SYMLINK PIPELINE                 -->
    <!-- ========================================================= -->
    <section id="topik-3" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-info text-dark section-badge">Topik 3 dari 7</span>
            <h3 class="fw-bold mb-0">File Storage, Validasi Upload &amp; Arsitektur Symlink</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-info mb-3">
                        <i class="bi bi-hdd-network-fill me-2"></i>Arsitektur Storage: Memisahkan File Publik dan Logika Sistem
                    </h5>
                    <p class="text-secondary small mb-3">
                        Mengapa Laravel melarang developer meletakkan file upload pengguna langsung ke dalam folder <code>public/uploads/</code>?
                    </p>
                    <ul class="small text-secondary ps-3 mb-3">
                        <li class="mb-2"><strong>1. Bahaya Remote Code Execution (RCE):</strong> Jika pengguna mengunggah file bernama <code>script.php</code> dan diletakkan di folder publik, siapa pun di internet bisa membuka <code>http://domain.com/uploads/script.php</code> dan server akan mengeksekusi script tersebut!</li>
                        <li class="mb-2"><strong>2. Kebersihan Git Repository:</strong> Folder <code>public</code> berisi aset inti aplikasi (CSS, JS, ikon) yang dilacak git. File upload dinamis harus dipisahkan di <code>storage/app/public/</code> yang sudah terdaftar di <code>.gitignore</code>.</li>
                        <li class="mb-2"><strong>3. Fleksibilitas Cloud Storage:</strong> Dengan menggunakan abstraksi <code>Storage::disk('public')</code>, aplikasi dapat berpindah dari harddisk lokal ke Amazon S3 atau Google Cloud Storage kapan saja hanya dengan mengganti 1 baris konfigurasi di <code>.env</code>!</li>
                    </ul>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-link-45deg text-info me-1"></i>Mekanisme Symbolic Link (`php artisan storage:link`):</h6>
                    <p class="small text-secondary mb-2">
                        Perintah Artisan membuat tautan pintasan virtual (*Inode Pointer*) di sistem operasi:
                    </p>
                    <div class="code-viewer mb-3">
                        <span class="cm">// Di Terminal:</span><br>
                        $ php artisan storage:link<br>
                        <span class="cm">// Hasil: public/storage &rarr; storage/app/public</span><br><br>
                        <span class="cm">// Di Controller (Menyimpan File Aman dengan Nama Acak Hash):</span><br>
                        $request-&gt;<span class="fn">validate</span>([<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'banner'</span> =&gt; <span class="str">'required|image|mimes:jpeg,png,webp|max:2048'</span>,<br>
                        ]);<br>
                        $path = $request-&gt;<span class="fn">file</span>(<span class="str">'banner'</span>)-&gt;<span class="fn">store</span>(<span class="str">'banners'</span>, <span class="str">'public'</span>);<br>
                        <span class="cm">// Menghasilkan: "banners/Hj82kLmZ991.jpg"</span><br><br>
                        <span class="cm">// Di Tampilan Blade:</span><br>
                        &lt;img src="@{{ asset('storage/' . $portfolio->banner) }}" alt="Banner"&gt;
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 3: VISUALISASI INODE SYMLINK -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-info"><i class="bi bi-diagram-2-fill me-1"></i>Simulator 3: Penampang Partisi Server &amp; Jembatan Symlink</span>
                        <span class="badge bg-info text-dark">Filesystem Inspector</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Pilih sampel payload file untuk melihat bagaimana Nginx dan Laravel memproses file secara bertahap:
                        </p>

                        <!-- File Selection -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="choiceJpg" onclick="selectSampleFile('banner.jpg', 'image/jpeg', 720)">
                                    <i class="bi bi-file-earmark-image fs-4 text-success d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">banner.jpg</span>
                                    <span class="badge bg-secondary" style="font-size:0.62rem;">720 KB (Valid)</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="choicePhp" onclick="selectSampleFile('shell.php', 'application/x-php', 8)">
                                    <i class="bi bi-file-earmark-code fs-4 text-danger d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">shell.php</span>
                                    <span class="badge bg-danger" style="font-size:0.62rem;">Exploit File</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="choiceOversize" onclick="selectSampleFile('video_banner.png', 'image/png', 5800)">
                                    <i class="bi bi-file-earmark-image fs-4 text-warning d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">oversize.png</span>
                                    <span class="badge bg-warning text-dark" style="font-size:0.62rem;">5.8 MB (> 2MB)</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-info text-dark fw-bold w-100 mb-3" onclick="runSymlinkPipelineAnimation()">
                            <i class="bi bi-play-circle-fill me-1"></i> Eksekusi Upload ke Server
                        </button>

                        <!-- Partition Layout Cross Section -->
                        <div class="row g-2 mb-3">
                            <div class="col-5">
                                <div class="storage-partition text-center" id="partStorage">
                                    <span class="badge bg-secondary mb-1" style="font-size:0.65rem;">Folder Privat Terkunci</span>
                                    <div class="small fw-bold text-white mb-1" style="font-size:0.75rem;">storage/app/public/</div>
                                    <div class="p-2 bg-dark rounded border border-secondary text-truncate" style="font-size:0.68rem;" id="storageFileBox">
                                        <i class="bi bi-file-lock text-muted me-1"></i>(Kosong)
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 d-flex flex-column align-items-center justify-content-center text-center">
                                <div class="symlink-arrow small fw-bold" style="font-size:0.68rem;">Symlink</div>
                                <i class="bi bi-arrow-left-right text-info fs-5" id="symlinkIcon"></i>
                                <span class="badge bg-secondary" style="font-size:0.58rem;" id="symlinkBadge">Inactive</span>
                            </div>
                            <div class="col-5">
                                <div class="storage-partition text-center" id="partPublic">
                                    <span class="badge bg-success mb-1" style="font-size:0.65rem;">Folder Publik Internet</span>
                                    <div class="small fw-bold text-white mb-1" style="font-size:0.75rem;">public/storage/</div>
                                    <div class="p-2 bg-dark rounded border border-secondary text-truncate" style="font-size:0.68rem;" id="publicFileBox">
                                        <i class="bi bi-globe text-muted me-1"></i>(Belum terhubung)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Console Readout -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.75rem; min-height: 95px;" id="simSymlinkConsole">
                            <span class="text-muted">// Pilih file di atas dan klik "Eksekusi Upload ke Server"...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 4: DATABASE TRANSACTIONS (KONSISTENSI DATA)         -->
    <!-- ========================================================= -->
    <section id="topik-4" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-success section-badge">Topik 4 dari 7</span>
            <h3 class="fw-bold mb-0">Database Transactions (`DB::transaction`) - Integritas Data</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-success mb-3">
                        <i class="bi bi-shield-shaded me-2"></i>Prinsip ACID: All or Nothing (Semua Berhasil atau Batalkan Semua)
                    </h5>
                    <p class="text-secondary small mb-3">
                        Dalam pembuatan sistem nyata seperti Portofolio UMKM, sebuah proses bisnis hampir selalu melibatkan <strong>multi-table write</strong>:
                    </p>
                    <ol class="small text-secondary ps-3 mb-3">
                        <li class="mb-1">Tulis data profil toko ke tabel <code>portfolios</code>.</li>
                        <li class="mb-1">Tulis 4 data produk unggulan ke tabel <code>portfolio_products</code>.</li>
                        <li class="mb-1">Tulis catatan histori audit ke tabel <code>activity_logs</code>.</li>
                    </ol>

                    <div class="alert alert-warning py-2 small mb-3">
                        <strong>APA YANG TERJADI JIKA TANPA TRANSACTION?</strong><br>
                        Jika langkah 1 sukses, tetapi pada langkah 2 terjadi error validasi harga atau disk penuh, sistem terhenti. Hasilnya: toko tersimpan tapi produknya kosong dan data menggantung (*dirty/corrupt data*).
                    </div>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-code-slash text-success me-1"></i>Sintaks `DB::transaction` di Laravel:</h6>
                    <div class="code-viewer mb-3">
                        <span class="kw">use</span> Illuminate\Support\Facades\<span class="cls">DB</span>;<br><br>
                        <span class="cls">DB</span>::<span class="fn">transaction</span>(<span class="kw">function</span> () <span class="kw">use</span> ($request) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 1. Simpan Data Induk</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$portfolio = <span class="cls">Portfolio</span>::<span class="fn">create</span>([...]);<br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 2. Simpan Data Anak (Produk)</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$portfolio-&gt;<span class="fn">products</span>()-&gt;<span class="fn">createMany</span>([...]);<br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 3. Catat Log Audit</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([...]);<br>
                        });<br>
                        <span class="cm">// Jika ada satu Exception &rarr; ROLLBACK OTOMATIS (Batal Total)!</span><br>
                        <span class="cm">// Jika seluruhnya sukses &rarr; COMMIT (Permanen)!</span>
                    </div>

                    <p class="small text-secondary mb-0">
                        <strong>Penanganan Deadlock:</strong> Laravel juga menyediakan parameter percobaan ulang otomatis: <code>DB::transaction(fn() => ..., 5);</code> yang akan mencoba kembali hingga 5 kali jika terjadi *deadlock* antrian database.
                    </p>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 4: BUFFER MEMORY ROLLBACK -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-success"><i class="bi bi-arrow-repeat me-1"></i>Simulator 4: Transaction Staging Sandbox (Commit vs Rollback)</span>
                        <span class="badge bg-success">ACID Sandbox</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Pilih skenario eksekusi untuk melihat bagaimana baris data ditahan di buffer memori (*Undo Log*) sebelum diresmikan atau dihapus:
                        </p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-success w-100 py-2 small fw-bold" onclick="runMechanicalTxSimulation(true)">
                                    <i class="bi bi-check2-circle me-1"></i> Skenario A: Sukses Semua
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="runMechanicalTxSimulation(false)">
                                    <i class="bi bi-x-octagon me-1"></i> Skenario B: Gagal di Langkah 2
                                </button>
                            </div>
                        </div>

                        <!-- Staging Box -->
                        <div class="tx-staging-box mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-bold text-muted font-monospace" style="font-size:0.72rem;">
                                    <i class="bi bi-memory text-warning me-1"></i>TRANSACTION STAGING BUFFER (RAM MEMORY)
                                </span>
                                <span class="badge bg-secondary font-monospace" style="font-size:0.65rem;" id="txStateBadge">IDLE</span>
                            </div>

                            <div class="tx-row-item" id="txRow1">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-white fw-bold">1. INSERT INTO `portfolios`</span>
                                    <span class="badge bg-secondary" id="badgeRow1">Waiting</span>
                                </div>
                                <span class="text-muted d-block" style="font-size:0.68rem;">Data: Toko Roti Manis (ID: 104)</span>
                            </div>

                            <div class="tx-row-item" id="txRow2">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-white fw-bold">2. INSERT INTO `portfolio_products`</span>
                                    <span class="badge bg-secondary" id="badgeRow2">Waiting</span>
                                </div>
                                <span class="text-muted d-block" style="font-size:0.68rem;">Data: 4 Produk Roti Cokelat &amp; Keju</span>
                            </div>

                            <div class="tx-row-item" id="txRow3">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-white fw-bold">3. INSERT INTO `activity_logs`</span>
                                    <span class="badge bg-secondary" id="badgeRow3">Waiting</span>
                                </div>
                                <span class="text-muted d-block" style="font-size:0.68rem;">Data: Rekam Jejak Admin Input Baru</span>
                            </div>
                        </div>

                        <!-- Terminal Output -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.75rem; min-height: 95px;" id="simTxConsole">
                            <span class="text-muted">// Klik tombol Skenario A atau B di atas untuk melihat proses atomik...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 5: ELOQUENT ACCESSORS, MUTATORS & CASTING          -->
    <!-- ========================================================= -->
    <section id="topik-5" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-danger section-badge">Topik 5 dari 7</span>
            <h3 class="fw-bold mb-0">Eloquent Accessors, Mutators &amp; Attribute Casting</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-danger mb-3">
                        <i class="bi bi-magic me-2"></i>Clean Architecture: Model yang Bertanggung Jawab Atas Format Data
                    </h5>
                    <p class="text-secondary small mb-3">
                        Seringkali pemula mengotori file view Blade dengan string concatenation yang rumit hanya untuk memformat nomor telepon atau angka rupiah:
                        <br><code class="text-danger">&lt;a href="https://wa.me/@{{ '62' . substr($u->wa, 1) }}?text=Halo"&gt;Hubungi&lt;/a&gt;</code>
                    </p>
                    <p class="text-secondary small mb-3">
                        Praktik ini melanggar prinsip *Separation of Concerns*. View hanya bertugas merender HTML, bukan memanipulasi string bisnis! Letakkan logika tersebut di dalam **Model**:
                    </p>

                    <h6 class="fw-bold text-dark mb-2">1. Accessor (Mengubah Nilai Saat Dibaca):</h6>
                    <div class="code-viewer mb-3">
                        <span class="cm">// app/Models/Portfolio.php (Sintaks Laravel Modern)</span><br>
                        <span class="kw">use</span> Illuminate\Database\Eloquent\Casts\<span class="cls">Attribute</span>;<br><br>
                        <span class="kw">protected function</span> <span class="fn">whatsappUrl</span>(): <span class="cls">Attribute</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="cls">Attribute</span>::<span class="fn">make</span>(<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;get: <span class="kw">fn</span> () =&gt; <span class="str">'https://wa.me/'</span> . <span class="fn">preg_replace</span>(<span class="str">'/^0/'</span>, <span class="str">'62'</span>, $this-&gt;whatsapp)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;);<br>
                        }
                    </div>

                    <h6 class="fw-bold text-dark mb-2">2. Attribute Casting (Konversi Tipe Data Otomatis):</h6>
                    <div class="code-viewer">
                        <span class="cm">// Laravel 11/12 Menggunakan Method casts(): array</span><br>
                        <span class="kw">protected function</span> <span class="fn">casts</span>(): <span class="kw">array</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> [<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'is_verified'</span> =&gt; <span class="str">'boolean'</span>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'social_links'</span> =&gt; <span class="str">'array'</span>, <span class="cm">// JSON di DB otomatis jadi Array PHP!</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'published_at'</span> =&gt; <span class="str">'datetime'</span>, <span class="cm">// Otomatis jadi objek Carbon!</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;];<br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 5: DATA PIPELINE TRANSFORMER -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-danger"><i class="bi bi-input-cursor-text me-1"></i>Simulator 5: Live Accessor &amp; Cast Transformer</span>
                        <span class="badge bg-danger">Transformer Studio</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Ketikkan data mentah pada kolom input dan perhatikan bagaimana Accessor dan Caster mentransformasikan nilainya secara real-time:
                        </p>

                        <!-- Input 1: WA -->
                        <div class="mb-3">
                            <label class="small text-secondary fw-bold mb-1">1. Kolom Database `whatsapp` (String Mentah):</label>
                            <input type="text" id="simWaInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value="081234567890" oninput="updateModernTransformer()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.7rem;">Pemanggilan di Blade: <code>@{{ $portfolio->whatsapp_url }}</code></span>
                                <span class="text-success fw-bold text-break" id="simWaOutput">https://wa.me/6281234567890</span>
                            </div>
                        </div>

                        <!-- Input 2: Harga Angka -->
                        <div class="mb-3">
                            <label class="small text-secondary fw-bold mb-1">2. Kolom Database `harga` (Integer Mentah):</label>
                            <input type="number" id="simPriceInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value="45000" oninput="updateModernTransformer()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.7rem;">Pemanggilan di Blade: <code>@{{ $product->harga_rupiah }}</code></span>
                                <span class="text-warning fw-bold" id="simPriceOutput">Rp 45.000</span>
                            </div>
                        </div>

                        <!-- Input 3: JSON Caster -->
                        <div class="mb-2">
                            <label class="small text-secondary fw-bold mb-1">3. Kolom Database `social_links` (Teks JSON Mentah):</label>
                            <input type="text" id="simJsonInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value='{"ig":"@kue_sri","fb":"Kue Sri Official"}' oninput="updateModernTransformer()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.7rem;">Hasil Cast 'array': <code>$portfolio->social_links['ig']</code></span>
                                <span class="text-info fw-bold" id="simJsonOutput">@kue_sri (Tipe: Array PHP)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 6: MODEL OBSERVERS & LIFECYCLE EVENTS               -->
    <!-- ========================================================= -->
    <section id="topik-6" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-purple section-badge text-white" style="background-color: #8b5cf6;">Topik 6 dari 7</span>
            <h3 class="fw-bold mb-0">Model Observers &amp; Lifecycle Events (Audit Trail Otomatis)</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-3" style="color: #8b5cf6;">
                        <i class="bi bi-eye-fill me-2"></i>Mekanisme Lifecycle: Mendengarkan Event Tanpa Mengotori Controller
                    </h5>
                    <p class="text-secondary small mb-3">
                        Setiap kali Model Eloquent dibuat, diubah, atau dihapus, Laravel memancarkan serangkaian <strong>Lifecycle Events</strong> secara berurutan:
                    </p>
                    <div class="p-2 rounded bg-dark border border-secondary font-monospace small mb-3" style="font-size:0.75rem;">
                        <span class="text-info">retrieved</span> &rarr;
                        <span class="text-warning">creating</span> &rarr;
                        <span class="text-success">created</span> &rarr;
                        <span class="text-warning">updating</span> &rarr;
                        <span class="text-success">updated</span> &rarr;
                        <span class="text-danger">deleting</span> &rarr;
                        <span class="text-danger">deleted</span>
                    </div>

                    <h6 class="fw-bold text-dark mb-2">Keunggulan Menggunakan Observer:</h6>
                    <ul class="small text-secondary ps-3 mb-3">
                        <li class="mb-1"><strong>Decoupled Architecture:</strong> Controller hanya fokus menerima request dan merespons view. Pencatatan log, pengiriman email, atau invalidasi cache diserahkan ke Observer.</li>
                        <li class="mb-1"><strong>Dapat Membatalkan Aksi:</strong> Jika method <code>creating()</code> atau <code>deleting()</code> me-return <code>false</code>, Laravel secara otomatis membatalkan operasi SQL tersebut!</li>
                        <li class="mb-1"><strong>Menghindari Loop Tak Terhingga:</strong> Gunakan <code>$model->saveQuietly()</code> jika ingin menyimpan perubahan dari dalam Observer tanpa memicu event ulang.</li>
                    </ul>

                    <div class="code-viewer">
                        <span class="cm">// app/Observers/PortfolioObserver.php</span><br>
                        <span class="kw">class</span> <span class="cls">PortfolioObserver</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">created</span>(<span class="cls">Portfolio</span> $portfolio): <span class="kw">void</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'action'</span> =&gt; <span class="str">'CREATE'</span>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'details'</span> =&gt; <span class="str">"UMKM {$portfolio-&gt;nama_usaha} baru saja didaftarkan."</span>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 6: EVENT BUS PULSE DISPATCHER -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small" style="color:#c084fc;"><i class="bi bi-broadcast me-1"></i>Simulator 6: Event Bus &amp; Lifecycle Dispatcher</span>
                        <span class="badge" style="background:#8b5cf6;">Event Bus</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Pilih aksi model di bawah untuk melihat pulsa sinyal event mengalir dari memori PHP menuju Observer audit trail:
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <button class="btn btn-sm btn-outline-primary fw-bold" onclick="triggerEventPulse('create')">
                                <i class="bi bi-plus-circle me-1"></i> Portfolio::create()
                            </button>
                            <button class="btn btn-sm btn-outline-warning fw-bold" onclick="triggerEventPulse('update')">
                                <i class="bi bi-pencil-square me-1"></i> $portfolio->update()
                            </button>
                            <button class="btn btn-sm btn-outline-danger fw-bold" onclick="triggerEventPulse('delete')">
                                <i class="bi bi-trash3 me-1"></i> $portfolio->delete()
                            </button>
                        </div>

                        <!-- Lifecycle Bus Visual Track -->
                        <div class="p-3 bg-black rounded-3 border border-secondary mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="small fw-bold text-muted font-monospace" style="font-size:0.72rem;">
                                    <i class="bi bi-cpu text-info me-1"></i>ELOQUENT DISPATCHER BUS
                                </span>
                                <span class="badge bg-secondary font-monospace" style="font-size:0.65rem;" id="eventActiveState">IDLE</span>
                            </div>

                            <div class="row g-2 text-center font-monospace">
                                <div class="col-3">
                                    <div class="p-2 rounded bg-dark border border-secondary" id="busNode1">
                                        <span class="d-block text-muted" style="font-size:0.65rem;">STAGE 1</span>
                                        <strong class="text-white" style="font-size:0.75rem;" id="busLabel1">saving</strong>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-2 rounded bg-dark border border-secondary" id="busNode2">
                                        <span class="d-block text-muted" style="font-size:0.65rem;">STAGE 2</span>
                                        <strong class="text-warning" style="font-size:0.75rem;" id="busLabel2">creating</strong>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-2 rounded bg-dark border border-secondary" id="busNode3">
                                        <span class="d-block text-muted" style="font-size:0.65rem;">STAGE 3</span>
                                        <strong class="text-info" style="font-size:0.75rem;">SQL WRITE</strong>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-2 rounded bg-dark border border-secondary" id="busNode4">
                                        <span class="d-block text-muted" style="font-size:0.65rem;">STAGE 4</span>
                                        <strong class="text-success" style="font-size:0.75rem;" id="busLabel4">created</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observer Terminal Readout -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.75rem; min-height: 95px;" id="simObserverConsole">
                            <span class="text-muted">// Klik tombol aksi model di atas untuk melihat pulsa sinyal event...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 7: PIPELINE MIDDLEWARE & SESI OTENTIKASI           -->
    <!-- ========================================================= -->
    <section id="topik-7" class="mb-5 pt-2">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-secondary section-badge">Topik 7 dari 7</span>
            <h3 class="fw-bold mb-0">Pipeline Middleware &amp; Mekanisme Otentikasi Sesi</h3>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-secondary mb-3">
                        <i class="bi bi-layers-half me-2"></i>Arsitektur Lapis Bawang (The Onion Pattern)
                    </h5>
                    <p class="text-secondary small mb-3">
                        Setiap kali browser mengirimkan request HTTP, request tersebut tidak pernah langsung menyentuh Controller! Request harus menembus lapisan-lapisan <strong>Middleware</strong> terlebih dahulu:
                    </p>
                    <ol class="small text-secondary ps-3 mb-3">
                        <li class="mb-1"><strong>Lapisan 1 (Global Middleware):</strong> Memvalidasi ukuran request (anti flood), memotong spasi kosong (<code>TrimStrings</code>), dan memeriksa mode maintenance.</li>
                        <li class="mb-1"><strong>Lapisan 2 (Web Middleware Group):</strong> Mendekripsi cookie sesi, memvalidasi token <code>VerifyCsrfToken</code>, dan menyiapkan penyimpanan sesi.</li>
                        <li class="mb-1"><strong>Lapisan 3 (Custom Auth Guard):</strong> Mengevaluasi hak akses. Jika pengguna belum login, middleware memantulkan request kembali dengan redirect 302!</li>
                        <li class="mb-1"><strong>Inti Pusat (Controller):</strong> Hanya dipanggil jika request lolos menembus ketiga lapisan di atas!</li>
                    </ol>

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-code-slash text-secondary me-1"></i>Contoh Middleware Pintu Masuk Admin:</h6>
                    <div class="code-viewer">
                        <span class="kw">public function</span> <span class="fn">handle</span>(<span class="cls">Request</span> $request, <span class="cls">Closure</span> $next): <span class="cls">Response</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (!<span class="fn">session</span>()-&gt;<span class="fn">has</span>(<span class="str">'ukk_admin_id'</span>)) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">redirect</span>()-&gt;<span class="fn">route</span>(<span class="str">'ukk.admin.login'</span>)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">with</span>(<span class="str">'error'</span>, <span class="str">'Akses ditolak! Silakan login terlebih dahulu.'</span>);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> $next($request); <span class="cm">// Teruskan menembus ke controller!</span><br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 7: ONION RING PENETRATOR -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-secondary"><i class="bi bi-shield-shaded me-1"></i>Simulator 7: Penetrasi Lapisan Middleware (The Onion Ring)</span>
                        <span class="badge bg-secondary">Onion Inspector</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Uji tembakan request pengunjung menuju halaman terproteksi <code>/ukk/admin</code>:
                        </p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="shootMiddlewareRequest(false)">
                                    <i class="bi bi-person-x me-1"></i> Tanpa Sesi (Tamu Asing)
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-success w-100 py-2 small fw-bold" onclick="shootMiddlewareRequest(true)">
                                    <i class="bi bi-person-check me-1"></i> Dengan Sesi Admin Sah
                                </button>
                            </div>
                        </div>

                        <!-- Visual Concentric Onion Rings -->
                        <div class="onion-wrapper mb-3" id="onionContainer">
                            <div class="request-bullet" id="requestBullet"></div>

                            <div class="onion-ring onion-ring-3" id="ringGlobal">
                                <span>Lapis 1: Global Middleware</span>
                            </div>
                            <div class="onion-ring onion-ring-2" id="ringWeb">
                                <span>Lapis 2: Web Group &amp; CSRF</span>
                            </div>
                            <div class="onion-ring onion-ring-1" id="ringAuth">
                                <span>Lapis 3: Auth Guard</span>
                            </div>
                            <div class="onion-core" id="ringCore">
                                <span>CORE<br>CTRL</span>
                            </div>
                        </div>

                        <!-- Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.75rem; min-height: 95px;" id="simOnionConsole">
                            <span class="text-muted">// Klik salah satu tombol di atas untuk melihat proyektil request menembus lapisan...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
@verbatim
<script>
    /* ========================================================
       SIMULATOR 1: MECHANICAL DATABASE ROW SCANNER
       ======================================================== */
    const dbRows = {
        'kopi-kita': { rowId: 'dbRow1', topPx: 32, name: 'Kopi Kita Nusantara', id: 1 },
        'kue-enak-bu-sri': { rowId: 'dbRow2', topPx: 70, name: 'Kue Enak Bu Sri', id: 2 },
        'batik-indah': { rowId: 'dbRow3', topPx: 108, name: 'Batik Indah Tradisional', id: 3 }
    };

    function setSlugAndScan(slug) {
        document.getElementById('simSlugInput').value = slug;
        runPhysicalSlugScanner();
    }

    function runPhysicalSlugScanner() {
        const slug = document.getElementById('simSlugInput').value.trim().toLowerCase();
        const beam = document.getElementById('dbScannerBeam');
        const consoleEl = document.getElementById('simSlugScannerLog');

        beam.style.display = 'block';
        beam.className = 'db-scan-pointer';
        beam.style.top = '32px';

        consoleEl.innerHTML = '<span class="text-info">[ROUTER] Parsing URL /umkm/' + slug + ' &rarr; Menjalankan Route Model Binding...</span><br>';

        // Step 1: Scan Row 1
        setTimeout(() => {
            beam.style.top = '32px';
            consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #1] Cek slug="kopi-kita"... ' + (slug === 'kopi-kita' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

            if (slug === 'kopi-kita') {
                finishScan(true, dbRows['kopi-kita'], consoleEl, beam);
                return;
            }

            // Step 2: Scan Row 2
            setTimeout(() => {
                beam.style.top = '70px';
                consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #2] Cek slug="kue-enak-bu-sri"... ' + (slug === 'kue-enak-bu-sri' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

                if (slug === 'kue-enak-bu-sri') {
                    finishScan(true, dbRows['kue-enak-bu-sri'], consoleEl, beam);
                    return;
                }

                // Step 3: Scan Row 3
                setTimeout(() => {
                    beam.style.top = '108px';
                    consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #3] Cek slug="batik-indah"... ' + (slug === 'batik-indah' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

                    if (slug === 'batik-indah') {
                        finishScan(true, dbRows['batik-indah'], consoleEl, beam);
                        return;
                    }

                    // Not Found: Hits bottom
                    setTimeout(() => {
                        beam.className = 'db-scan-pointer fail';
                        beam.style.top = '140px';
                        consoleEl.innerHTML += '<span class="text-danger fw-bold">[EXCEPTION] Pemindaian mencapai akhir tabel: Baris tidak ditemukan!</span><br>';
                        consoleEl.innerHTML += '<span class="text-warning">&rarr; Laravel memicu ModelNotFoundException &rarr; Otomatis melempar HTTP 404 tanpa menyentuh controller!</span>';
                    }, 400);

                }, 400);
            }, 400);
        }, 300);
    }

    function finishScan(success, rowData, consoleEl, beam) {
        beam.className = 'db-scan-pointer match';
        consoleEl.innerHTML += '<span class="text-success fw-bold">[MATCH FOUND] Baris ID ' + rowData.id + ' ("' + rowData.name + '") berhasil di-resolve!</span><br>';
        consoleEl.innerHTML += '<span class="text-info">&rarr; Instance App\\Models\\Portfolio langsung diinjeksi ke parameter $portfolio di Controller (HTTP 200 OK)!</span>';
    }


    /* ========================================================
       SIMULATOR 2: NETWORK PACKET STREAM (N+1 BATTLE)
       ======================================================== */
    let nRows = 10;
    let simTimer = null;

    function setNRows(num) {
        nRows = num;
        ['btnRows10', 'btnRows25', 'btnRows50'].forEach(id => document.getElementById(id).classList.remove('active'));
        if (num === 10) document.getElementById('btnRows10').classList.add('active');
        if (num === 25) document.getElementById('btnRows25').classList.add('active');
        if (num === 50) document.getElementById('btnRows50').classList.add('active');
    }

    function startPacketSimulation(mode) {
        if (simTimer) clearInterval(simTimer);

        const orbReq = document.getElementById('orbReq');
        const orbRes = document.getElementById('orbRes');
        const statusText = document.getElementById('packetStatusText');
        const counterLabel = document.getElementById('packetCounterLabel');
        const queryMetric = document.getElementById('metricQueryCount');
        const cpuMetric = document.getElementById('metricCpuLoad');
        const latMetric = document.getElementById('metricLatency');
        const logs = document.getElementById('simN1Logs');

        logs.innerHTML = '';
        orbReq.style.display = 'block';
        orbRes.style.display = 'block';

        if (mode === 'lazy') {
            // Lazy loading N+1: many repeated round trips
            let currentP = 0;
            const totalPackets = 1 + nRows;
            statusText.innerText = 'Transmisi N+1: Paket data berulang bolak-balik...';
            logs.innerHTML += '<span class="text-danger fw-bold">[QUERY #1] SELECT * FROM `portfolios` LIMIT ' + nRows + ';</span><br>';

            simTimer = setInterval(() => {
                currentP++;
                queryMetric.innerText = currentP + ' / ' + totalPackets;
                counterLabel.innerText = currentP + ' Req / ' + currentP + ' Res';
                latMetric.innerText = (currentP * 3.2).toFixed(0) + ' ms';

                // Trigger packet animations
                orbReq.style.animation = 'none';
                orbRes.style.animation = 'none';
                void orbReq.offsetWidth;
                void orbRes.offsetWidth;
                orbReq.style.animation = 'travelRight 0.3s forwards';

                setTimeout(() => {
                    orbRes.style.animation = 'travelLeft 0.3s forwards';
                }, 150);

                // Heat up CPU
                const cpu = Math.min(98, 20 + Math.round((currentP / totalPackets) * 78));
                cpuMetric.innerHTML = '<span class="text-danger fw-bold">' + cpu + '% (OVERHEAT!)</span>';

                if (currentP > 1 && currentP <= 6) {
                    logs.innerHTML += '<span class="text-warning">[LOOP #' + (currentP - 1) + '] SELECT * FROM `portfolio_products` WHERE `portfolio_id` = ' + (currentP - 1) + ';</span><br>';
                } else if (currentP === 7) {
                    logs.innerHTML += '<span class="text-muted">... ' + (totalPackets - 6) + ' query serupa lainnya terus membanjiri antrian socket database!</span><br>';
                }

                if (currentP >= totalPackets) {
                    clearInterval(simTimer);
                    statusText.innerHTML = '<span class="text-danger fw-bold">Selesai: ' + totalPackets + ' Query terkirim! Pemborosan sumber daya server.</span>';
                }
            }, 350);

        } else {
            // Eager loading: only 2 round trips!
            queryMetric.innerText = '1 / 2';
            counterLabel.innerText = '1 Req / 1 Res';
            latMetric.innerText = '2 ms';
            cpuMetric.innerHTML = '<span class="text-success fw-bold">8% (Dingin & Cepat)</span>';
            statusText.innerText = 'Eager Loading: Mengambil data induk...';

            orbReq.style.animation = 'travelRight 0.4s forwards';
            logs.innerHTML += '<span class="text-success fw-bold">[QUERY #1] SELECT * FROM `portfolios` LIMIT ' + nRows + ';</span><br>';

            setTimeout(() => {
                orbRes.style.animation = 'travelLeft 0.4s forwards';
                logs.innerHTML += '<span class="text-info">[PHP RAM] Mengumpulkan ' + nRows + ' ID portofolio ke dalam array memori...</span><br>';

                setTimeout(() => {
                    queryMetric.innerText = '2 / 2';
                    counterLabel.innerText = '2 Req / 2 Res';
                    latMetric.innerText = '4 ms';
                    statusText.innerText = 'Eager Loading: Mengambil seluruh relasi produk sekaligus...';

                    orbReq.style.animation = 'none';
                    void orbReq.offsetWidth;
                    orbReq.style.animation = 'travelRight 0.4s forwards';

                    let ids = Array.from({length: Math.min(8, nRows)}, (_, i) => i + 1).join(', ');
                    logs.innerHTML += '<span class="text-success fw-bold">[QUERY #2] SELECT * FROM `portfolio_products` WHERE `portfolio_id` IN (' + ids + (nRows > 8 ? ', ...' : '') + ');</span><br>';

                    setTimeout(() => {
                        orbRes.style.animation = 'none';
                        void orbRes.offsetWidth;
                        orbRes.style.animation = 'travelLeft 0.4s forwards';
                        statusText.innerHTML = '<span class="text-success fw-bold">Selesai: HANYA 2 QUERY! Seluruh produk langsung dipetakan ke memori dalam 4ms.</span>';
                    }, 400);

                }, 500);
            }, 450);
        }
    }


    /* ========================================================
       SIMULATOR 3: SYMLINK INODE BRIDGE
       ======================================================== */
    let sampleFile = { name: 'banner.jpg', mime: 'image/jpeg', sizeKb: 720 };

    function selectSampleFile(name, mime, sizeKb) {
        sampleFile = { name, mime, sizeKb };
        ['choiceJpg', 'choicePhp', 'choiceOversize'].forEach(id => {
            document.getElementById(id).classList.remove('border-info', 'bg-dark');
        });
        if (name.endsWith('.jpg')) document.getElementById('choiceJpg').classList.add('border-info', 'bg-dark');
        if (name.endsWith('.php')) document.getElementById('choicePhp').classList.add('border-info', 'bg-dark');
        if (name.endsWith('.png')) document.getElementById('choiceOversize').classList.add('border-info', 'bg-dark');
    }

    function runSymlinkPipelineAnimation() {
        const consoleEl = document.getElementById('simSymlinkConsole');
        const storageBox = document.getElementById('storageFileBox');
        const publicBox = document.getElementById('publicFileBox');
        const badge = document.getElementById('symlinkBadge');
        const icon = document.getElementById('symlinkIcon');

        consoleEl.innerHTML = '<span class="text-info">[UPLOAD] Menerima form multipart: "' + sampleFile.name + '" (' + sampleFile.sizeKb + ' KB)...</span><br>';

        setTimeout(() => {
            if (sampleFile.mime === 'application/x-php') {
                consoleEl.innerHTML += '<span class="text-danger fw-bold">[KEAMANAN DITOLAK] Deteksi file berbahaya! Ekstensi .php dilarang oleh aturan validator `image|mimes:jpeg,png,webp`. File dimusnahkan seketika!</span>';
                storageBox.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>Ditolak Validator</span>';
                return;
            }

            if (sampleFile.sizeKb > 2048) {
                consoleEl.innerHTML += '<span class="text-warning fw-bold">[VALIDASI GAGAL] Ukuran file ' + (sampleFile.sizeKb / 1024).toFixed(1) + ' MB melebihi kuota `max:2048` (2 MB)!</span>';
                storageBox.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Ukuran Terlalu Besar</span>';
                return;
            }

            // Valid file
            consoleEl.innerHTML += '<span class="text-success">[VALIDASI SUKSES] File diverifikasi sebagai gambar asli (MIME: ' + sampleFile.mime + ').</span><br>';
            storageBox.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check2-circle me-1"></i>banners/hash_99a.jpg</span>';
            consoleEl.innerHTML += '<span class="text-info">[STORAGE] File disimpan di folder privat yang aman dari akses publik langsung: `storage/app/public/banners/hash_99a.jpg`.</span><br>';

            setTimeout(() => {
                badge.className = 'badge bg-success';
                badge.innerText = 'Active Linked';
                icon.className = 'bi bi-arrow-left-right text-success fs-4';
                publicBox.innerHTML = '<span class="text-info fw-bold"><i class="bi bi-link-45deg me-1"></i>/storage/banners/hash_99a.jpg</span>';
                consoleEl.innerHTML += '<span class="text-success fw-bold">[SYMLINK RESOLVED] Inode link aktif! Nginx langsung menyajikan file ke browser pengunjung via URL `asset("storage/banners/hash_99a.jpg")` tanpa membebani PHP!</span>';
            }, 600);
        }, 400);
    }


    /* ========================================================
       SIMULATOR 4: DATABASE TRANSACTION STAGING & ROLLBACK
       ======================================================== */
    function runMechanicalTxSimulation(isSuccess) {
        const consoleEl = document.getElementById('simTxConsole');
        const r1 = document.getElementById('txRow1');
        const r2 = document.getElementById('txRow2');
        const r3 = document.getElementById('txRow3');
        const b1 = document.getElementById('badgeRow1');
        const b2 = document.getElementById('badgeRow2');
        const b3 = document.getElementById('badgeRow3');
        const stateBadge = document.getElementById('txStateBadge');

        // Reset
        [r1, r2, r3].forEach(r => r.className = 'tx-row-item');
        [b1, b2, b3].forEach(b => { b.className = 'badge bg-secondary'; b.innerText = 'Waiting'; });
        stateBadge.className = 'badge bg-warning text-dark font-monospace';
        stateBadge.innerText = 'IN TRANSACTION (ISOLATED)';

        consoleEl.innerHTML = '<span class="text-warning">[DB] BEGIN TRANSACTION; Membuka batas isolasi atomik ACID...</span><br>';

        // Step 1
        setTimeout(() => {
            r1.className = 'tx-row-item staged';
            b1.className = 'badge bg-warning text-dark';
            b1.innerText = 'Staged in RAM';
            consoleEl.innerHTML += '<span class="text-info">[STEP 1] INSERT `portfolios` (Toko Roti Manis) disimpan di staging buffer...</span><br>';

            // Step 2
            setTimeout(() => {
                if (isSuccess) {
                    r2.className = 'tx-row-item staged';
                    b2.className = 'badge bg-warning text-dark';
                    b2.innerText = 'Staged in RAM';
                    consoleEl.innerHTML += '<span class="text-info">[STEP 2] INSERT 4 `portfolio_products` berhasil ditulis ke buffer...</span><br>';

                    // Step 3
                    setTimeout(() => {
                        r3.className = 'tx-row-item staged';
                        b3.className = 'badge bg-warning text-dark';
                        b3.innerText = 'Staged in RAM';
                        consoleEl.innerHTML += '<span class="text-info">[STEP 3] INSERT `activity_logs` berhasil ditulis ke buffer...</span><br>';

                        setTimeout(() => {
                            [r1, r2, r3].forEach(r => r.className = 'tx-row-item committed');
                            [b1, b2, b3].forEach(b => { b.className = 'badge bg-success'; b.innerText = 'COMMITTED'; });
                            stateBadge.className = 'badge bg-success font-monospace';
                            stateBadge.innerText = 'COMMITTED PERMANENT';
                            consoleEl.innerHTML += '<span class="text-success fw-bold">[DB] COMMIT; Seluruh 3 tahap permanen ditulis ke storage disk tanpa ada data korup!</span>';
                        }, 500);

                    }, 600);

                } else {
                    // Failure at Step 2
                    r2.className = 'tx-row-item rolled-back';
                    b2.className = 'badge bg-danger';
                    b2.innerText = 'ERROR DB / JARINGAN!';
                    consoleEl.innerHTML += '<span class="text-danger fw-bold">[EXCEPTION DI STEP 2] Kegagalan integritas data saat menyimpan produk!</span><br>';

                    setTimeout(() => {
                        r1.className = 'tx-row-item rolled-back';
                        b1.className = 'badge bg-danger';
                        b1.innerText = 'ROLLED BACK';

                        r3.className = 'tx-row-item';
                        b3.innerText = 'Cancelled';

                        stateBadge.className = 'badge bg-danger font-monospace';
                        stateBadge.innerText = 'ROLLED BACK (CLEAN)';
                        consoleEl.innerHTML += '<span class="text-danger fw-bold">[DB] ROLLBACK DIJALANKAN! Langkah 1 dibatalkan otomatis dari memori. Database kembali 100% bersih tanpa meninggalkan toko kosong!</span>';
                    }, 600);
                }
            }, 600);
        }, 400);
    }


    /* ========================================================
       SIMULATOR 5: ACCESSORS & ATTRIBUTE CASTING
       ======================================================== */
    function updateModernTransformer() {
        // 1. WhatsApp Accessor
        let wa = document.getElementById('simWaInput').value.trim();
        let waFormatted = wa.replace(/^0/, '62');
        document.getElementById('simWaOutput').innerText = 'https://wa.me/' + waFormatted + '?text=Halo%20saya%20tertarik';

        // 2. Price Accessor
        let price = parseInt(document.getElementById('simPriceInput').value) || 0;
        document.getElementById('simPriceOutput').innerText = 'Rp ' + price.toLocaleString('id-ID');

        // 3. JSON Array Caster
        let jsonRaw = document.getElementById('simJsonInput').value;
        try {
            let parsed = JSON.parse(jsonRaw);
            let ig = parsed.ig || '(tidak ada)';
            document.getElementById('simJsonOutput').innerText = ig + ' (Tipe Data: Array PHP Asli)';
            document.getElementById('simJsonOutput').className = 'text-info fw-bold';
        } catch(e) {
            document.getElementById('simJsonOutput').innerText = 'Error: Format JSON Tidak Valid!';
            document.getElementById('simJsonOutput').className = 'text-danger fw-bold';
        }
    }


    /* ========================================================
       SIMULATOR 6: EVENT BUS & LIFECYCLE PULSE
       ======================================================== */
    function triggerEventPulse(action) {
        const consoleEl = document.getElementById('simObserverConsole');
        const stateBadge = document.getElementById('eventActiveState');
        const n1 = document.getElementById('busNode1');
        const n2 = document.getElementById('busNode2');
        const n3 = document.getElementById('busNode3');
        const n4 = document.getElementById('busNode4');
        const l2 = document.getElementById('busLabel2');
        const l4 = document.getElementById('busLabel4');

        [n1, n2, n3, n4].forEach(n => { n.className = 'p-2 rounded bg-dark border border-secondary'; });

        if (action === 'create') {
            l2.innerText = 'creating';
            l4.innerText = 'created';
            consoleEl.innerHTML = '<span class="text-info">[ACTION] Memanggil Portfolio::create([...])...</span><br>';
        } else if (action === 'update') {
            l2.innerText = 'updating';
            l4.innerText = 'updated';
            consoleEl.innerHTML = '<span class="text-warning">[ACTION] Memanggil $portfolio->update([...])...</span><br>';
        } else {
            l2.innerText = 'deleting';
            l4.innerText = 'deleted';
            consoleEl.innerHTML = '<span class="text-danger">[ACTION] Memanggil $portfolio->delete()...</span><br>';
        }

        stateBadge.className = 'badge bg-warning text-dark font-monospace';
        stateBadge.innerText = 'DISPATCHING EVENTS';

        // Stage 1
        n1.className = 'p-2 rounded bg-primary border-primary';
        consoleEl.innerHTML += '<span class="text-secondary">[EVENT 1] Event `saving` ditembakkan: Validasi pra-penyimpanan...</span><br>';

        setTimeout(() => {
            n2.className = 'p-2 rounded bg-warning text-dark border-warning';
            consoleEl.innerHTML += '<span class="text-warning">[EVENT 2] Event `' + l2.innerText + '` ditembakkan: Bisa di-cancel dengan `return false`...</span><br>';

            setTimeout(() => {
                n3.className = 'p-2 rounded bg-info text-dark border-info';
                consoleEl.innerHTML += '<span class="text-info">[EVENT 3] Driver Database mengeksekusi perintah SQL I/O...</span><br>';

                setTimeout(() => {
                    n4.className = 'p-2 rounded bg-success border-success';
                    stateBadge.className = 'badge bg-success font-monospace';
                    stateBadge.innerText = 'OBSERVER TRIGGERED';
                    consoleEl.innerHTML += '<span class="text-success fw-bold">[EVENT 4] Event `' + l4.innerText + '` ditangkap oleh `PortfolioObserver`! ActivityLog berhasil dicatat otomatis tanpa 1 baris pun kode kotor di controller!</span>';
                }, 400);
            }, 400);
        }, 400);
    }


    /* ========================================================
       SIMULATOR 7: ONION RING PENETRATOR (MIDDLEWARE)
       ======================================================== */
    function shootMiddlewareRequest(isAuthenticated) {
        const bullet = document.getElementById('requestBullet');
        const consoleEl = document.getElementById('simOnionConsole');
        const ringG = document.getElementById('ringGlobal');
        const ringW = document.getElementById('ringWeb');
        const ringA = document.getElementById('ringAuth');
        const ringC = document.getElementById('ringCore');

        // Reset
        bullet.style.top = '15px';
        bullet.style.backgroundColor = '#38bdf8';
        bullet.style.boxShadow = '0 0 12px #38bdf8';
        consoleEl.innerHTML = '<span class="text-info">[HTTP INCOMING] Permintaan GET /ukk/admin masuk ke kernel aplikasi...</span><br>';

        // Step 1: Penetrasi Lapis 1 (Global)
        setTimeout(() => {
            bullet.style.top = '55px';
            ringG.style.borderColor = '#10b981';
            consoleEl.innerHTML += '<span class="text-secondary">[LAPIS 1: GLOBAL] TrimStrings & CheckMaintenance lolos validasi.</span><br>';

            // Step 2: Penetrasi Lapis 2 (Web Group)
            setTimeout(() => {
                bullet.style.top = '95px';
                ringW.style.borderColor = '#10b981';
                consoleEl.innerHTML += '<span class="text-secondary">[LAPIS 2: WEB GROUP] Cookie sesi didekripsi & Token CSRF valid.</span><br>';

                // Step 3: Penetrasi Lapis 3 (Auth Guard)
                setTimeout(() => {
                    if (isAuthenticated) {
                        bullet.style.top = '135px';
                        ringA.style.borderColor = '#10b981';
                        consoleEl.innerHTML += '<span class="text-success">[LAPIS 3: AUTH GUARD] Sesi `ukk_admin_id` ditemukan valid (ID: 1). Pintu gerbang terbuka!</span><br>';

                        setTimeout(() => {
                            bullet.style.top = '135px';
                            bullet.style.backgroundColor = '#10b981';
                            ringC.style.boxShadow = '0 0 25px rgba(16, 185, 129, 0.9)';
                            consoleEl.innerHTML += '<span class="text-success fw-bold">[CORE REACHED] Request sukses menembus inti Controller! AdminController@dashboard dieksekusi (HTTP 200 OK).</span>';
                        }, 400);

                    } else {
                        // Bounced back!
                        bullet.style.top = '95px';
                        bullet.style.backgroundColor = '#ef4444';
                        bullet.style.boxShadow = '0 0 15px #ef4444';
                        ringA.style.borderColor = '#ef4444';
                        ringA.style.backgroundColor = 'rgba(239, 68, 68, 0.25)';
                        consoleEl.innerHTML += '<span class="text-danger fw-bold">[LAPIS 3: AUTH GUARD DITOLAK] TIDAK ADA SESI LOGIN! Request dipantulkan keluar seketika dengan HTTP 302 Redirect ke /ukk/admin/login. Controller sama sekali tidak tersentuh!</span>';
                    }
                }, 500);
            }, 500);
        }, 400);
    }

    // Initialize defaults on page load
    document.addEventListener('DOMContentLoaded', function() {
        selectSampleFile('banner.jpg', 'image/jpeg', 720);
        updateModernTransformer();
    });
</script>
@endverbatim
@endpush
@endsection
