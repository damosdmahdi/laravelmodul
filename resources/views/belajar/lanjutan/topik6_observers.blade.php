@extends('layouts.belajar')

@section('title', 'Topik 6: Model Observers & Lifecycle Events - Belajar Laravel SMK')

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
                <li class="breadcrumb-item active" aria-current="page">Topik 6: Model Observers &amp; Events</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white px-3 py-1" style="background-color: #8b5cf6;">Topik 6 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">Event-Driven Architecture</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #4c1d95 0%, #0f172a 100%); border-left: 6px solid #8b5cf6;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-eye-fill text-warning me-2"></i>Model Observers &amp; Lifecycle Events (Audit Trail Otomatis)
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Bagaimana sistem enterprise mencatat riwayat aktivitas pengguna (*audit log*) secara otomatis menggunakan event siklus hidup model tanpa harus mengotori setiap baris Controller.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan.5') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-arrow-left me-1"></i> Topik 5
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.7') }}" class="btn text-white btn-sm fw-bold" style="background-color: #8b5cf6;">
                        Lanjut ke Topik 7 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TEORI & LIFECYCLE EVENTS -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3" style="color: #8b5cf6;">
                    <i class="bi bi-broadcast-pin me-2"></i>Siklus Hidup Model Eloquent (Lifecycle Events)
                </h5>
                <p class="text-secondary small mb-3">
                    Saat Model Eloquent berinteraksi dengan database, Laravel memancarkan event secara berpasangan (sebelum dan sesudah aksi):
                </p>
                <ul class="small text-secondary ps-3 mb-3">
                    <li class="mb-1"><code>creating</code> &amp; <code>created</code>: Saat baris baru akan dan telah ditulis ke database.</li>
                    <li class="mb-1"><code>updating</code> &amp; <code>updated</code>: Saat perubahan data akan dan telah disimpan.</li>
                    <li class="mb-1"><code>deleting</code> &amp; <code>deleted</code>: Saat record akan dan telah dihapus.</li>
                    <li class="mb-1"><code>saving</code> &amp; <code>saved</code>: Ditembakkan pada setiap aksi create maupun update.</li>
                </ul>
                <div class="alert alert-info py-2 small mb-0">
                    <strong>Fitur Batal Aksi:</strong> Jika method <code>creating()</code> atau <code>deleting()</code> me-return nilai <code>false</code>, Laravel otomatis membatalkan operasi SQL tersebut!
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-file-earmark-check me-2"></i>Keuntungan Menggunakan Observer di Proyek Nyata
                </h5>
                <p class="text-secondary small mb-3">
                    Mengapa tidak menulis kode pencatatan log di Controller saja?
                </p>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-2"><strong>Controller Super Rapi:</strong> Controller hanya fokus pada urutan request dan return view/redirect.</li>
                    <li class="mb-2"><strong>Tidak Ada Human Error:</strong> Developer tidak akan lupa mencatat log saat membuat method atau controller baru yang memanipulasi model tersebut.</li>
                    <li class="mb-2"><strong>Dukungan Artisan CLI &amp; Seeder:</strong> Ketika data dimasukkan via Seeder atau CLI command, Observer tetap berjalan dan mencatat aktivitas.</li>
                    <li class="mb-0"><strong>Metode saveQuietly():</strong> Gunakan <code>$portfolio->saveQuietly()</code> jika ingin menyimpan data tanpa memicu Observer (menghindari infinite loop).</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- KODE ASLI LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Penerapan Kode Asli Observer &amp; Registrasi</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="topic6Tabs">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab6Observer">
                        <i class="bi bi-eye text-primary me-1"></i>app/Observers/PortfolioObserver.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab6Provider">
                        <i class="bi bi-gear text-secondary me-1"></i>app/Providers/AppServiceProvider.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="topic6TabsContent">
                <div class="tab-pane fade show active" id="tab6Observer">
                    <div class="code-box-header">
                        <span><i class="bi bi-eye me-1"></i>OBSERVER AUDIT TRAIL OTOMATIS</span>
                        <span class="badge text-white" style="background:#8b5cf6;">app/Observers/PortfolioObserver.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">namespace</span> App\Observers;<br><br>
