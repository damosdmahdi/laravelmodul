@extends('layouts.belajar')

@section('title', 'Topik 7: Pipeline Middleware & Arsitektur Lapis Bawang - Belajar Laravel SMK')

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

    /* Onion Concentric Rings */
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

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('belajar.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('belajar.materi.lanjutan') }}" class="text-decoration-none">Materi Lanjutan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Topik 7: Pipeline Middleware</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-secondary text-white px-3 py-1">Topik 7 dari 7 &bull; Penutup</span>
            <span class="badge bg-dark border border-secondary text-light">HTTP Pipeline Architecture</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 6px solid #64748b;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-shield-shaded text-warning me-2"></i>Pipeline Middleware (Arsitektur Lapis Bawang)
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Bagaimana setiap request HTTP disaring melalui lapisan-lapisan konsentris sebelum diizinkan menyentuh Controller, serta cara kerja sesi otentikasi login admin.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan.6') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-arrow-left me-1"></i> Topik 6
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-primary btn-sm fw-bold">
                        <i class="bi bi-check2-all me-1"></i> Selesai (Kembali ke Silabus)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TEORI & PENJELASAN LAPIS BAWANG -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-secondary mb-3">
                    <i class="bi bi-layers-half me-2"></i>Konsep "The Onion Architecture" di Laravel
                </h5>
                <p class="text-secondary small mb-3">
                    Banyak pemula mengira bahwa ketika pengguna mengetik URL di browser, permintaan langsung mendarat di method Controller. Di Laravel, request harus menembus **3 Tingkat Lapisan Pelindung**:
                </p>
                <ol class="small text-secondary ps-3 mb-3">
                    <li class="mb-2"><strong>Lapis 1 (Global Middleware):</strong> Berjalan untuk SETIAP request web maupun API. Contoh: <code>TrimStrings</code> memotong spasi liar form, dan <code>CheckForMaintenanceMode</code> memblokir akses saat website sedang diperbaiki.</li>
                    <li class="mb-2"><strong>Lapis 2 (Web Middleware Group):</strong> Mengaktifkan fitur peramban web: mendekripsi cookie, membaca sesi login <code>StartSession</code>, dan memverifikasi token <code>VerifyCsrfToken</code>.</li>
                    <li class="mb-0"><strong>Lapis 3 (Route Auth Guard):</strong> Mengevaluasi izin akses pengguna. Jika sesi tidak ada, request ditolak seketika sebelum Controller dijalankan!</li>
                </ol>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-success mb-3">
                    <i class="bi bi-shield-check me-2"></i>Sebelum vs Sesudah ($next Closure)
                </h5>
                <p class="text-secondary small mb-3">
                    Di dalam file middleware, developer mengontrol alur menggunakan closure <code>$next($request)</code>:
                </p>
                <div class="p-2 bg-light rounded-3 border border-secondary mb-3 font-monospace small" style="font-size:0.75rem;">
                    // BEFORE MIDDLEWARE (Cek Izin Sebelum Masuk):<br>
                    if (!session()->has('admin')) { return redirect('/login'); }<br>
                    return $next($request);<br><br>
                    // AFTER MIDDLEWARE (Manipulasi Respon Sebelum Balik ke Browser):<br>
                    $response = $next($request);<br>
                    $response->header('Cache-Control', 'no-store');<br>
                    return $response;
                </div>
                <p class="small text-secondary mb-0">
                    Ini menjamin keamanan terpusat: logika pengecekan login tidak perlu ditulis berulang-ulang di dalam setiap method Controller.
                </p>
            </div>
        </div>
    </div>

    <!-- KODE ASLI LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Penerapan Kode Asli Middleware di Laravel</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="topic7Tabs">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab7Middleware">
                        <i class="bi bi-shield-lock text-primary me-1"></i>app/Http/Middleware/EnsureUkkAdmin.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab7Routes">
                        <i class="bi bi-signpost text-warning me-1"></i>routes/web.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="topic7TabsContent">
                <div class="tab-pane fade show active" id="tab7Middleware">
                    <div class="code-box-header">
                        <span><i class="bi bi-shield-lock me-1"></i>MIDDLEWARE PENJAGA GERBANG ADMIN</span>
                        <span class="badge bg-primary">app/Http/Middleware/EnsureUkkAdmin.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">namespace</span> App\Http\Middleware;<br><br>
<span class="kw">use</span> Closure;<br>
<span class="kw">use</span> Illuminate\Http\<span class="cls">Request</span>;<br>
<span class="kw">use</span> Symfony\Component\HttpFoundation\<span class="cls">Response</span>;<br><br>
<span class="kw">class</span> <span class="cls">EnsureUkkAdmin</span><br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">handle</span>(<span class="cls">Request</span> <span class="var">$request</span>, <span class="cls">Closure</span> <span class="var">$next</span>): <span class="cls">Response</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;{<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Periksa apakah session login admin tersimpan di server:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (!<span class="fn">session</span>()-&gt;<span class="fn">has</span>(<span class="str">'ukk_admin_id'</span>)) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Tolak akses & pantulkan kembali ke halaman login:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">redirect</span>()-&gt;<span class="fn">route</span>(<span class="str">'ukk.admin.login'</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">with</span>(<span class="str">'error'</span>, <span class="str">'Akses ditolak! Silakan login terlebih dahulu.'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Jika sesi sah, izinkan request menembus ke Controller:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="var">$next</span>(<span class="var">$request</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
}
                    </div>
                </div>

                <div class="tab-pane fade" id="tab7Routes">
                    <div class="code-box-header">
                        <span><i class="bi bi-signpost me-1"></i>MEMBUNGKUS GRUP RUTE PRIVAT</span>
                        <span class="badge bg-warning text-dark">routes/web.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="cm">// Grup Rute Dashboard Admin yang Dilindungi Middleware:</span><br>
Route::<span class="fn">prefix</span>(<span class="str">'ukk/admin'</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">name</span>(<span class="str">'ukk.admin.'</span>)<br>
&nbsp;&nbsp;&nbsp;&nbsp;-&gt;<span class="fn">group</span>(<span class="kw">function</span> () {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 1. Rute Publik (Tamu Boleh Masuk untuk Login)</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Route::<span class="fn">get</span>(<span class="str">'/login'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'adminLogin'</span>])-&gt;<span class="fn">name</span>(<span class="str">'login'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Route::<span class="fn">post</span>(<span class="str">'/login'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'adminLoginProcess'</span>]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 2. Rute Privat Terproteksi Middleware:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Route::<span class="fn">get</span>(<span class="str">'/'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'adminDashboard'</span>])-&gt;<span class="fn">name</span>(<span class="str">'dashboard'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Route::<span class="fn">post</span>(<span class="str">'/portfolios'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'storePortfolio'</span>])-&gt;<span class="fn">name</span>(<span class="str">'portfolios.store'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Route::<span class="fn">post</span>(<span class="str">'/logout'</span>, [UkkController::<span class="kw">class</span>, <span class="str">'adminLogout'</span>])-&gt;<span class="fn">name</span>(<span class="str">'logout'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;});
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF ONION PENETRATOR -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-secondary me-2"></i>Simulator Interaktif: Proyektil Request Menembus Lapisan Middleware</span>
            <span class="badge bg-secondary">Onion Inspector</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <h6 class="fw-bold text-white mb-2">Simulasikan Status Pengunjung:</h6>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-outline-danger fw-bold py-2 text-start" onclick="shootMiddlewareRequest(false)">
                            <i class="bi bi-person-x me-1"></i> Tamu Asing (Tanpa Sesi Login)
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Akan dipantulkan di Lapis 3 (HTTP 302)</span>
                        </button>
                        <button class="btn btn-outline-success fw-bold py-2 text-start" onclick="shootMiddlewareRequest(true)">
                            <i class="bi bi-person-check me-1"></i> Admin Sah (Memiliki Sesi Login)
                            <span class="d-block small text-muted font-monospace" style="font-size:0.7rem;">Menembus sampai ke Core Controller (HTTP 200)</span>
                        </button>
                    </div>

                    <div class="p-3 bg-dark rounded-3 border border-secondary text-secondary small">
                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-lightbulb text-warning me-1"></i>Amati Proyektil Orb:</h6>
                        Perhatikan bagaimana proyektil request biru meluncur menembus Lapis 1 &rarr; Lapis 2 &rarr; Lapis 3. Jika ditolak, proyektil memantul merah; jika lolos, proyektil mendarat di inti controller hijau.
                    </div>
                </div>

                <div class="col-lg-7">
                    <!-- Concentric Onion Rings -->
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
                    <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 95px;" id="simOnionConsole">
                        <span class="text-muted">// Klik tombol Tamu Asing atau Admin Sah di sebelah kiri untuk menembakkan request...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.6') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 6: Model Observers
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-check2-all me-1"></i> Selesai: Kembali ke Menu Silabus
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
    function shootMiddlewareRequest(isAuthenticated) {
        const bullet = document.getElementById('requestBullet');
        const consoleEl = document.getElementById('simOnionConsole');
        const ringG = document.getElementById('ringGlobal');
        const ringW = document.getElementById('ringWeb');
        const ringA = document.getElementById('ringAuth');
        const ringC = document.getElementById('ringCore');

        bullet.style.top = '15px';
        bullet.style.backgroundColor = '#38bdf8';
        bullet.style.boxShadow = '0 0 12px #38bdf8';
        ringA.style.backgroundColor = 'rgba(245, 158, 11, 0.15)';
        ringA.style.borderColor = '#f59e0b';
        consoleEl.innerHTML = '<span class="text-info">[HTTP INCOMING] Permintaan GET /ukk/admin masuk ke kernel aplikasi...</span><br>';

        setTimeout(() => {
            bullet.style.top = '55px';
            ringG.style.borderColor = '#10b981';
            consoleEl.innerHTML += '<span class="text-secondary">[LAPIS 1: GLOBAL] TrimStrings & CheckMaintenance lolos validasi.</span><br>';

            setTimeout(() => {
                bullet.style.top = '95px';
                ringW.style.borderColor = '#10b981';
                consoleEl.innerHTML += '<span class="text-secondary">[LAPIS 2: WEB GROUP] Cookie sesi didekripsi & Token CSRF valid.</span><br>';

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
</script>
@endverbatim
@endpush
@endsection
