@extends('layouts.belajar')

@section('title', 'Topik 1: Route Model Binding & SEO Slugs - Belajar Laravel SMK')

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

    /* Scanner Pointer */
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
                <li class="breadcrumb-item active" aria-current="page">Topik 1: Route Model Binding &amp; Slugs</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary text-white px-3 py-1">Topik 1 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">Routing &amp; SEO Architecture</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); border-left: 6px solid #3b82f6;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-link-45deg text-warning me-2"></i>Route Model Binding &amp; Custom Key (SEO Slugs)
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Bagaimana Laravel menghubungkan parameter URL secara langsung dengan baris database melalui klausa <code>WHERE slug = ?</code>, menginjeksi instance model secara otomatis, dan menangani error 404 tanpa menyentuh controller.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-grid-fill me-1"></i> Daftar Silabus
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.2') }}" class="btn btn-primary btn-sm fw-bold">
                        Lanjut ke Topik 2 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- KONSEP & TEORI -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-shield-lock-fill me-2"></i>Mengapa Industri Menghindari ID Mentah di URL?
                </h5>
                <p class="text-secondary small mb-3">
                    Bandingkan dua tautan ini:
                    <br><code class="text-danger">https://domain.id/umkm/45</code> &nbsp;<em>vs</em>&nbsp; <code class="text-success">https://domain.id/umkm/kue-enak-bu-sri</code>
                </p>
                <ul class="small text-secondary ps-3 mb-3">
                    <li class="mb-2"><strong>1. Anti-IDOR (Insecure Direct Object Reference):</strong> Jika menggunakan ID angka <code>/invoice/101</code>, penyerang dapat menjalankan skrip otomatis untuk membuka <code>/invoice/102</code> hingga <code>/invoice/999</code> untuk mencuri data. Slug teks unik memblokir eksploitasi angka berurutan ini.</li>
                    <li class="mb-2"><strong>2. Peringkat Google SEO:</strong> Algoritma perayap Google memprioritaskan kata kunci di dalam URL daripada angka acak.</li>
                    <li class="mb-2"><strong>3. Human Readability:</strong> Pengguna lebih percaya membuka link WhatsApp yang bertuliskan nama toko dibanding tautan berisi angka misterius.</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-magic me-2"></i>Keajaiban Route Model Binding di Laravel
                </h5>
                <p class="text-secondary small mb-3">
                    Di PHP Native atau framework lama, developer harus menulis query manual di setiap method:
                </p>
                <div class="p-2 bg-light rounded-3 border border-danger mb-3 font-monospace small text-danger" style="font-size:0.75rem;">
                    $toko = DB::query("SELECT * FROM portfolios WHERE slug = '$slug'");<br>
                    if (!$toko) { header("HTTP/1.0 404 Not Found"); exit(); }
                </div>
                <p class="text-secondary small mb-2">
                    Di Laravel, cukup tuliskan <strong>Custom Key</strong> dengan tanda titik dua <code>{portfolio:slug}</code>:
                </p>
                <div class="p-2 bg-light rounded-3 border border-success font-monospace small text-success" style="font-size:0.78rem;">
                    Route::get('/umkm/{portfolio:slug}', [UkkController::class, 'showPublicPortfolio']);
                </div>
                <p class="text-secondary small mt-2 mb-0">
                    Laravel otomatis mengeksekusi query dan langsung menyuntikkan model <code>$portfolio</code> ke controller. Jika data tidak ada, Laravel otomatis memicu <code>ModelNotFoundException</code> dan menampilkan layar 404 tanpa crash!
                </p>
            </div>
        </div>
    </div>

    <!-- BEDAH KODE NYATA 3 FILE -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Penerapan Kode Asli di File Laravel</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="topic1Tabs">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab1Route">
                        <i class="bi bi-signpost-2 text-primary me-1"></i>routes/web.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab1Controller">
                        <i class="bi bi-cpu text-warning me-1"></i>app/Http/Controllers/UkkController.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab1Migration">
                        <i class="bi bi-database text-info me-1"></i>database/migrations/xxxx_create_portfolios_table.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="topic1TabsContent">
                <div class="tab-pane fade show active" id="tab1Route">
                    <div class="code-box-header">
                        <span><i class="bi bi-signpost-split me-1"></i>DEFINISI RUTE PUBLIK DENGAN CUSTOM KEY :slug</span>
                        <span class="badge bg-primary">routes/web.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="cm">// Pintu Masuk Halaman Publik UMKM</span><br>
