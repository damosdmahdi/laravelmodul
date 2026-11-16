@extends('layouts.belajar')

@section('title', 'Topik 2: Relasi Eloquent & N+1 Query Problem - Belajar Laravel SMK')

@push('styles')
<style>
    .code-box-header {
        background: #111827;
        padding: 8px 16px;
        font-size: 0.78rem;
        font-family: 'Fira Code', monospace;
        color: #94a3b8;
        border-bottom: 1px solid #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .code-editor-body {
        background: #050811;
        padding: 16px;
        font-family: 'Fira Code', Consolas, monospace;
        font-size: 0.86rem;
        line-height: 1.7;
        color: #cbd5e1;
        overflow-x: auto;
    }
    .code-editor-body .kw { color: #f43f5e; font-weight: 600; }
    .code-editor-body .fn { color: #38bdf8; font-weight: 600; }
    .code-editor-body .str { color: #4ade80; }
    .code-editor-body .cm { color: #64748b; font-style: italic; }
    .code-editor-body .cls { color: #fbbf24; font-weight: 600; }
    .code-editor-body .var { color: #e2e8f0; }

    /* Network Packet Track */
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
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('belajar.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('belajar.materi.lanjutan') }}" class="text-decoration-none">Materi Lanjutan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Topik 2: Relasi &amp; Masalah N+1</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark px-3 py-1">Topik 2 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">Database Performance</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #78350f 0%, #0f172a 100%); border-left: 6px solid #f59e0b;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Relasi Eloquent &amp; Pencegahan Masalah "N+1 Query"
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Mengapa pemanggilan relasi di dalam perulangan Blade dapat melumpuhkan server database melalui puluhan query bolak-balik, dan bagaimana metode Eager Loading <code>with()</code> menyelesaikannya hanya dengan 2 query cepat.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan.1') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-arrow-left me-1"></i> Topik 1
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.3') }}" class="btn btn-warning text-dark btn-sm fw-bold">
                        Lanjut ke Topik 3 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TEORI & PERBANDINGAN QUERY -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>Anatomi Masalah: Lazy Loading di Dalam Loop
                </h5>
                <p class="text-secondary small mb-3">
                    Bayangkan Anda ingin menampilkan daftar <strong>50 UMKM</strong>, dan di setiap card UMKM menampilkan jumlah produknya:
                </p>
                <div class="p-3 bg-light rounded-3 border border-danger mb-3 font-monospace small text-danger" style="font-size:0.78rem;">
                    // Controller:<br>
                    $umkms = Portfolio::all(); // Query 1: SELECT * FROM portfolios;<br><br>
                    // Di Blade View:<br>
                    &commat;foreach($umkms as $u)<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Toko: @{{ $u->nama_usaha }}<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;Produk: @{{ $u->products->count() }} &lt;!-- QUERY BARU TIAP ITERASI! --&gt;<br>
                    &commat;endforeach
                </div>
                <div class="alert alert-danger py-2 small mb-0">
                    <strong>Beban Database:</strong> 1 Query Induk + 50 Query Anak = <strong>51 Kali Bolak-Balik TCP Socket Jaringan!</strong> Jika ada 1.000 data, server database langsung *hang* karena kehabisan slot koneksi.
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-lightning-charge me-2"></i>Solusi Eager Loading: Cuma 2 Query SQL!
                </h5>
                <p class="text-secondary small mb-3">
                    Di Controller, tambahkan method <code>with('nama_relasi')</code>:
                </p>
                <div class="p-3 bg-light rounded-3 border border-success mb-3 font-monospace small text-success" style="font-size:0.78rem;">
                    // Controller:<br>
                    $umkms = Portfolio::with('products')->get();<br><br>
                    // SQL yang Dijalankan Laravel:<br>
                    1. SELECT * FROM `portfolios`;<br>
                    2. SELECT * FROM `portfolio_products` WHERE `portfolio_id` IN (1, 2, ..., 50);
                </div>
                <p class="text-secondary small mb-0">
                    Laravel mengambil seluruh data produk sekaligus menggunakan klausa <code>WHERE IN</code>, lalu memetakan produk ke masing-masing objek toko di RAM server PHP. Di Blade, data dibaca murni dari memori tanpa query database tambahan!
                </p>
            </div>
        </div>
    </div>

    <!-- KODE ASLI LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Kode Asli Definisi Relasi &amp; Controller</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="topic2Tabs">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab2Model">
                        <i class="bi bi-diagram-3 text-primary me-1"></i>app/Models/Portfolio.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab2Controller">
                        <i class="bi bi-cpu text-warning me-1"></i>app/Http/Controllers/UkkController.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="topic2TabsContent">
                <div class="tab-pane fade show active" id="tab2Model">
                    <div class="code-box-header">
                        <span><i class="bi bi-diagram-3 me-1"></i>DEFINISI RELASI ONE-TO-MANY (1 TOKO MEMILIKI BANYAK PRODUK)</span>
                        <span class="badge bg-primary">app/Models/Portfolio.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">namespace</span> App\Models;<br><br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Model;<br>
<span class="kw">use</span> Illuminate\Database\Eloquent\Relations\<span class="cls">HasMany</span>;<br><br>
<span class="kw">class</span> <span class="cls">Portfolio</span> <span class="kw">extends</span> <span class="cls">Model</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">/**<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Relasi: 1 Portfolio memiliki banyak Produk Katalog<br>
&nbsp;&nbsp;&nbsp;&nbsp; */</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">products</span>(): <span class="cls">HasMany</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="var">$this</span>-&gt;<span class="fn">hasMany</span>(<span class="cls">PortfolioProduct</span>::<span class="kw">class</span>, <span class="str">'portfolio_id'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <div class="tab-pane fade" id="tab2Controller">
                    <div class="code-box-header">
                        <span><i class="bi bi-cpu me-1"></i>CONTROLLER: EAGER LOADING &amp; withCount()</span>
                        <span class="badge bg-warning text-dark">app/Http/Controllers/UkkController.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="cm">// 1. Mengambil Toko Sekaligus Seluruh Produknya (Hanya 2 Query):</span><br>
<span class="var">$umkms</span> = <span class="cls">Portfolio</span>::<span class="fn">with</span>(<span class="str">'products'</span>)-&gt;<span class="fn">where</span>(<span class="str">'status'</span>, <span class="str">'published'</span>)-&gt;<span class="fn">get</span>();<br><br>
<span class="cm">// 2. Hanya Menghitung Jumlah Produk Tanpa Mengambil Datanya (Super Ringan):</span><br>
<span class="var">$umkms</span> = <span class="cls">Portfolio</span>::<span class="fn">withCount</span>(<span class="str">'products'</span>)-&gt;<span class="fn">get</span>();<br>
<span class="cm">// Otomatis menghasilkan properti virtual: $u->products_count</span><br><br>
<span class="cm">// 3. Mencegah Developer Lupa Menggunakan with() Selama Belajar (AppServiceProvider.php):</span><br>
<span class="cls">Model</span>::<span class="fn">preventLazyLoading</span>(!<span class="fn">app</span>()-&gt;<span class="fn">isProduction</span>());
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF DUAL NODE TRAFFIC -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-warning me-2"></i>Simulator Interaktif: Transmisi Paket TCP (PHP Worker vs Database Daemon)</span>
            <span class="badge bg-warning text-dark">Network Traffic Monitor</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1">Simulasikan Jumlah Data UMKM:</label>
                        <div class="btn-group btn-group-sm w-100">
                            <button type="button" class="btn btn-outline-light active" id="btnRows10" onclick="setNRows(10)">10 Data</button>
                            <button type="button" class="btn btn-outline-light" id="btnRows25" onclick="setNRows(25)">25 Data</button>
                            <button type="button" class="btn btn-outline-light" id="btnRows50" onclick="setNRows(50)">50 Data</button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-outline-danger btn-sm fw-bold py-2" onclick="startPacketSimulation('lazy')">
                            <i class="bi bi-arrow-repeat me-1"></i> Jalankan Lazy Loading (N+1)
                        </button>
                        <button class="btn btn-success btn-sm fw-bold py-2" onclick="startPacketSimulation('eager')">
                            <i class="bi bi-lightning-charge me-1"></i> Jalankan Eager Loading (with)
                        </button>
                    </div>

                    <div class="p-3 bg-dark rounded-3 border border-secondary text-secondary small">
                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-lightbulb text-warning me-1"></i>Perhatikan Baik-Baik:</h6>
                        Pada mode Lazy Loading, amati pulsa paket yang membanjiri kabel berkali-kali dan suhu CPU Database yang naik drastis menjadi merah (*Overheat*).
                    </div>
                </div>

                <div class="col-lg-8">
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

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.1') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 1: Route Model Binding
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.3') }}" class="btn btn-warning text-dark fw-bold">
                Topik 3: Storage &amp; Symlink <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
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
            let currentP = 0;
            const totalPackets = 1 + nRows;
            statusText.innerText = 'Transmisi N+1: Paket data berulang bolak-balik...';
            logs.innerHTML += '<span class="text-danger fw-bold">[QUERY #1] SELECT * FROM `portfolios` LIMIT ' + nRows + ';</span><br>';

            simTimer = setInterval(() => {
                currentP++;
                queryMetric.innerText = currentP + ' / ' + totalPackets;
                counterLabel.innerText = currentP + ' Req / ' + currentP + ' Res';
                latMetric.innerText = (currentP * 3.2).toFixed(0) + ' ms';

                orbReq.style.animation = 'none';
                orbRes.style.animation = 'none';
                void orbReq.offsetWidth;
                void orbRes.offsetWidth;
                orbReq.style.animation = 'travelRight 0.3s forwards';

                setTimeout(() => {
                    orbRes.style.animation = 'travelLeft 0.3s forwards';
                }, 150);

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
</script>
@endverbatim
@endpush
@endsection