<span class="kw">use</span> App\Models\<span class="cls">Portfolio</span>;<br>
<span class="kw">use</span> App\Models\<span class="cls">ActivityLog</span>;<br><br>
<span class="kw">class</span> <span class="cls">PortfolioObserver</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">/**<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Tertrigger otomatis saat data UMKM baru disimpan<br>
&nbsp;&nbsp;&nbsp;&nbsp; */</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">created</span>(<span class="cls">Portfolio</span> <span class="var">$portfolio</span>): <span class="kw">void</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'admin_id'</span> =&gt; <span class="fn">session</span>(<span class="str">'ukk_admin_id'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'portfolio_id'</span> =&gt; <span class="var">$portfolio</span>-&gt;id,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'action'</span> =&gt; <span class="str">'CREATE'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'details'</span> =&gt; <span class="str">"UMKM {$portfolio->nama_usaha} baru saja didaftarkan ke platform."</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">/**<br>
&nbsp;&nbsp;&nbsp;&nbsp; * Tertrigger otomatis saat data UMKM diperbarui<br>
&nbsp;&nbsp;&nbsp;&nbsp; */</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">updated</span>(<span class="cls">Portfolio</span> <span class="var">$portfolio</span>): <span class="kw">void</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'admin_id'</span> =&gt; <span class="fn">session</span>(<span class="str">'ukk_admin_id'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'portfolio_id'</span> =&gt; <span class="var">$portfolio</span>-&gt;id,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'action'</span> =&gt; <span class="str">'UPDATE'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'details'</span> =&gt; <span class="str">"Profil {$portfolio->nama_usaha} (status: {$portfolio->status}) diperbarui."</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <div class="tab-pane fade" id="tab6Provider">
                    <div class="code-box-header">
                        <span><i class="bi bi-gear me-1"></i>REGISTRASI OBSERVER DI BOOTSTRAP</span>
                        <span class="badge bg-secondary">app/Providers/AppServiceProvider.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">use</span> App\Models\<span class="cls">Portfolio</span>;<br>
<span class="kw">use</span> App\Observers\<span class="cls">PortfolioObserver</span>;<br><br>
<span class="kw">public function</span> <span class="fn">boot</span>(): <span class="kw">void</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Daftarkan Observer untuk mengawasi siklus hidup model Portfolio:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">Portfolio</span>::<span class="fn">observe</span>(<span class="cls">PortfolioObserver</span>::<span class="kw">class</span>);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Atau di Laravel 11/12 bisa menggunakan PHP 8 Attribute di atas class Portfolio:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// #[ObservedBy(PortfolioObserver::class)]</span><br>
}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF EVENT BUS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-purple me-2" style="color:#c084fc;"></i>Simulator Interaktif: Sinyal Pulsa Event Bus &amp; Pemicu Observer</span>
            <span class="badge" style="background:#8b5cf6;">Live Event Flow</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h6 class="fw-bold text-white mb-2">Pilih Aksi Model:</h6>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-outline-primary btn-sm fw-bold py-2 text-start" onclick="triggerEventPulse('create')">
                            <i class="bi bi-plus-circle me-1"></i> Portfolio::create()
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Sinyal: saving &rarr; creating &rarr; created</span>
                        </button>
                        <button class="btn btn-outline-warning btn-sm fw-bold py-2 text-start" onclick="triggerEventPulse('update')">
                            <i class="bi bi-pencil-square me-1"></i> $portfolio->update()
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Sinyal: saving &rarr; updating &rarr; updated</span>
                        </button>
                        <button class="btn btn-outline-danger btn-sm fw-bold py-2 text-start" onclick="triggerEventPulse('delete')">
                            <i class="bi bi-trash3 me-1"></i> $portfolio->delete()
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Sinyal: deleting &rarr; deleted</span>
                        </button>
                    </div>

                    <div class="p-3 bg-dark rounded-3 border border-secondary text-secondary small">
                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-lightbulb text-warning me-1"></i>Amati Proses Ini:</h6>
                        Ketika pulsa mencapai terminal akhir (*created/updated*), class `PortfolioObserver` terbangun secara otomatis di latar belakang untuk menulis ke tabel `activity_logs`.
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Lifecycle Bus Visual Track -->
                    <div class="p-3 bg-black rounded-3 border border-secondary mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small fw-bold text-muted font-monospace" style="font-size:0.75rem;">
                                <i class="bi bi-cpu text-info me-1"></i>ELOQUENT DISPATCHER BUS
                            </span>
                            <span class="badge bg-secondary font-monospace" style="font-size:0.68rem;" id="eventActiveState">IDLE</span>
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
                    <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 100px;" id="simObserverConsole">
                        <span class="text-muted">// Klik tombol aksi model di sebelah kiri untuk melihat pulsa sinyal event...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.5') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 5: Accessors &amp; Mutators
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.7') }}" class="btn text-white fw-bold" style="background-color: #8b5cf6;">
                Topik 7: Pipeline Middleware <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
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
</script>
@endverbatim
@endpush
@endsection