Route::<span class="fn">get</span>(<span class="str">'/umkm/{portfolio:slug}'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'showPublicPortfolio'</span>])<br>
&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">name</span>(<span class="str">'umkm.show'</span>);<br><br>
<span class="cm">// Contoh Scoped Binding (Relasi Bersarang):</span><br>
<span class="cm">// Laravel otomatis memeriksa bahwa {product} benar-benar memiliki portfolio_id yang cocok!</span><br>
Route::<span class="fn">get</span>(<span class="str">'/umkm/{portfolio:slug}/produk/{product:id}'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'showProduct'</span>]);
                    </div>
                </div>

                <div class="tab-pane fade" id="tab1Controller">
                    <div class="code-box-header">
                        <span><i class="bi bi-cpu me-1"></i>CONTROLLER DENGAN TYPE-HINTING MODEL</span>
                        <span class="badge bg-warning text-dark">app/Http/Controllers/UkkController.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">namespace</span> App\Http\Controllers;<br><br>
<span class="kw">use</span> App\Models\<span class="cls">Portfolio</span>;<br>
<span class="kw">use</span> Illuminate\Http\<span class="cls">Request</span>;<br><br>
<span class="kw">class</span> <span class="cls">UkkController</span> <span class="kw">extends</span> <span class="cls">Controller</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">showPublicPortfolio</span>(<span class="cls">Portfolio</span> <span class="var">$portfolio</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Model $portfolio sudah otomatis di-resolve dari database via slug!</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Jika slug salah / berstatus draft, sistem otomatis merender 404.</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (<span class="var">$portfolio</span>-&gt;status !== <span class="str">'published'</span>) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">response</span>()-&gt;<span class="fn">view</span>(<span class="str">'ukk.public.404'</span>, [<span class="str">'slug'</span> =&gt; <span class="var">$portfolio</span>-&gt;slug], 404);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Increment jumlah pengunjung</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span>-&gt;<span class="fn">increment</span>(<span class="str">'views'</span>);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">view</span>(<span class="str">'ukk.public.portfolio'</span>, <span class="fn">compact</span>(<span class="str">'portfolio'</span>));<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <div class="tab-pane fade" id="tab1Migration">
                    <div class="code-box-header">
                        <span><i class="bi bi-database me-1"></i>SKEMA MIGRASI DENGAN UNIQUE INDEX</span>
                        <span class="badge bg-info text-dark">database/migrations</span>
                    </div>
                    <div class="code-editor-body">
