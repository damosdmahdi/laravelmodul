@extends('layouts.belajar')

@section('title', 'Dashboard Pembelajaran Laravel SMK - Kelas 10 & 11')

@section('content')
<div class="container py-4">

    <!-- HERO BANNER -->
    <div class="p-4 p-lg-5 mb-4 rounded-4 shadow-sm text-white" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 6px solid #ef4444;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-danger text-white mb-2 px-3 py-2 fw-semibold">
                    <i class="bi bi-mortarboard-fill me-1"></i> Kurikulum Eskul Pemrograman Web SMK
                </span>
                <h1 class="display-6 fw-extrabold mb-2 text-white">Platform Praktikum Interaktif Laravel</h1>
                <p class="lead text-light opacity-90 mb-4 fs-6">
                    Membantu siswa SMK kelas 10 & 11 memahami pola pikir <strong>MVC (Model-View-Controller)</strong>, siklus request-response, dan operasi dasar database melalui <strong>simulator interaktif visual</strong> serta studi kasus nyata <strong>Sistem Inventaris Lab</strong>.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('belajar.modul2') }}" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-diagram-3-fill me-1"></i> Coba Simulator Alur MVC
                    </a>
                    <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-warning px-4 fw-semibold">
                        <i class="bi bi-tools me-1"></i> Buka Tantangan Studi Kasus
                    </a>
                    <button class="btn btn-outline-light px-3" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                        <i class="bi bi-person-badge me-1"></i> Atur Identitas Pengerja
                    </button>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0 text-center">
                <!-- KARTU IDENTITAS SISWA AKTIF -->
                <div class="card border-0 shadow-lg text-dark text-start rounded-3 bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <span class="badge bg-primary">Kartu Siswa Aktif</span>
                        <a href="javascript:void(0)" class="text-decoration-none small text-muted" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                            <i class="bi bi-pencil-square"></i> Ubah
                        </a>
                    </div>
                    <h5 class="fw-bold mb-1 text-primary" id="cardStudentName">Nama Siswa</h5>
                    <p class="mb-2 text-muted small" id="cardStudentDetail">Kelas &bull; No. Absen</p>
                    <div class="p-2 rounded bg-light border small">
                        <strong>Peran Kelompok:</strong>
                        <div class="text-success fw-bold" id="cardStudentRole">Siswa A</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 PILAR UTAMA -->
    <div class="row g-4 mb-5">
        <!-- PILAR 1 -->
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cpu-fill me-2"></i>Pilar 1: Lab & Simulator Interaktif</h5>
                    <span class="badge bg-white text-primary fw-bold">Tempat Coba-coba</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted">
                        Di sini siswa bisa <strong>mengubah-ubah kode secara langsung</strong> dan melihat <strong>animasi alur request</strong>: file dan folder mana saja yang di-<em>hit</em> saat tombol diklik (Browser &rarr; Route &rarr; Controller &rarr; Model &rarr; View).
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="py-2 border-bottom d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> Animasi packet data visual berjalan antar folder.
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> Live Blade templating compiler.
                        </li>
                        <li class="py-2 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> Saklar simulasi error CSRF (Token mismatch 419).
                        </li>
                    </ul>
                    <a href="{{ route('belajar.modul2') }}" class="btn btn-outline-primary w-100 fw-semibold">
                        Mulai Eksplorasi Simulator <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- PILAR 2 -->
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cone-striped me-2"></i>Pilar 2: Studi Kasus Belum Sempurna</h5>
                    <span class="badge bg-dark text-white fw-bold">Tantangan Praktik</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted">
                        Halaman aplikasi <strong>"Inventaris Lab" yang sudah bisa dijalankan</strong>, namun sengaja dibuat <strong>belum sempurna</strong> (ada bug tantangan) untuk diperbaiki siswa sesuai modul.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="py-2 border-bottom d-flex align-items-center">
                            <i class="bi bi-pin-angle-fill text-warning me-2"></i> Dilengkapi <strong>Tanda Identitas Pengerja</strong> (Watermark Nama Siswa).
                        </li>
                        <li class="py-2 border-bottom d-flex align-items-center">
                            <i class="bi bi-pin-angle-fill text-warning me-2"></i> Checklist tugas perbaikan (Validasi form, CSRF, Edit PUT).
                        </li>
                        <li class="py-2 d-flex align-items-center">
                            <i class="bi bi-pin-angle-fill text-warning me-2"></i> Halaman simulasi kolaborasi tim 2 siswa (Merge Conflict).
                        </li>
                    </ul>
                    <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning w-100 fw-semibold text-dark">
                        Buka Halaman Studi Kasus <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 6 MODUL PEMBELAJARAN LENGKAP -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Rincian 6 Modul Interaktif Siswa</h4>
            <p class="text-muted small mb-0">Klik modul di bawah untuk langsung mencoba materi dan simulator koding</p>
        </div>
    </div>

    <div class="row g-3">
        <!-- MODUL 1 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary p-2 me-2"><i class="bi bi-folder2-open fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 1</span>
                            <h6 class="fw-bold mb-0">Peta Struktur Folder & Setup</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Analogi bangun rumah, pengenalan Composer, peta interaktif folder esensial, dan perintah <code>artisan serve</code>.
                    </p>
                    <a href="{{ route('belajar.modul1') }}" class="btn btn-sm btn-outline-primary w-100">
                        Buka Modul 1 &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- MODUL 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success p-2 me-2"><i class="bi bi-diagram-3-fill fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 2</span>
                            <h6 class="fw-bold mb-0">Simulator Alur MVC & Route</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Lacak alur request dari Browser &rarr; <code>routes/web.php</code> &rarr; Controller &rarr; View dengan animasi jalur menyala.
                    </p>
                    <a href="{{ route('belajar.modul2') }}" class="btn btn-sm btn-outline-success w-100">
                        Buka Modul 2 &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- MODUL 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-danger p-2 me-2"><i class="bi bi-filetype-html fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 3</span>
                            <h6 class="fw-bold mb-0">Blade Templating Studio</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Ubah kode blade dinamis (<code>&#64;foreach</code>, <code>&#64;if</code>) dan konsep Master Layout (<code>&#64;extends</code> & <code>&#64;yield</code>).
                    </p>
                    <a href="{{ route('belajar.modul3') }}" class="btn btn-sm btn-outline-danger w-100">
                        Buka Modul 3 &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- MODUL 4 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning text-dark p-2 me-2"><i class="bi bi-database-fill-gear fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 4</span>
                            <h6 class="fw-bold mb-0">Database & Migration</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Memahami <code>.env</code>, konsep migration sebagai version control skema DB di Git, dan perintah <code>artisan migrate</code>.
                    </p>
                    <a href="{{ route('belajar.modul4') }}" class="btn btn-sm btn-outline-warning text-dark w-100">
                        Buka Modul 4 &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- MODUL 5 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-info text-white p-2 me-2"><i class="bi bi-shield-lock-fill fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 5</span>
                            <h6 class="fw-bold mb-0">Eloquent ORM & Form CSRF</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Model <code>Item::create()</code>, <code>Item::all()</code>, dan uji coba saklar proteksi <code>&#64;csrf</code> (Error 419 Page Expired).
                    </p>
                    <a href="{{ route('belajar.modul5') }}" class="btn btn-sm btn-outline-info w-100">
                        Buka Modul 5 &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- MODUL 6 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-secondary p-2 me-2"><i class="bi bi-check-circle-fill fs-6"></i></span>
                        <div>
                            <span class="text-muted" style="font-size: 0.75rem;">MODUL 6</span>
                            <h6 class="fw-bold mb-0">Penyelesaian CRUD & Validasi</h6>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Pencarian data (<code>findOrFail</code>), Update (<code>PUT</code>), Hapus (<code>DELETE</code>), dan simulator proteksi input kosong.
                    </p>
                    <a href="{{ route('belajar.modul6') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Buka Modul 6 &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('studentIdentityLoaded', function(e) {
        const { name, kelas, absen, role } = e.detail;
        const nameEl = document.getElementById('cardStudentName');
        const detailEl = document.getElementById('cardStudentDetail');
        const roleEl = document.getElementById('cardStudentRole');

        if (nameEl) nameEl.textContent = name;
        if (detailEl) detailEl.textContent = `${kelas} • No. Absen ${absen}`;
        if (roleEl) roleEl.textContent = role;
    });
</script>
@endpush
