@extends('layouts.belajar')

@section('title', 'Topik 4: Database Transactions & ACID - Belajar Laravel SMK')

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

    /* Transaction Staging & Rollback */
    .tx-staging-box {
        background: #030712;
        border: 2px solid #374151;
        border-radius: 10px;
        padding: 14px;
        position: relative;
        overflow: hidden;
    }
    .tx-row-item {
        background: #111827;
        border: 1px solid #1f2937;
        border-radius: 6px;
        padding: 10px 14px;
        margin-bottom: 8px;
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
                <li class="breadcrumb-item active" aria-current="page">Topik 4: Database Transactions</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success text-white px-3 py-1">Topik 4 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">ACID Data Integrity</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%); border-left: 6px solid #10b981;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-arrow-repeat text-warning me-2"></i>Database Transactions (`DB::transaction`) - Integritas Data
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Prinsip atomik "All or Nothing". Memahami bagaimana membungkus operasi penyimpanan ke beberapa tabel sekaligus agar jika terjadi satu saja kegagalan, seluruh perubahan dibatalkan (Rollback) tanpa meninggalkan data korup.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan.3') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-arrow-left me-1"></i> Topik 3
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.5') }}" class="btn btn-success btn-sm fw-bold">
                        Lanjut ke Topik 5 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TEORI & PRINSIP ACID -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-database-x me-2"></i>Masalah Nyata: Bencana Data Menggantung (Orphan Records)
                </h5>
                <p class="text-secondary small mb-3">
                    Dalam proses bisnis pendaftaran UMKM, satu aksi tombol simpan harus menulis ke <strong>3 tabel berbeda</strong>:
                </p>
                <ol class="small text-secondary ps-3 mb-3">
                    <li class="mb-1">Tulis profil toko ke tabel <code>portfolios</code>.</li>
                    <li class="mb-1">Tulis 4 produk unggulan ke tabel <code>portfolio_products</code>.</li>
                    <li class="mb-1">Tulis log audit aktivitas ke tabel <code>activity_logs</code>.</li>
                </ol>
                <div class="alert alert-warning py-2 small mb-0">
                    <strong>SKENARIO TANPA TRANSACTION:</strong><br>
                    Jika langkah 1 sukses, tetapi di langkah 2 server kehabisan disk atau harga produk tidak valid, aplikasi melempar Error 500. Akibatnya: profil toko tersimpan, tapi produknya kosong dan rusak! Database menjadi kotor (*corrupt/orphan state*).
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-shield-check me-2"></i>Solusi: Prinsip ACID dengan `DB::transaction`
                </h5>
                <p class="text-secondary small mb-3">
                    Laravel menyediakan closure atomik yang sangat elegan:
                </p>
                <div class="p-3 bg-light rounded-3 border border-success mb-3 font-monospace small text-success" style="font-size:0.78rem;">
                    use Illuminate\Support\Facades\DB;<br><br>
                    DB::transaction(function () use ($request) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$toko = Portfolio::create([...]);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$toko->products()->createMany([...]);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;ActivityLog::create([...]);<br>
                    });
                </div>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-1"><strong>Atomicity:</strong> Semua langkah 1, 2, dan 3 dianggap sebagai satu kesatuan tunggal yang tak terpisahkan.</li>
                    <li class="mb-1"><strong>Auto-Rollback:</strong> Jika terjadi satu baris exception di dalam closure, Laravel otomatis mengeksekusi <code>ROLLBACK</code> ke database.</li>
                    <li class="mb-1"><strong>Commit Permanen:</strong> Hanya jika seluruh kode selesai tanpa error, perintah <code>COMMIT</code> dikirimkan.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- KODE ASLI LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Penerapan Kode Asli di Controller &amp; Penanganan Deadlock</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <div class="code-box-header">
                <span><i class="bi bi-cpu me-1"></i>METODE STORE DENGAN TRANSAKSI ATOMIK</span>
                <span class="badge bg-success">app/Http/Controllers/UkkController.php</span>
            </div>
            <div class="code-editor-body">