<span class="cls">Schema</span>::<span class="fn">create</span>(<span class="str">'portfolios'</span>, <span class="kw">function</span> (<span class="cls">Blueprint</span> <span class="var">$table</span>) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">id</span>();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">string</span>(<span class="str">'nama_usaha'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// KUNCI: Kolom slug wajib unique() agar pencarian instan dan URL tidak kembar!</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">string</span>(<span class="str">'slug'</span>)-&gt;<span class="fn">unique</span>();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">string</span>(<span class="str">'whatsapp'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">enum</span>(<span class="str">'status'</span>, [<span class="str">'draft'</span>, <span class="str">'published'</span>])-&gt;<span class="fn">default</span>(<span class="str">'published'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">timestamps</span>();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$table</span>-&gt;<span class="fn">softDeletes</span>();<br>
});
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF PENUH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-primary me-2"></i>Simulator Interaktif: Scanner Laser Baris Database SQL</span>
            <span class="badge bg-primary">Live Database Inspection</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-5">
                    <h6 class="fw-bold text-info mb-2">Bilah Alamat URL Browser:</h6>
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text bg-dark text-info border-secondary font-monospace" style="font-size:0.75rem;">https://domain.id/umkm/</span>
                        <input type="text" id="simSlugInput" class="form-control bg-black text-white border-secondary font-monospace" value="kue-enak-bu-sri">
                        <button class="btn btn-primary fw-bold px-3" type="button" onclick="runPhysicalSlugScanner()">
                            <i class="bi bi-search me-1"></i> Scan DB
                        </button>
                    </div>

                    <div class="d-flex flex-wrap gap-1 mb-3">
                        <span class="small text-muted me-1 align-self-center">Coba Preset:</span>
                        <button class="btn btn-xs btn-outline-info py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('kopi-kita')">kopi-kita (Row 1)</button>
                        <button class="btn btn-xs btn-outline-success py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('kue-enak-bu-sri')">kue-enak-bu-sri (Row 2)</button>
                        <button class="btn btn-xs btn-outline-warning py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('batik-indah')">batik-indah (Row 3)</button>
                        <button class="btn btn-xs btn-outline-danger py-0 px-2" style="font-size:0.72rem;" onclick="setSlugAndScan('warung-fiktif-404')">warung-fiktif-404 (404)</button>
                    </div>

                    <div class="p-3 bg-dark rounded-3 border border-secondary text-secondary small">
                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-lightbulb text-warning me-1"></i>Apa yang sedang diuji?</h6>
                        Ketika tombol ditekan, laser memindai baris database satu demi satu. Amati bagaimana pencocokan string slug terjadi secara internal.
                    </div>
                </div>

                <div class="col-lg-7">
                    <!-- Visual DB Table with Scanner Pointer -->
                    <div class="mb-3 position-relative bg-black p-3 rounded-3 border border-secondary">
                        <div class="small fw-bold text-muted mb-2 font-monospace" style="font-size:0.75rem;">
                            <i class="bi bi-table text-warning me-1"></i>TABEL: `portfolios` (DI DALAM DATABASE SQLITE/MYSQL)
                        </div>

                        <!-- Pointer Laser Beam -->
                        <div id="dbScannerBeam" class="db-scan-pointer" style="top: 40px;"></div>

                        <table class="table table-dark table-sm table-borderless mb-0 font-monospace small" style="font-size:0.78rem;">
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

                    <!-- Terminal Output -->
                    <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 100px;" id="simSlugScannerLog">
                        <span class="text-muted">// Klik tombol "Scan DB" untuk melihat jalannya pemindaian laser SQL...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-secondary">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.2') }}" class="btn btn-primary fw-bold">
                Topik 2: Relasi &amp; N+1 Query <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
    const dbRows = {
        'kopi-kita': { rowId: 'dbRow1', topPx: 40, name: 'Kopi Kita Nusantara', id: 1 },
        'kue-enak-bu-sri': { rowId: 'dbRow2', topPx: 78, name: 'Kue Enak Bu Sri', id: 2 },
        'batik-indah': { rowId: 'dbRow3', topPx: 116, name: 'Batik Indah Tradisional', id: 3 }
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
        beam.style.top = '40px';

        consoleEl.innerHTML = '<span class="text-info">[ROUTER] Menerima URL /umkm/' + slug + ' &rarr; Menjalankan Route Model Binding...</span><br>';

        setTimeout(() => {
            beam.style.top = '40px';
            consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #1] Cek slug="kopi-kita"... ' + (slug === 'kopi-kita' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

            if (slug === 'kopi-kita') {
                finishScan(true, dbRows['kopi-kita'], consoleEl, beam);
                return;
            }

            setTimeout(() => {
                beam.style.top = '78px';
                consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #2] Cek slug="kue-enak-bu-sri"... ' + (slug === 'kue-enak-bu-sri' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

                if (slug === 'kue-enak-bu-sri') {
                    finishScan(true, dbRows['kue-enak-bu-sri'], consoleEl, beam);
                    return;
                }

                setTimeout(() => {
                    beam.style.top = '116px';
                    consoleEl.innerHTML += '<span class="text-secondary">[SCANNER ROW #3] Cek slug="batik-indah"... ' + (slug === 'batik-indah' ? '<b class="text-success">COCOK!</b>' : '<span class="text-muted">Bukan</span>') + '</span><br>';

                    if (slug === 'batik-indah') {
                        finishScan(true, dbRows['batik-indah'], consoleEl, beam);
                        return;
                    }

                    setTimeout(() => {
                        beam.className = 'db-scan-pointer fail';
                        beam.style.top = '150px';
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
</script>
@endverbatim
@endpush
@endsection
