@extends('layouts.belajar')

@section('title', 'Materi Lanjutan: 7 Konsep Inti Arsitektur Laravel Modern - Belajar Laravel SMK')

@push('styles')
<style>
    /* Gradient Badges & Section Headers */
    .section-badge {
        font-size: 0.75rem;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 50rem;
    }
    .topic-nav-link {
        font-size: 0.88rem;
        color: #475569;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .topic-nav-link:hover, .topic-nav-link.active {
        background-color: #3b82f6;
        color: #ffffff !important;
        font-weight: 600;
    }
    /* Interactive Simulator Containers */
    .sim-card {
        background: #0f172a;
        color: #e2e8f0;
        border-radius: 14px;
        border: 1px solid #1e293b;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
    }
    .sim-header {
        background: #1e293b;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #334155;
    }
    .sim-body {
        padding: 20px;
    }
    /* Code Viewer */
    .code-viewer {
        background: #0b0f19;
        border-radius: 10px;
        padding: 14px;
        font-family: 'Fira Code', Consolas, monospace;
        font-size: 0.85rem;
        line-height: 1.6;
        color: #cbd5e1;
        overflow-x: auto;
        border: 1px solid #1e293b;
    }
    .code-viewer .kw { color: #f43f5e; font-weight: 600; }
    .code-viewer .fn { color: #38bdf8; font-weight: 600; }
    .code-viewer .str { color: #4ade80; }
    .code-viewer .cm { color: #64748b; font-style: italic; }
    .code-viewer .cls { color: #fbbf24; font-weight: 600; }

    /* Visual Pipeline Flow */
    .flow-step {
        background: #1e293b;
        border: 2px solid #334155;
        border-radius: 10px;
        padding: 14px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
    }
    .flow-step.active {
        border-color: #38bdf8;
        background: #0c4a6e;
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
    }
    .flow-step.error {
        border-color: #ef4444;
        background: #450a0a;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
    }
    .flow-step.success {
        border-color: #10b981;
        background: #064e3b;
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
    }

    /* Do's & Don'ts */
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
    /* Query Meter Bar */
    .meter-container {
        height: 12px;
        background: #334155;
        border-radius: 6px;
        overflow: hidden;
    }
    .meter-fill-red {
        background: linear-gradient(90deg, #f59e0b, #ef4444);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .meter-fill-green {
        background: linear-gradient(90deg, #34d399, #10b981);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- HERO HEADER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%); border-left: 6px solid #6366f1;">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-indigo text-white fw-bold px-3 py-1" style="background-color: #6366f1;">
                            <i class="bi bi-stars me-1"></i>MATERI LANJUTAN &bull; LEVEL MENENGAH - MAHIR
                        </span>
                        <span class="badge bg-secondary">Arsitektur Industri</span>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">
                        7 Konsep Inti Arsitektur Laravel Modern
                    </h2>
                    <p class="text-light text-opacity-80 mb-3 fs-6">
                        Pelajari bagaimana sistem skala industri dibangun dengan Laravel: Dari <strong>Route Model Binding</strong> (SEO Slugs), <strong>Pencegahan Masalah N+1 Query</strong> (Eager Loading), <strong>Pipeline Storage &amp; Symlink</strong>, <strong>Database Transactions</strong>, hingga <strong>Model Observers &amp; Pipeline Middleware</strong>.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-link-45deg text-primary me-1"></i>SEO Slugs</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-lightning-charge text-warning me-1"></i>Eager Loading</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-hdd-network text-info me-1"></i>Storage Symlink</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-arrow-repeat text-success me-1"></i>DB Transactions</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-magic text-danger me-1"></i>Accessors</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-eye text-purple me-1"></i>Model Observers</span>
                        <span class="badge bg-dark border border-secondary text-light px-3 py-2"><i class="bi bi-shield-lock text-emerald me-1"></i>Middleware</span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="bg-dark bg-opacity-50 p-3 rounded-3 border border-secondary border-opacity-25 text-start">
                        <h6 class="fw-bold text-warning mb-2"><i class="bi bi-lightbulb-fill me-1"></i>Untuk Guru &amp; Siswa:</h6>
                        <p class="small text-light opacity-75 mb-2">
                            Materi ini dirancang untuk memperdalam pemahaman framework setelah siswa menguasai CRUD dasar di Modul 1-6. Setiap topik dilengkapi analogi, implementasi kode nyata, Do's &amp; Don'ts, dan simulator interaktif.
                        </p>
                        <a href="#topik-1" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="bi bi-arrow-down-circle me-1"></i> Mulai Eksplorasi 7 Topik
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
                <span class="small fw-bold text-muted me-2 text-nowrap"><i class="bi bi-compass me-1"></i>Pilih Topik:</span>
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
                        <i class="bi bi-compass-fill me-2"></i>Mengapa Industri Menggunakan "Slug" dan Bukan "ID"?
                    </h5>
                    <p class="text-secondary small mb-3">
                        Di aplikasi pemula, URL detail produk biasanya ditulis seperti: <code class="text-danger">/produk/45</code> atau <code class="text-danger">/umkm/3</code>. Namun pada aplikasi profesional, URL ditulis: <code class="text-success">/umkm/kue-enak-bu-sri</code>. Mengapa?
                    </p>
                    <ul class="small text-secondary ps-3 mb-3">
                        <li class="mb-2"><strong>1. SEO (Search Engine Optimization):</strong> Algoritma Google memprioritaskan URL yang mengandung kata kunci pencarian produk daripada angka acak.</li>
                        <li class="mb-2"><strong>2. Ramah Manusia (Human-Readable):</strong> Pengguna langsung paham isi halaman sebelum mengkliknya di WhatsApp atau media sosial.</li>
                        <li class="mb-2"><strong>3. Mencegah ID Enumeration / IDOR:</strong> Angka ID mudah ditebak oleh peretas (misal menebak <code>/invoice/1</code>, <code>/invoice/2</code>) untuk mengikis seluruh database Anda!</li>
                    </ul>

                    <h6 class="fw-bold text-dark mt-3 mb-2"><i class="bi bi-code-slash me-1 text-primary"></i>Cara Kerja di Laravel:</h6>
                    <div class="code-viewer mb-2">
                        <span class="cm">// routes/web.php (Trik Custom Key ":slug")</span><br>
                        Route::<span class="fn">get</span>(<span class="str">'/umkm/{portfolio:slug}'</span>, [PortfolioController::<span class="kw">class</span>, <span class="str">'show'</span>]);<br><br>
                        <span class="cm">// app/Http/Controllers/PortfolioController.php</span><br>
                        <span class="kw">public function</span> <span class="fn">show</span>(<span class="cls">Portfolio</span> $portfolio)<br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Laravel OTOMATIS mengeksekusi:</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// SELECT * FROM portfolios WHERE slug = ? LIMIT 1</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Jika data TIDAK ADA, Laravel OTOMATIS memicu 404 Not Found!</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">view</span>(<span class="str">'umkm.show'</span>, <span class="fn">compact</span>(<span class="str">'portfolio'</span>));<br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 1 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-warning"><i class="bi bi-play-circle-fill me-1"></i>Simulator 1: Route Model Binding &amp; Slug Resolver</span>
                        <span class="badge bg-primary">Live Interactive</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Ketikkan URL atau pilih salah satu preset di bawah untuk melihat bagaimana Laravel me-resolve Model secara otomatis:
                        </p>

                        <!-- URL Address Bar -->
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-dark text-info border-secondary font-monospace small">https://aplikasi.smk/umkm/</span>
                            <input type="text" id="simSlugInput" class="form-control bg-dark text-white border-secondary font-monospace" value="kue-enak-bu-sri" placeholder="masukkan-slug-disini">
                            <button class="btn btn-primary" type="button" onclick="runSlugSimulation()">
                                <i class="bi bi-arrow-right-circle me-1"></i> Resolve
                            </button>
                        </div>

                        <!-- Presets -->
                        <div class="d-flex gap-2 mb-3">
                            <span class="small text-muted">Contoh Preset:</span>
                            <button class="btn btn-xs btn-outline-light py-0 px-2" style="font-size:0.75rem;" onclick="setSlugPreset('kue-enak-bu-sri')">kue-enak-bu-sri (Ada)</button>
                            <button class="btn btn-xs btn-outline-light py-0 px-2" style="font-size:0.75rem;" onclick="setSlugPreset('kopi-kita')">kopi-kita (Ada)</button>
                            <button class="btn btn-xs btn-outline-danger py-0 px-2" style="font-size:0.75rem;" onclick="setSlugPreset('toko-tidak-ada-xyz')">toko-tidak-ada-xyz (404)</button>
                        </div>

                        <!-- Animated Pipeline Step -->
                        <div class="row g-2 mb-3" id="slugPipelineSteps">
                            <div class="col-4">
                                <div class="flow-step" id="stepRouteMatch">
                                    <div class="small fw-bold text-white mb-1"><i class="bi bi-signpost-split"></i> 1. Route Match</div>
                                    <span class="badge bg-secondary" style="font-size: 0.65rem;">{portfolio:slug}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="flow-step" id="stepSqlQuery">
                                    <div class="small fw-bold text-white mb-1"><i class="bi bi-database"></i> 2. SQL Query</div>
                                    <span class="badge bg-secondary" style="font-size: 0.65rem;" id="stepSqlBadge">WHERE slug = ?</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="flow-step" id="stepResult">
                                    <div class="small fw-bold text-white mb-1"><i class="bi bi-display"></i> 3. Response</div>
                                    <span class="badge bg-secondary" style="font-size: 0.65rem;" id="stepResBadge">Menunggu...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Simulation Result Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.8rem; min-height: 110px;" id="simSlugConsole">
                            <span class="text-muted">// Klik tombol "Resolve" untuk melacak alur eksekusi internal Laravel...</span>
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
                        <li>Gunakan helper <code>Str::slug($namaUsaha)</code> untuk mengubah string spasi &amp; simbol menjadi slug bersih seragam.</li>
                        <li>Tambahkan index unik pada kolom slug di file migrasi: <code>$table-&gt;string('slug')-&gt;unique();</code> agar performa query tetap instan.</li>
                        <li>Gunakan Type-Hinting Model: <code>public function show(Portfolio $portfolio)</code> agar kode rapi dan terhindar dari error 500.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-donts p-3">
                    <h6 class="fw-bold text-danger mb-2"><i class="bi bi-x-circle-fill me-2"></i>Don'ts (Kesalahan Fatal Pemula)</h6>
                    <ul class="small text-dark mb-0 ps-3">
                        <li><strong>JANGAN</strong> menulis query manual berulang: <code>$p = Portfolio::where('slug', $slug)-&gt;first(); if(!$p) { abort(404); }</code> di setiap method controller!</li>
                        <li><strong>JANGAN</strong> membiarkan slug mengandung karakter terlarang seperti tanda tanya, garis miring, atau huruf kapital.</li>
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
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Apa itu "N+1 Query Problem"? (Musuh Utama Server DB)
                    </h5>
                    <p class="text-secondary small mb-3">
                        Bayangkan Anda ingin menampilkan daftar <strong>50 UMKM</strong>, dan di setiap card UMKM Anda menampilkan jumlah produk atau daftar produknya.
                    </p>
                    <div class="alert alert-danger py-2 small mb-3">
                        <strong>KASUS LAZY LOADING (Salah Kaprah):</strong><br>
                        <code>$umkms = Portfolio::all();</code> &rarr; <strong>Query #1:</strong> <code>SELECT * FROM portfolios;</code> (dapat 50 baris).<br>
                        Lalu di Blade Anda melakukan:<br>
                        <code>&#64;foreach($umkms as $u) @{{ $u->products->count() }} &#64;endforeach</code><br>
                        Untuk setiap iterasi, Laravel mengirim query baru! <strong>50 Query Tambahan!</strong><br>
                        Total: <strong>1 + 50 = 51 Query Database!</strong> Jika ada 1.000 data, server database bisa hang/mati seketika!
                    </div>

                    <div class="alert alert-success py-2 small mb-3">
                        <strong>SOLUSI EAGER LOADING (Standar Industri):</strong><br>
                        Gunakan metode <code>with()</code> di Controller:<br>
                        <code>$umkms = Portfolio::with('products')-&gt;get();</code><br>
                        Laravel hanya menjalankan <strong>2 QUERY SAJA</strong>:<br>
                        1. <code>SELECT * FROM portfolios;</code><br>
                        2. <code>SELECT * FROM portfolio_products WHERE portfolio_id IN (1, 2, 3, ..., 50);</code><br>
                        Semua data produk langsung dipetakan ke memori dalam sekejap!
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 2 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-warning"><i class="bi bi-speedometer2 me-1"></i>Simulator 2: N+1 Query vs Eager Loading Battle</span>
                        <span class="badge bg-warning text-dark">Live Profiler</span>
                    </div>
                    <div class="sim-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small text-light">Simulasikan Jumlah Data UMKM:</span>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-light active" id="btnRows10" onclick="setSimRows(10)">10 Data</button>
                                <button type="button" class="btn btn-outline-light" id="btnRows50" onclick="setSimRows(50)">50 Data</button>
                                <button type="button" class="btn btn-outline-light" id="btnRows100" onclick="setSimRows(100)">100 Data</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="runQueryBattle('lazy')">
                                    <i class="bi bi-tortoise me-1"></i> Jalankan Lazy Loading (N+1)
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success w-100 py-2 small fw-bold" onclick="runQueryBattle('eager')">
                                    <i class="bi bi-lightning-charge me-1"></i> Jalankan Eager Loading (with)
                                </button>
                            </div>
                        </div>

                        <!-- Live Metrics -->
                        <div class="bg-dark p-3 rounded-3 border border-secondary mb-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Beban Server &amp; Jumlah Query:</span>
                                <span class="fw-bold text-white" id="queryMetricsText">Menunggu Pengujian...</span>
                            </div>
                            <div class="meter-container mb-2">
                                <div id="queryMeterBar" class="meter-fill-green" style="width: 5%;"></div>
                            </div>
                            <div class="d-flex justify-content-between small" style="font-size: 0.75rem;">
                                <span class="text-secondary">Waktu Eksekusi: <strong class="text-white" id="execTimeText">0 ms</strong></span>
                                <span class="text-secondary">Status DB: <strong class="text-white" id="dbStatusText">Idle</strong></span>
                            </div>
                        </div>

                        <!-- Query SQL Logs Output -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; max-height: 130px; overflow-y: auto;" id="queryLogsOutput">
                            <span class="text-muted">// Klik salah satu tombol di atas untuk melihat perbandingan query SQL yang dikirim ke database...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DO'S & DON'TS TOPIK 2 -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card-dos p-3">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-check-circle-fill me-2"></i>Do's (Praktik Terbaik Industri)</h6>
                    <ul class="small text-dark mb-0 ps-3">
                        <li>Gunakan Eager Loading: <code>Portfolio::with(['products', 'admin'])-&gt;paginate(15);</code>.</li>
                        <li>Gunakan Lazy Eager Loading jika model sudah terlanjur di-load: <code>$portfolio-&gt;load('products');</code>.</li>
                        <li>Aktifkan <code>Model::preventLazyLoading(!app()-&gt;isProduction());</code> di file <code>app/Providers/AppServiceProvider.php</code> agar Laravel otomatis memunculkan error peringatan saat development jika developer lupa memakai <code>with()</code>.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-donts p-3">
                    <h6 class="fw-bold text-danger mb-2"><i class="bi bi-x-circle-fill me-2"></i>Don'ts (Kesalahan Fatal Pemula)</h6>
                    <ul class="small text-dark mb-0 ps-3">
                        <li><strong>JANGAN</strong> memanggil relasi langsung di dalam loop tampilan Blade tanpa Eager Loading!</li>
                        <li><strong>JANGAN</strong> melakukan query di dalam loop PHP native: <code>foreach ($users as $u) { DB::table('...')... }</code>.</li>
                    </ul>
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
                        <i class="bi bi-hdd-network-fill me-2"></i>Mengapa File Upload Tidak Boleh Ditaruh di Folder `public/`?
                    </h5>
                    <p class="text-secondary small mb-3">
                        Pemula sering tergoda memakai PHP native <code>move_uploaded_file()</code> langsung ke folder <code>public/uploads/</code>. Di dunia profesional Laravel, ini adalah <strong>celah keamanan fatal</strong>:
                    </p>
                    <ul class="small text-secondary ps-3 mb-3">
                        <li class="mb-2"><strong>Bahaya Eksekusi Script Jahat:</strong> Jika peretas mengunggah file <code>backdoor.php</code> ke folder publik, peretas bisa langsung membuka <code>http://web.com/uploads/backdoor.php</code> dan mengambil alih server!</li>
                        <li class="mb-2"><strong>Git Repository Kotor:</strong> File gambar yang di-upload user akan ikut ter-commit ke git repository jika ditaruh di folder publik tanpa konfigurasi yang benar.</li>
                    </ul>

                    <h6 class="fw-bold text-dark mt-3 mb-2"><i class="bi bi-link-45deg text-info me-1"></i>Konsep Perintah `php artisan storage:link`:</h6>
                    <p class="small text-secondary mb-2">
                        Laravel menyimpan file di folder terlindung <code>storage/app/public/</code>. Perintah <code>storage:link</code> membuat **Symbolic Link (Shortcut Virtual)** dari <code>public/storage</code> yang mengarah ke folder terlindung tersebut, sehingga file aman diakses publik lewat URL:
                    </p>
                    <div class="code-viewer">
                        <span class="cm">// Simpan file dari form controller:</span><br>
                        $path = $request-&gt;<span class="fn">file</span>(<span class="str">'banner'</span>)-&gt;<span class="fn">store</span>(<span class="str">'banners'</span>, <span class="str">'public'</span>);<br>
                        <span class="cm">// Menghasilkan: "banners/a7gX921z.jpg"</span><br><br>
                        <span class="cm">// Tampilkan di Blade view secara aman:</span><br>
                        &lt;img src="@{{ asset('storage/' . $portfolio->banner) }}" alt="Banner"&gt;
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 3 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-info"><i class="bi bi-cloud-arrow-up-fill me-1"></i>Simulator 3: Jalur File Upload &amp; Symlink Explorer</span>
                        <span class="badge bg-info text-dark">File Pipeline</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Pilih tipe file yang ingin diuji untuk melihat bagaimana validator Laravel dan jalur penyimpanan internal bekerja:
                        </p>

                        <!-- Radio File Type -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="fileChoiceJpg" onclick="selectSimFile('banner.jpg', 'image/jpeg', 850)">
                                    <i class="bi bi-file-earmark-image fs-4 text-success d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block">banner.jpg</span>
                                    <span class="badge bg-secondary" style="font-size:0.65rem;">850 KB (Valid)</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="fileChoicePhp" onclick="selectSimFile('exploit.php', 'application/x-php', 12)">
                                    <i class="bi bi-file-earmark-code fs-4 text-danger d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block">exploit.php</span>
                                    <span class="badge bg-danger" style="font-size:0.65rem;">Bahaya (.php)</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border border-secondary rounded-3 text-center cursor-pointer file-choice" id="fileChoiceLarge" onclick="selectSimFile('foto_4k.png', 'image/png', 5400)">
                                    <i class="bi bi-file-earmark-image fs-4 text-warning d-block mb-1"></i>
                                    <span class="small fw-bold text-white d-block">foto_4k.png</span>
                                    <span class="badge bg-warning text-dark" style="font-size:0.65rem;">5.4 MB (Kegedean)</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-info text-dark fw-bold w-100 mb-3" onclick="runUploadSimulation()">
                            <i class="bi bi-arrow-up-circle-fill me-1"></i> Kirim Request Upload ke Controller
                        </button>

                        <!-- Pipeline Visual Nodes -->
                        <div class="row g-2 mb-3">
                            <div class="col-3">
                                <div class="flow-step" id="upStepForm">
                                    <span class="small fw-bold text-white d-block" style="font-size: 0.72rem;">1. Multipart</span>
                                    <i class="bi bi-browser-chrome text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="upStepValid">
                                    <span class="small fw-bold text-white d-block" style="font-size: 0.72rem;">2. Mimes Check</span>
                                    <i class="bi bi-shield-check text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="upStepStorage">
                                    <span class="small fw-bold text-white d-block" style="font-size: 0.72rem;">3. storage/app</span>
                                    <i class="bi bi-folder-symlink text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="upStepPublic">
                                    <span class="small fw-bold text-white d-block" style="font-size: 0.72rem;">4. public/storage</span>
                                    <i class="bi bi-eye text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 90px;" id="simUploadConsole">
                            <span class="text-muted">// Pilih file di atas dan klik "Kirim Request Upload"...</span>
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
                        <i class="bi bi-shield-shaded me-2"></i>Prinsip "All or Nothing" (Semua Berhasil atau Batalkan Semua)
                    </h5>
                    <p class="text-secondary small mb-3">
                        Dalam aplikasi bisnis nyata seperti Platform UMKM, satu aksi pengguna seringkali menyimpan data ke <strong>beberapa tabel sekaligus</strong>:
                    </p>
                    <ol class="small text-secondary ps-3 mb-3">
                        <li class="mb-1">Simpan data profil UMKM ke tabel <code>portfolios</code>.</li>
                        <li class="mb-1">Simpan 4 data produk ke tabel <code>portfolio_products</code>.</li>
                        <li class="mb-1">Simpan rekam jejak admin ke tabel <code>activity_logs</code>.</li>
                    </ol>

                    <div class="alert alert-warning py-2 small mb-3">
                        <strong>BENCANA TANPA TRANSACTION:</strong><br>
                        Jika langkah 1 sukses, tetapi saat langkah 2 (insert produk) terjadi kegagalan jaringan atau disk penuh, apa yang terjadi?<br>
                        Data UMKM tersimpan tapi produknya kosong dan rusak! Terciptalah data sampah (*orphan record*) yang merusak integritas aplikasi.
                    </div>

                    <h6 class="fw-bold text-dark mt-2 mb-2"><i class="bi bi-code-slash text-success me-1"></i>Solusi Menggunakan `DB::transaction`:</h6>
                    <div class="code-viewer">
                        <span class="kw">use</span> Illuminate\Support\Facades\<span class="cls">DB</span>;<br><br>
                        <span class="cls">DB</span>::<span class="fn">transaction</span>(<span class="kw">function</span> () <span class="kw">use</span> ($request) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$portfolio = <span class="cls">Portfolio</span>::<span class="fn">create</span>([...]);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$portfolio-&gt;<span class="fn">products</span>()-&gt;<span class="fn">createMany</span>([...]);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([...]);<br>
                        });<br>
                        <span class="cm">// Jika ada 1 error saja &rarr; ROLLBACK OTOMATIS!</span><br>
                        <span class="cm">// Jika semua sukses &rarr; COMMIT KE DATABASE!</span>
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 4 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-success"><i class="bi bi-arrow-repeat me-1"></i>Simulator 4: Transaksi Atomik (Commit vs Rollback)</span>
                        <span class="badge bg-success">Atomic Testing</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Uji coba skenario penyimpanan data multi-tabel untuk melihat bagaimana mekanisme Rollback melindungi database dari kerusakan:
                        </p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-success w-100 py-2 small fw-bold" onclick="runTransactionSimulation(true)">
                                    <i class="bi bi-check2-circle me-1"></i> Skenario A: Semua Langkah Sukses
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="runTransactionSimulation(false)">
                                    <i class="bi bi-x-octagon me-1"></i> Skenario B: Langkah 2 Gagal (Error)
                                </button>
                            </div>
                        </div>

                        <!-- 3 Multi-Step Cards -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="flow-step" id="txStep1">
                                    <span class="badge bg-secondary d-block mb-1" style="font-size:0.65rem;">Langkah 1</span>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">Insert Portfolio</span>
                                    <span class="text-muted" style="font-size:0.68rem;" id="txStep1Status">Pending</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="flow-step" id="txStep2">
                                    <span class="badge bg-secondary d-block mb-1" style="font-size:0.65rem;">Langkah 2</span>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">Insert Products</span>
                                    <span class="text-muted" style="font-size:0.68rem;" id="txStep2Status">Pending</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="flow-step" id="txStep3">
                                    <span class="badge bg-secondary d-block mb-1" style="font-size:0.65rem;">Langkah 3</span>
                                    <span class="small fw-bold text-white d-block" style="font-size:0.75rem;">Insert ActivityLog</span>
                                    <span class="text-muted" style="font-size:0.68rem;" id="txStep3Status">Pending</span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Final Status Box -->
                        <div class="bg-dark p-3 rounded-3 border border-secondary mb-3 text-center" id="txStatusBox">
                            <span class="small text-muted d-block mb-1">Status Transaksi DB:</span>
                            <span class="badge bg-secondary px-3 py-2 fs-6 fw-bold" id="txStatusBadge">IDLE (MENUNGGU)</span>
                        </div>

                        <!-- Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 90px;" id="simTxConsole">
                            <span class="text-muted">// Klik salah satu skenario di atas untuk melihat proses atomik...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <!-- ========================================================= -->
    <!-- TOPIK 5: ELOQUENT ACCESSORS & MUTATORS                   -->
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
                        <i class="bi bi-magic me-2"></i>Format Data di Model, Bukan Mengotori View Blade!
                    </h5>
                    <p class="text-secondary small mb-3">
                        Seringkali kita melihat kode pemula yang rumit di Blade hanya untuk memformat nomor telepon atau rupiah:
                        <br><code class="text-danger">&lt;a href="https://wa.me/@{{ '62' . substr($u->wa, 1) }}?text=Halo"&gt;Hubungi&lt;/a&gt;</code>
                    </p>
                    <p class="text-secondary small mb-3">
                        Ini melanggar prinsip <strong>Clean Architecture</strong>. Tugas Blade hanyalah menampilkan data, bukan memanipulasi string rumit! Solusinya adalah menggunakan **Accessors** di Model:
                    </p>

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
                    <p class="small text-secondary mb-0">
                        Sekarang di Blade, siswa cukup memanggil properti bersih: <code>&lt;a href="@{{ $portfolio->whatsapp_url }}"&gt;</code>!
                    </p>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 5 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-danger"><i class="bi bi-input-cursor-text me-1"></i>Simulator 5: Accessor &amp; Mutator Playground</span>
                        <span class="badge bg-danger">Live Studio</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Ketikkan data mentah pada form di bawah dan perhatikan bagaimana Accessor dan Mutator mentransformasikan data secara instan:
                        </p>

                        <!-- Input 1: WhatsApp -->
                        <div class="mb-3">
                            <label class="small text-secondary fw-bold mb-1">1. Input Nomor WhatsApp Mentah (Contoh: 08123456789):</label>
                            <input type="text" id="simWaInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value="081234567890" oninput="updateAccessorSim()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.72rem;">Hasil Accessor ($portfolio-&gt;whatsapp_url):</span>
                                <span class="text-success fw-bold text-break" id="simWaOutput">https://wa.me/6281234567890</span>
                            </div>
                        </div>

                        <!-- Input 2: Harga Angka -->
                        <div class="mb-3">
                            <label class="small text-secondary fw-bold mb-1">2. Input Angka Harga Mentah di DB (Integer):</label>
                            <input type="number" id="simPriceInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value="25000" oninput="updateAccessorSim()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.72rem;">Hasil Accessor ($product-&gt;harga_rupiah):</span>
                                <span class="text-warning fw-bold" id="simPriceOutput">Rp 25.000</span>
                            </div>
                        </div>

                        <!-- Input 3: Nama Usaha Mutator -->
                        <div class="mb-2">
                            <label class="small text-secondary fw-bold mb-1">3. Input Nama Usaha (Mutator Otomatis membuat Slug):</label>
                            <input type="text" id="simNameInput" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" value="Kue Lezat & Gurih Bu Sri!" oninput="updateAccessorSim()">
                            <div class="p-2 mt-1 rounded bg-black border border-secondary font-monospace small">
                                <span class="text-muted d-block" style="font-size:0.72rem;">Hasil Mutator ($portfolio-&gt;slug):</span>
                                <span class="text-info fw-bold" id="simSlugOutput">kue-lezat-gurih-bu-sri</span>
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
                        <i class="bi bi-eye-fill me-2"></i>Mencatat Log Aktivitas Tanpa Mengotori Setiap Baris Controller
                    </h5>
                    <p class="text-secondary small mb-3">
                        Bagaimana sistem enterprise mencatat riwayat: <em>"Admin A mengubah status UMKM B menjadi Published pada pukul 14:00"</em>?
                    </p>
                    <p class="text-secondary small mb-3">
                        Jika developer menulis kode manual <code>ActivityLog::create()</code> di setiap method controller (store, update, destroy, toggle), kode controller akan menjadi sangat panjang dan rentan kelupaan (*human error*).
                    </p>
                    <p class="text-secondary small mb-3">
                        Laravel menyediakan **Model Observer** yang otomatis mendengarkan siklus hidup model (*lifecycle events*):
                    </p>
                    <div class="code-viewer">
                        <span class="cm">// Terminal: php artisan make:observer PortfolioObserver --model=Portfolio</span><br><br>
                        <span class="kw">class</span> <span class="cls">PortfolioObserver</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">created</span>(<span class="cls">Portfolio</span> $portfolio): <span class="kw">void</span><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'action'</span> =&gt; <span class="str">'CREATE'</span>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'details'</span> =&gt; <span class="str">"Portofolio {$portfolio-&gt;nama_usaha} diterbitkan."</span>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 6 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-purple" style="color:#c084fc;"><i class="bi bi-diagram-3-fill me-1"></i>Simulator 6: Siklus Hidup Model &amp; Event Dispatcher</span>
                        <span class="badge" style="background:#8b5cf6;">Lifecycle Flow</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Tekan tombol aksi model di bawah untuk melihat urutan event internal yang ditembakkan (*fired*) oleh Eloquent ORM:
                        </p>

                        <div class="d-flex gap-2 mb-3">
                            <button class="btn btn-sm btn-outline-primary fw-bold" onclick="runLifecycleSimulation('create')">
                                <i class="bi bi-plus-circle me-1"></i> Portfolio::create()
                            </button>
                            <button class="btn btn-sm btn-outline-warning fw-bold" onclick="runLifecycleSimulation('update')">
                                <i class="bi bi-pencil-square me-1"></i> $portfolio->update()
                            </button>
                            <button class="btn btn-sm btn-outline-danger fw-bold" onclick="runLifecycleSimulation('delete')">
                                <i class="bi bi-trash3 me-1"></i> $portfolio->delete()
                            </button>
                        </div>

                        <!-- Lifecycle Pipeline -->
                        <div class="row g-2 mb-3">
                            <div class="col-3">
                                <div class="flow-step" id="lifeStep1">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.72rem;">1. saving</span>
                                    <span class="text-muted" style="font-size:0.65rem;">Sebelum Tulis</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="lifeStep2">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.72rem;" id="lifeStep2Label">2. creating</span>
                                    <span class="text-muted" style="font-size:0.65rem;">Event Pre-DB</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="lifeStep3">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.72rem;">3. SQL Query</span>
                                    <span class="text-muted" style="font-size:0.65rem;">Tulis DB</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="lifeStep4">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.72rem;" id="lifeStep4Label">4. created</span>
                                    <span class="text-muted" style="font-size:0.65rem;">Observer Log!</span>
                                </div>
                            </div>
                        </div>

                        <!-- Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 90px;" id="simLifeConsole">
                            <span class="text-muted">// Klik salah satu aksi model di atas untuk melihat siklus hidup event...</span>
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
                        <i class="bi bi-layers-half me-2"></i>Konsep "Lapis Kulit Bawang" (The Onion Architecture)
                    </h5>
                    <p class="text-secondary small mb-3">
                        Setiap kali browser mengirim request ke aplikasi Laravel Anda, request tersebut tidak langsung menyentuh Controller!
                        Request harus melewati serangkaian **Middleware** secara berurutan:
                    </p>
                    <ol class="small text-secondary ps-3 mb-3">
                        <li class="mb-1"><strong>TrimStrings:</strong> Membuang spasi kosong di awal &amp; akhir form input.</li>
                        <li class="mb-1"><strong>VerifyCsrfToken:</strong> Memastikan token keamanan ada dan valid.</li>
                        <li class="mb-1"><strong>StartSession:</strong> Membaca cookie dan menyiapkan session penyimpanan.</li>
                        <li class="mb-1"><strong>Custom Middleware (Auth Check):</strong> Menilai apakah user berhak mengakses atau harus ditendang keluar!</li>
                    </ol>

                    <h6 class="fw-bold text-dark mt-2 mb-2"><i class="bi bi-code-slash text-secondary me-1"></i>Contoh Middleware Pintu Masuk Admin:</h6>
                    <div class="code-viewer">
                        <span class="kw">public function</span> <span class="fn">handle</span>(<span class="cls">Request</span> $request, <span class="cls">Closure</span> $next): <span class="cls">Response</span><br>
                        {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (!<span class="fn">session</span>()-&gt;<span class="fn">has</span>(<span class="str">'ukk_admin_id'</span>)) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">redirect</span>()-&gt;<span class="fn">route</span>(<span class="str">'ukk.admin.login'</span>)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">with</span>(<span class="str">'error'</span>, <span class="str">'Akses Ditolak! Harap login dahulu.'</span>);<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> $next($request); <span class="cm">// Lolos ke Controller!</span><br>
                        }
                    </div>
                </div>
            </div>

            <!-- SIMULATOR INTERAKTIF 7 -->
            <div class="col-lg-6">
                <div class="sim-card h-100">
                    <div class="sim-header">
                        <span class="fw-bold small text-secondary"><i class="bi bi-shield-lock-fill me-1"></i>Simulator 7: Middleware Gatekeeper Inspector</span>
                        <span class="badge bg-secondary">Pipeline Inspector</span>
                    </div>
                    <div class="sim-body">
                        <p class="small text-light opacity-75 mb-3">
                            Pilih status kredensial pengunjung saat mencoba mengakses halaman privat <code>/ukk/admin</code>:
                        </p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button class="btn btn-outline-danger w-100 py-2 small fw-bold" onclick="runMiddlewareSimulation(false)">
                                    <i class="bi bi-person-x me-1"></i> Tanpa Sesi Login (Tamu Asing)
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-success w-100 py-2 small fw-bold" onclick="runMiddlewareSimulation(true)">
                                    <i class="bi bi-person-check me-1"></i> Memiliki Sesi Admin Valid
                                </button>
                            </div>
                        </div>

                        <!-- Middleware Step Visualization -->
                        <div class="row g-2 mb-3">
                            <div class="col-3">
                                <div class="flow-step" id="mwStep1">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.7rem;">1. Request</span>
                                    <i class="bi bi-arrow-right text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="mwStep2">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.7rem;">2. CSRF &amp; Cookie</span>
                                    <i class="bi bi-shield-check text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="mwStep3">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.7rem;">3. Auth Check</span>
                                    <i class="bi bi-key text-muted"></i>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="flow-step" id="mwStep4">
                                    <span class="small fw-bold text-white d-block" style="font-size:0.7rem;">4. Controller</span>
                                    <i class="bi bi-display text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Console -->
                        <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 90px;" id="simMwConsole">
                            <span class="text-muted">// Klik salah satu tombol di atas untuk melihat aksi gerbang middleware...</span>
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
       SIMULATOR 1: SLUG RESOLVER
       ======================================================== */
    const knownSlugs = {
        'kue-enak-bu-sri': { name: 'Kue Enak Bu Sri', status: 'published', products: 4 },
        'kopi-kita': { name: 'Kopi Kita Nusantara', status: 'published', products: 2 },
        'batik-indah': { name: 'Batik Indah Tradisional', status: 'published', products: 3 },
        'kue-lezat': { name: 'Kue Lezat Rumahan', status: 'draft', products: 1 }
    };

    function setSlugPreset(slug) {
        document.getElementById('simSlugInput').value = slug;
        runSlugSimulation();
    }

    function runSlugSimulation() {
        const slug = document.getElementById('simSlugInput').value.trim().toLowerCase();
        const stepRoute = document.getElementById('stepRouteMatch');
        const stepSql = document.getElementById('stepSqlQuery');
        const stepRes = document.getElementById('stepResult');
        const resBadge = document.getElementById('stepResBadge');
        const sqlBadge = document.getElementById('stepSqlBadge');
        const consoleEl = document.getElementById('simSlugConsole');

        // Reset styling
        [stepRoute, stepSql, stepRes].forEach(el => el.className = 'flow-step');
        consoleEl.innerHTML = '<span class="text-info">[1/3] HTTP GET /umkm/' + slug + ' diterima...</span><br>';

        // Step 1: Route Matching
        setTimeout(() => {
            stepRoute.classList.add('active');
            consoleEl.innerHTML += '<span class="text-warning">[2/3] Route parameter terdeteksi: {portfolio:slug} = "' + slug + '"</span><br>';
        }, 300);

        // Step 2: SQL Execution
        setTimeout(() => {
            stepSql.classList.add('active');
            sqlBadge.innerText = 'SELECT * ... WHERE slug="' + slug + '"';
            consoleEl.innerHTML += '<span class="text-light">[SQL] SELECT * FROM `portfolios` WHERE `slug` = \'' + slug + '\' AND `deleted_at` IS NULL LIMIT 1;</span><br>';
        }, 700);

        // Step 3: Result
        setTimeout(() => {
            if (knownSlugs[slug]) {
                const item = knownSlugs[slug];
                stepRes.classList.add('success');
                resBadge.className = 'badge bg-success';
                resBadge.innerText = '200 OK (Model Injected)';
                consoleEl.innerHTML += '<span class="text-success fw-bold">[3/3] Model Ditemukan! Menginjeksi instance Portfolio ("' + item.name + '", ' + item.products + ' produk) langsung ke Controller parameter! Status: 200 OK</span>';
            } else {
                stepRes.classList.add('error');
                resBadge.className = 'badge bg-danger';
                resBadge.innerText = '404 Not Found';
                consoleEl.innerHTML += '<span class="text-danger fw-bold">[3/3] ModelNotFoundException! Laravel otomatis melempar abort(404) dan menampilkan halaman resources/views/errors/404.blade.php secara elegan tanpa error 500!</span>';
            }
        }, 1200);
    }

    /* ========================================================
       SIMULATOR 2: N+1 QUERY VS EAGER LOADING
       ======================================================== */
    let currentRows = 10;

    function setSimRows(num) {
        currentRows = num;
        ['btnRows10', 'btnRows50', 'btnRows100'].forEach(id => document.getElementById(id).classList.remove('active'));
        document.getElementById('btnRows' + num).classList.add('active');
        document.getElementById('queryMetricsText').innerText = num + ' UMKM Terpilih (Klik uji coba)';
    }

    function runQueryBattle(mode) {
        const bar = document.getElementById('queryMeterBar');
        const metrics = document.getElementById('queryMetricsText');
        const execTime = document.getElementById('execTimeText');
        const dbStatus = document.getElementById('dbStatusText');
        const logs = document.getElementById('queryLogsOutput');

        logs.innerHTML = '';

        if (mode === 'lazy') {
            const queryCount = 1 + currentRows;
            const timeMs = Math.round(queryCount * 2.8);
            bar.className = 'meter-fill-red';
            bar.style.width = Math.min(100, (queryCount / 101) * 100) + '%';
            metrics.innerHTML = '<span class="text-danger fw-bold">' + queryCount + ' QUERY DATABASE! (N+1 PROBLEM)</span>';
            execTime.innerText = timeMs + ' ms';
            dbStatus.innerHTML = '<span class="text-danger fw-bold">OVERLOAD / HIGH LATENCY</span>';

            logs.innerHTML += '<span class="text-danger">// QUERY #1 (Ambil data UMKM)</span><br>';
            logs.innerHTML += '<span class="text-light">SELECT * FROM `portfolios` LIMIT ' + currentRows + ';</span><br>';
            logs.innerHTML += '<span class="text-danger">// QUERY #2 s/d #' + queryCount + ' (Looping query di dalam Blade view!):</span><br>';
            for (let i = 1; i <= Math.min(5, currentRows); i++) {
                logs.innerHTML += '<span class="text-warning">[Loop #' + i + '] SELECT * FROM `portfolio_products` WHERE `portfolio_id` = ' + i + ';</span><br>';
            }
            if (currentRows > 5) {
                logs.innerHTML += '<span class="text-muted">... dan ' + (currentRows - 5) + ' query serupa lainnya diulang-ulang!</span><br>';
            }
        } else {
            // Eager loading
            const queryCount = 2;
            const timeMs = 4;
            bar.className = 'meter-fill-green';
            bar.style.width = '8%';
            metrics.innerHTML = '<span class="text-success fw-bold">HANYA 2 QUERY! (EAGER LOADING WITH)</span>';
            execTime.innerText = timeMs + ' ms';
            dbStatus.innerHTML = '<span class="text-success fw-bold">OPTIMAL & CEPAT</span>';

            logs.innerHTML += '<span class="text-success">// QUERY #1: Ambil semua data UMKM</span><br>';
            logs.innerHTML += '<span class="text-light">SELECT * FROM `portfolios` LIMIT ' + currentRows + ';</span><br>';
            logs.innerHTML += '<span class="text-success">// QUERY #2: Ambil semua produk terkait sekaligus pakai WHERE IN!</span><br>';
            let ids = Array.from({length: Math.min(10, currentRows)}, (_, i) => i + 1).join(', ');
            logs.innerHTML += '<span class="text-light">SELECT * FROM `portfolio_products` WHERE `portfolio_id` IN (' + ids + (currentRows > 10 ? ', ...' : '') + ');</span><br>';
            logs.innerHTML += '<span class="text-info fw-bold">// Semua relasi langsung di-hydrate ke memori PHP secara instan!</span>';
        }
    }

    /* ========================================================
       SIMULATOR 3: FILE STORAGE PIPELINE
       ======================================================== */
    let selectedFile = { name: 'banner.jpg', mime: 'image/jpeg', sizeKb: 850 };

    function selectSimFile(name, mime, sizeKb) {
        selectedFile = { name, mime, sizeKb };
        ['fileChoiceJpg', 'fileChoicePhp', 'fileChoiceLarge'].forEach(id => {
            document.getElementById(id).classList.remove('border-primary', 'bg-dark');
        });
        if (name.endsWith('.jpg')) document.getElementById('fileChoiceJpg').classList.add('border-primary', 'bg-dark');
        if (name.endsWith('.php')) document.getElementById('fileChoicePhp').classList.add('border-primary', 'bg-dark');
        if (name.endsWith('.png')) document.getElementById('fileChoiceLarge').classList.add('border-primary', 'bg-dark');
    }

    function runUploadSimulation() {
        const steps = ['upStepForm', 'upStepValid', 'upStepStorage', 'upStepPublic'];
        steps.forEach(id => document.getElementById(id).className = 'flow-step');
        const consoleEl = document.getElementById('simUploadConsole');
        consoleEl.innerHTML = '<span class="text-info">[1/4] Mengirim form multipart/form-data: "' + selectedFile.name + '" (' + selectedFile.sizeKb + ' KB)...</span><br>';

        document.getElementById('upStepForm').classList.add('active');

        setTimeout(() => {
            const step2 = document.getElementById('upStepValid');
            if (selectedFile.mime !== 'image/jpeg' && selectedFile.mime !== 'image/png') {
                step2.classList.add('error');
                consoleEl.innerHTML += '<span class="text-danger fw-bold">[2/4] VALIDASI GAGAL! File "' + selectedFile.name + '" ditolak oleh aturan "image|mimes:jpg,png,webp". File script eksekusi dilarang keras masuk server!</span>';
                return;
            }
            if (selectedFile.sizeKb > 2048) {
                step2.classList.add('error');
                consoleEl.innerHTML += '<span class="text-danger fw-bold">[2/4] VALIDASI GAGAL! Ukuran file (' + (selectedFile.sizeKb / 1024).toFixed(1) + ' MB) melebihi batas "max:2048" (2 MB)!</span>';
                return;
            }

            step2.classList.add('success');
            consoleEl.innerHTML += '<span class="text-success">[2/4] Validasi Lolos! File gambar asli terverifikasi.</span><br>';

            setTimeout(() => {
                document.getElementById('upStepStorage').classList.add('success');
                consoleEl.innerHTML += '<span class="text-info">[3/4] File diacak namanya & disimpan aman di: storage/app/public/banners/hash9823.jpg</span><br>';

                setTimeout(() => {
                    document.getElementById('upStepPublic').classList.add('success');
                    consoleEl.innerHTML += '<span class="text-success fw-bold">[4/4] Terbaca via Symlink! asset("storage/banners/hash9823.jpg") langsung bisa ditampilkan di tag &lt;img&gt; browser!</span>';
                }, 500);
            }, 500);
        }, 500);
    }

    /* ========================================================
       SIMULATOR 4: DATABASE TRANSACTIONS
       ======================================================== */
    function runTransactionSimulation(isSuccess) {
        const s1 = document.getElementById('txStep1');
        const s2 = document.getElementById('txStep2');
        const s3 = document.getElementById('txStep3');
        const s1Text = document.getElementById('txStep1Status');
        const s2Text = document.getElementById('txStep2Status');
        const s3Text = document.getElementById('txStep3Status');
        const badge = document.getElementById('txStatusBadge');
        const consoleEl = document.getElementById('simTxConsole');

        [s1, s2, s3].forEach(el => el.className = 'flow-step');
        badge.className = 'badge bg-warning text-dark px-3 py-2 fs-6 fw-bold';
        badge.innerText = 'TRANSACTION IN PROGRESS...';
        consoleEl.innerHTML = '<span class="text-warning">[DB] BEGIN TRANSACTION; (Memulai blok transaksi atomik)</span><br>';

        // Step 1
        setTimeout(() => {
            s1.classList.add('active');
            s1Text.innerText = 'INSERT portfolios...';
            consoleEl.innerHTML += '<span class="text-info">[1/3] INSERT INTO `portfolios` ... [ID: 101]</span><br>';

            // Step 2
            setTimeout(() => {
                if (isSuccess) {
                    s2.classList.add('active');
                    s2Text.innerText = 'INSERT products...';
                    consoleEl.innerHTML += '<span class="text-info">[2/3] INSERT INTO `portfolio_products` (4 rows) ... [SUCCESS]</span><br>';

                    // Step 3
                    setTimeout(() => {
                        s3.classList.add('active');
                        s3Text.innerText = 'INSERT logs...';
                        consoleEl.innerHTML += '<span class="text-info">[3/3] INSERT INTO `activity_logs` ... [SUCCESS]</span><br>';

                        setTimeout(() => {
                            [s1, s2, s3].forEach(el => el.className = 'flow-step success');
                            badge.className = 'badge bg-success px-3 py-2 fs-6 fw-bold';
                            badge.innerText = 'COMMIT (SEMUA DATA TERSIMPAN AMAN)';
                            consoleEl.innerHTML += '<span class="text-success fw-bold">[DB] COMMIT; Semua data permanen tersimpan di database tanpa cacat!</span>';
                        }, 500);
                    }, 600);
                } else {
                    // Fail at step 2
                    s2.classList.add('error');
                    s2Text.innerText = 'ERROR DB / JARINGAN!';
                    consoleEl.innerHTML += '<span class="text-danger fw-bold">[2/3] EXCEPTION: Database query error di tabel produk!</span><br>';

                    setTimeout(() => {
                        s1.className = 'flow-step error';
                        s2.className = 'flow-step error';
                        s3.className = 'flow-step';
                        s3Text.innerText = 'Dibatalkan';
                        badge.className = 'badge bg-danger px-3 py-2 fs-6 fw-bold';
                        badge.innerText = 'ROLLBACK (SEMUA PERUBAHAN DIBATALKAN)';
                        consoleEl.innerHTML += '<span class="text-danger fw-bold">[DB] ROLLBACK; Langkah 1 dibatalkan otomatis! Database kembali bersih 100% tanpa menyisakan data korup!</span>';
                    }, 600);
                }
            }, 600);
        }, 500);
    }

    /* ========================================================
       SIMULATOR 5: ACCESSORS & MUTATORS
       ======================================================== */
    function updateAccessorSim() {
        // WA Accessor
        let wa = document.getElementById('simWaInput').value.trim();
        let waFormatted = wa.replace(/^0/, '62');
        document.getElementById('simWaOutput').innerText = 'https://wa.me/' + waFormatted + '?text=Halo%20saya%20tertarik';

        // Price Accessor
        let price = parseInt(document.getElementById('simPriceInput').value) || 0;
        document.getElementById('simPriceOutput').innerText = 'Rp ' + price.toLocaleString('id-ID');

        // Slug Mutator
        let name = document.getElementById('simNameInput').value;
        let slug = name.toLowerCase()
                       .replace(/[^a-z0-9 -]/g, '')
                       .replace(/\s+/g, '-')
                       .replace(/-+/g, '-');
        document.getElementById('simSlugOutput').innerText = slug;
    }

    /* ========================================================
       SIMULATOR 6: MODEL LIFECYCLE
       ======================================================== */
    function runLifecycleSimulation(action) {
        const steps = ['lifeStep1', 'lifeStep2', 'lifeStep3', 'lifeStep4'];
        steps.forEach(id => document.getElementById(id).className = 'flow-step');
        const l2 = document.getElementById('lifeStep2Label');
        const l4 = document.getElementById('lifeStep4Label');
        const consoleEl = document.getElementById('simLifeConsole');

        if (action === 'create') {
            l2.innerText = '2. creating';
            l4.innerText = '4. created';
            consoleEl.innerHTML = '<span class="text-info">[LIFECYCLE] Portfolio::create() dipanggil...</span><br>';
        } else if (action === 'update') {
            l2.innerText = '2. updating';
            l4.innerText = '4. updated';
            consoleEl.innerHTML = '<span class="text-warning">[LIFECYCLE] $portfolio->update() dipanggil...</span><br>';
        } else {
            l2.innerText = '2. deleting';
            l4.innerText = '4. deleted';
            consoleEl.innerHTML = '<span class="text-danger">[LIFECYCLE] $portfolio->delete() dipanggil...</span><br>';
        }

        document.getElementById('lifeStep1').classList.add('active');

        setTimeout(() => {
            document.getElementById('lifeStep2').classList.add('active');
            setTimeout(() => {
                document.getElementById('lifeStep3').classList.add('active');
                setTimeout(() => {
                    document.getElementById('lifeStep4').classList.add('success');
                    consoleEl.innerHTML += '<span class="text-purple fw-bold">[OBSERVER] PortfolioObserver::' + l4.innerText.split('. ')[1] + '() tertrigger otomatis di background! ActivityLog baru berhasil dicatat tanpa 1 baris pun kode di controller!</span>';
                }, 400);
            }, 400);
        }, 400);
    }

    /* ========================================================
       SIMULATOR 7: MIDDLEWARE PIPELINE
       ======================================================== */
    function runMiddlewareSimulation(hasSession) {
        const steps = ['mwStep1', 'mwStep2', 'mwStep3', 'mwStep4'];
        steps.forEach(id => document.getElementById(id).className = 'flow-step');
        const consoleEl = document.getElementById('simMwConsole');

        consoleEl.innerHTML = '<span class="text-info">[1/4] HTTP GET /ukk/admin masuk ke kernel aplikasi...</span><br>';
        document.getElementById('mwStep1').classList.add('active');

        setTimeout(() => {
            document.getElementById('mwStep2').classList.add('success');
            consoleEl.innerHTML += '<span class="text-success">[2/4] TrimStrings, EncryptCookies & StartSession berhasil diproses.</span><br>';

            setTimeout(() => {
                const s3 = document.getElementById('mwStep3');
                if (hasSession) {
                    s3.classList.add('success');
                    consoleEl.innerHTML += '<span class="text-success">[3/4] EnsureUkkAdmin: Session "ukk_admin_id" valid (ID: 1). Akses diizinkan!</span><br>';
                    setTimeout(() => {
                        document.getElementById('mwStep4').classList.add('success');
                        consoleEl.innerHTML += '<span class="text-success fw-bold">[4/4] Controller Merespons! Dashboard Admin ditampilkan (200 OK).</span>';
                    }, 400);
                } else {
                    s3.classList.add('error');
                    consoleEl.innerHTML += '<span class="text-danger fw-bold">[3/4] EnsureUkkAdmin: TIDAK DITEMUKAN SESI LOGIN! Request dicegat di middleware & di-redirect ke /ukk/admin/login dengan pesan "Silakan login". Controller sama sekali tidak disentuh!</span>';
                }
            }, 500);
        }, 500);
    }

    // Initialize simulators on load
    document.addEventListener('DOMContentLoaded', function() {
        selectSimFile('banner.jpg', 'image/jpeg', 850);
        updateAccessorSim();
    });
</script>
@endverbatim
@endpush
@endsection