<span class="kw">use</span> Illuminate\Support\Facades\<span class="cls">DB</span>;<br><br>
<span class="kw">public function</span> <span class="fn">storePortfolio</span>(<span class="cls">Request</span> <span class="var">$request</span>)<br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$request</span>-&gt;<span class="fn">validate</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'nama_usaha'</span> =&gt; <span class="str">'required|string|max:255'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'slug'</span> =&gt; <span class="str">'required|string|unique:portfolios,slug'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'whatsapp'</span> =&gt; <span class="str">'required|string'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Membungkus multi-table write ke dalam transaksi atomik</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Parameter '5': Otomatis mencoba ulang 5 kali jika terjadi database deadlock antrian</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">DB</span>::<span class="fn">transaction</span>(<span class="kw">function</span> () <span class="kw">use</span> (<span class="var">$request</span>) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 1. Simpan data induk UMKM</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span> = <span class="cls">Portfolio</span>::<span class="fn">create</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'admin_id'</span> =&gt; <span class="fn">session</span>(<span class="str">'ukk_admin_id'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'nama_usaha'</span> =&gt; <span class="var">$request</span>-&gt;nama_usaha,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'slug'</span> =&gt; <span class="var">$request</span>-&gt;slug,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'whatsapp'</span> =&gt; <span class="var">$request</span>-&gt;whatsapp,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'status'</span> =&gt; <span class="var">$request</span>-&gt;status ?? <span class="str">'published'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 2. Simpan 4 produk bawaan melalui relasi hasMany</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span>-&gt;<span class="fn">products</span>()-&gt;<span class="fn">createMany</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<span class="str">'nama_produk'</span> =&gt; <span class="str">'Produk Unggulan 1'</span>, <span class="str">'harga'</span> =&gt; 25000],<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<span class="str">'nama_produk'</span> =&gt; <span class="str">'Produk Unggulan 2'</span>, <span class="str">'harga'</span> =&gt; 35000],<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 3. Catat rekam jejak audit trail</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">ActivityLog</span>::<span class="fn">create</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'admin_id'</span> =&gt; <span class="fn">session</span>(<span class="str">'ukk_admin_id'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'portfolio_id'</span> =&gt; <span class="var">$portfolio</span>-&gt;id,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'action'</span> =&gt; <span class="str">'CREATE'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'details'</span> =&gt; <span class="str">"Menambahkan portofolio {$portfolio->nama_usaha}"</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}, 5);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">redirect</span>()-&gt;<span class="fn">route</span>(<span class="str">'ukk.admin.dashboard'</span>)-&gt;<span class="fn">with</span>(<span class="str">'success'</span>, <span class="str">'Data tersimpan rapi!'</span>);<br>
}
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF STAGING BUFFER -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-success me-2"></i>Simulator Interaktif: Transaction Staging Sandbox (Commit vs Rollback)</span>
            <span class="badge bg-success">Live ACID Testing</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h6 class="fw-bold text-success mb-2">Pilih Skenario Eksekusi:</h6>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-outline-success fw-bold py-2 text-start" onclick="runMechanicalTxSimulation(true)">
                            <i class="bi bi-check2-circle me-1"></i> Skenario A: Sukses Semua
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Langkah 1 &rarr; 2 &rarr; 3 Berhasil (COMMIT)</span>
                        </button>
                        <button class="btn btn-outline-danger fw-bold py-2 text-start" onclick="runMechanicalTxSimulation(false)">
                            <i class="bi bi-x-octagon me-1"></i> Skenario B: Gagal di Langkah 2
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Error DB/Disk penuh (ROLLBACK)</span>
                        </button>
                    </div>

                    <div class="p-3 bg-dark rounded-3 border border-secondary text-secondary small">
                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-lightbulb text-warning me-1"></i>Perhatikan Mekanisme Ini:</h6>
                        Pada Skenario B, amati bagaimana langkah 1 yang tadinya sempat ditulis ke buffer memori akan **dicoret dan dibatalkan seketika oleh Rollback Sweeper**, sehingga database tetap bersih!
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Staging Box -->
                    <div class="tx-staging-box mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-muted font-monospace" style="font-size:0.75rem;">
                                <i class="bi bi-memory text-warning me-1"></i>TRANSACTION STAGING BUFFER (RAM MEMORY)
                            </span>
                            <span class="badge bg-secondary font-monospace" style="font-size:0.68rem;" id="txStateBadge">IDLE</span>
                        </div>

                        <div class="tx-row-item" id="txRow1">
                            <div class="d-flex justify-content-between small">
                                <span class="text-white fw-bold">1. INSERT INTO `portfolios`</span>
                                <span class="badge bg-secondary" id="badgeRow1">Waiting</span>
                            </div>
                            <span class="text-muted d-block" style="font-size:0.72rem;">Data: Toko Roti Manis (ID: 104)</span>
                        </div>

                        <div class="tx-row-item" id="txRow2">
                            <div class="d-flex justify-content-between small">
                                <span class="text-white fw-bold">2. INSERT INTO `portfolio_products`</span>
                                <span class="badge bg-secondary" id="badgeRow2">Waiting</span>
                            </div>
                            <span class="text-muted d-block" style="font-size:0.72rem;">Data: 4 Produk Roti Cokelat &amp; Keju</span>
                        </div>

                        <div class="tx-row-item" id="txRow3">
                            <div class="d-flex justify-content-between small">
                                <span class="text-white fw-bold">3. INSERT INTO `activity_logs`</span>
                                <span class="badge bg-secondary" id="badgeRow3">Waiting</span>
                            </div>
                            <span class="text-muted d-block" style="font-size:0.72rem;">Data: Rekam Jejak Admin Input Baru</span>
                        </div>
                    </div>

                    <!-- Terminal Output -->
                    <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 100px;" id="simTxConsole">
                        <span class="text-muted">// Klik tombol Skenario A atau B di sebelah kiri untuk melihat proses atomik...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.3') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 3: Storage &amp; Symlink
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.5') }}" class="btn btn-danger fw-bold">
                Topik 5: Accessors &amp; Mutators <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
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

        setTimeout(() => {
            r1.className = 'tx-row-item staged';
            b1.className = 'badge bg-warning text-dark';
            b1.innerText = 'Staged in RAM';
            consoleEl.innerHTML += '<span class="text-info">[STEP 1] INSERT `portfolios` (Toko Roti Manis) disimpan di staging buffer...</span><br>';

            setTimeout(() => {
                if (isSuccess) {
                    r2.className = 'tx-row-item staged';
                    b2.className = 'badge bg-warning text-dark';
                    b2.innerText = 'Staged in RAM';
                    consoleEl.innerHTML += '<span class="text-info">[STEP 2] INSERT 4 `portfolio_products` berhasil ditulis ke buffer...</span><br>';

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
</script>
@endverbatim
@endpush
@endsection
