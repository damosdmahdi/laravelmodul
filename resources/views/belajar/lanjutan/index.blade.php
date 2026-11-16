@extends('layouts.belajar')

@section('title', 'Silabus Materi Lanjutan: 7 Konsep Inti Arsitektur Laravel Modern - Belajar Laravel SMK')

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('belajar.index') }}" class="text-decoration-none"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Materi Lanjutan</li>
        </ol>
    </nav>

    <!-- HERO HEADER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-5 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border-left: 6px solid #6366f1;">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge text-white fw-bold px-3 py-1" style="background-color: #6366f1;">
                            <i class="bi bi-stars me-1"></i>KURIKULUM MENENGAH &bull; MAHIR
                        </span>
                        <span class="badge bg-secondary">Tingkat Lanjut RPL</span>
                    </div>
                    <h2 class="fw-bold mb-2 text-white">
                        7 Konsep Inti Arsitektur Laravel Modern
                    </h2>
                    <p class="text-light text-opacity-80 mb-3 fs-6">
                        Setiap topik di bawah ini disusun dalam <strong>halaman mandiri terpisah</strong> agar siswa dan guru dapat fokus mendalami konsep, melihat struktur kode asli di file Laravel, serta menjalankan simulator interaktif dengan visualisasi mekanikal mesin internal framework.
                    </p>
                    <div class="d-flex flex-wrap gap-2 text-muted small">
                        <span><i class="bi bi-check2-circle text-success me-1"></i>Penjelasan Kode Nyata</span>
                        <span class="mx-1">&bull;</span>
                        <span><i class="bi bi-play-circle text-warning me-1"></i>Simulator Visual Interaktif</span>
                        <span class="mx-1">&bull;</span>
                        <span><i class="bi bi-shield-check text-info me-1"></i>Best Practice Industri</span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="bg-dark bg-opacity-60 p-3 rounded-3 border border-secondary border-opacity-25 text-start">
                        <h6 class="fw-bold text-warning mb-2"><i class="bi bi-info-circle-fill me-1"></i>Cara Belajar:</h6>
                        <p class="small text-light opacity-75 mb-0">
                            Pilihlah topik satu per satu secara berurutan mulai dari Topik 1 hingga Topik 7. Setiap halaman memiliki visualisasi alur data dan potongan kode asli dari aplikasi produksi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR 7 TOPIK (CARD GRID DENGAN PREVIEW) -->
    <div class="row g-4 mb-5">

        <!-- TOPIK 1 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-primary fw-bold">TOPIK 1 DARI 7</span>
                    <i class="bi bi-link-45deg fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Route Model Binding &amp; SEO Slugs</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Membedah cara kerja rute custom key <code>{portfolio:slug}</code> di Laravel. Dilengkapi simulator scanner laser baris database dan penanganan otomatis 404 tanpa menyentuh controller.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>routes/web.php</code> &bull; <code>UkkController.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.1') }}" class="btn btn-primary fw-bold w-100 py-2">
                        Buka Halaman Topik 1 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark text-warning fw-bold">TOPIK 2 DARI 7</span>
                    <i class="bi bi-lightning-charge-fill fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Relasi Eloquent &amp; Bahaya N+1 Query</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Mempelajari penyebab server database tumbang akibat pemanggilan relasi di dalam perulangan Blade, serta solusi Eager Loading <code>with()</code> yang hanya mengirim 2 query SQL.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>Portfolio.php</code> &bull; <code>PortfolioProduct.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.2') }}" class="btn btn-warning text-dark fw-bold w-100 py-2">
                        Buka Halaman Topik 2 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header bg-info text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark text-info fw-bold">TOPIK 3 DARI 7</span>
                    <i class="bi bi-hdd-network-fill fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Storage Symlink &amp; Validasi Upload</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Mengapa file pengguna dilarang di-upload ke <code>public/</code>. Menjelajahi konsep Symbolic Link OS Unix melalui perintah sakti <code>php artisan storage:link</code>.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>config/filesystems.php</code> &bull; <code>UkkController.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.3') }}" class="btn btn-info text-dark fw-bold w-100 py-2">
                        Buka Halaman Topik 3 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 4 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-success fw-bold">TOPIK 4 DARI 7</span>
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Database Transactions (ACID)</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Prinsip atomik "All or Nothing". Mempelajari bagaimana membungkus operasi multi-tabel (Toko + Produk + Log) sehingga jika terjadi error, database di-rollback bersih 100%.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>DB::transaction()</code> &bull; <code>ActivityLog.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.4') }}" class="btn btn-success fw-bold w-100 py-2">
                        Buka Halaman Topik 4 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 5 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative border-primary" style="border: 2px solid #ef4444 !important;">
                <div class="card-header bg-danger text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-danger fw-bold">TOPIK 5 DARI 7 &bull; FOKUS KHUSUS</span>
                    <i class="bi bi-magic fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Accessors, Mutators &amp; Attribute Casting</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Clean Architecture Model: Melihat kode asli pembuatan URL WhatsApp otomatis dari nomor telepon dan pemformatan mata uang Rupiah serta casting JSON di Model.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>Portfolio.php</code> &bull; <code>portfolio.blade.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.5') }}" class="btn btn-danger fw-bold w-100 py-2 shadow-sm">
                        Buka Halaman Topik 5 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 6 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header text-white py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: #8b5cf6;">
                    <span class="badge bg-white text-purple fw-bold" style="color:#8b5cf6;">TOPIK 6 DARI 7</span>
                    <i class="bi bi-eye-fill fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Model Observers &amp; Lifecycle Events</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Audit trail otomatis: Mendengarkan sinyal lifecycle model (<code>created</code>, <code>updated</code>, <code>deleted</code>) untuk mencatat log riwayat tanpa mengotori setiap baris Controller.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>PortfolioObserver.php</code> &bull; <code>ActivityLog.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.6') }}" class="btn text-white fw-bold w-100 py-2" style="background-color: #8b5cf6;">
                        Buka Halaman Topik 6 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOPIK 7 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-header bg-secondary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="badge bg-white text-secondary fw-bold">TOPIK 7 DARI 7</span>
                    <i class="bi bi-shield-shaded fs-4"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-2">Pipeline Middleware (Arsitektur Lapis Bawang)</h5>
                    <p class="text-secondary small mb-3 flex-grow-1">
                        Membedah bagaimana setiap request HTTP difilter lapis demi lapis (TrimStrings &rarr; CSRF &rarr; Sesi Cookie &rarr; Custom Auth Guard) sebelum diizinkan menyentuh Controller inti.
                    </p>
                    <div class="bg-light p-2 rounded-3 small mb-3 font-monospace" style="font-size:0.75rem;">
                        <span class="text-muted">File:</span> <code>EnsureUkkAdmin.php</code> &bull; <code>bootstrap/app.php</code>
                    </div>
                    <a href="{{ route('belajar.materi.lanjutan.7') }}" class="btn btn-secondary fw-bold w-100 py-2">
                        Buka Halaman Topik 7 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
