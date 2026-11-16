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
                    Membantu siswa SMK kelas 10, 11 &amp; 12 memahami pola pikir <strong>MVC (Model-View-Controller)</strong>, siklus request-response, keamanan siber, dan persiapan <strong>Uji Kompetensi Keahlian (UKK) 2026/2027: Platform Web Portofolio UMKM</strong>.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('belajar.ukk.panduan') }}" class="btn btn-warning text-dark px-4 fw-bold shadow-sm">
                        <i class="bi bi-mortarboard-fill me-1"></i> Materi Soal UKK 2026/2027 (Kelas 12)
                    </a>
                    <a href="{{ route('belajar.modul2') }}" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-diagram-3-fill me-1"></i> Coba Simulator Alur MVC
                    </a>
                    <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-warning px-4 fw-semibold">
                        <i class="bi bi-tools me-1"></i> Kasus Inventaris Lab
                    </a>
                    <button class="btn btn-outline-light px-3" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                        <i class="bi bi-person-badge me-1"></i> Atur Identitas
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
                        <strong>Peran / Target:</strong>
                        <div class="text-success fw-bold" id="cardStudentRole">Peserta UKK RPL</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANNER KHUSUS: UJI KOMPETENSI KEAHLIAN (UKK) 2026/2027 KELAS 12 -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #7c2d12 0%, #451a03 100%); border-left: 6px solid #f59e0b;">
        <div class="card-body p-4">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1">SOAL PRAKTIK KEJURUAN RESMI</span>
                        <span class="badge bg-danger">KELAS 12 SMK</span>
                    </div>
                    <h4 class="fw-bold mb-1 text-white">
                        <i class="bi bi-shop text-warning me-2"></i>Platform Web Portofolio UMKM (Model Done-For-You)
                    </h4>
                    <p class="text-light text-opacity-80 small mb-0">
                        Materi persiapan UKK RPL: Single-door Dashboard Admin, Validasi Slug URL real-time, Publish/Draft, Audit Log Aktivitas, Halaman Landing Page Publik 1-Halaman, dan Penanganan Notifikasi 404.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                        <a href="{{ route('belajar.ukk.panduan') }}" class="btn btn-warning text-dark fw-bold btn-sm px-3 py-2 shadow-sm">
                            <i class="bi bi-book-half me-1"></i> Buka Panduan &amp; ERD
                        </a>
                        <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-light btn-sm px-3 py-2 fw-bold shadow-sm">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                        </a>
                        <a href="{{ route('belajar.ukk.uji') }}" class="btn btn-outline-light btn-sm px-3 py-2">
                            <i class="bi bi-check2-all me-1"></i> 5 Skenario Uji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 FITUR UTAMA PORTAL -->
    <div class="row g-4 mb-5">
        <!-- PILAR 1 -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-cpu-fill me-2"></i>1. Simulator & Animasi Folder</h6>
                    <span class="badge bg-white text-primary fw-bold">Modul 1-6</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">
                        Eksplorasi folder VS Code interaktif yang terbuka satu per satu secara otomatis saat request dijalankan.
                    </p>
                    <ul class="list-unstyled mb-4 small">
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Visual Explorer ala VS Code</li>
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Live Trace Log File yang di-HIT</li>
                        <li class="py-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Simulator Skenario 404 Error</li>
                    </ul>
                    <a href="{{ route('belajar.modul2') }}" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                        Buka Simulator Alur MVC <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- PILAR 2: AUTOCHECKER TUGAS SISWA -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden border-2 border-success">
                <div class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-patch-check-fill me-2"></i>2. Autochecker Tugas Siswa</h6>
                    <span class="badge bg-white text-success fw-bold">Folder tugas-siswa</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">
                        Sistem otomatis memeriksa file yang dibuat siswa di folder <code>tugas-siswa/</code> dan memberi skor instan (0-100).
                    </p>
                    <ul class="list-unstyled mb-4 small">
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Pindai Route, Controller & Model</li>
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Verifikasi @csrf, Layout & Migrasi</li>
                        <li class="py-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Salin Rapor Nilai Otomatis ke Guru</li>
                    </ul>
                    <a href="{{ route('tugas.index') }}" class="btn btn-success btn-sm w-100 fw-bold text-white">
                        <i class="bi bi-patch-check me-1"></i> Buka Pemeriksa Tugas <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- PILAR 3: SISTEM LAB INVENTARIS LENGKAP -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>3. Sistem Lab Inventaris</h6>
                    <span class="badge bg-dark text-white fw-bold">Praktikum Nyata</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">
                        Aplikasi inventaris sekolah dengan fitur nyata: pencarian, peminjaman alat, tong sampah, cetak laporan resmi, dan RESTful API.
                    </p>
                    <ul class="list-unstyled mb-4 small">
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Transaksi Peminjaman Alat Lab</li>
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Proteksi Data: Soft Deletes &amp; Restore</li>
                        <li class="py-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Cetak Berita Acara &amp; RESTful API Docs</li>
                    </ul>
                    <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning text-dark btn-sm w-100 fw-bold">
                        Buka Sistem Lab Inventaris <i class="bi bi-arrow-right ms-1"></i>
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

    <!-- BANNER KHUSUS: LABORATORIUM KEAMANAN WEB (6 TIPE KEAMANAN INDUSTRI) -->
    <div class="card border-0 rounded-4 shadow-sm p-4 text-white mt-4" style="background: linear-gradient(135deg, #881337 0%, #4c0519 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 bg-danger bg-opacity-25 border border-danger border-opacity-50 px-3 py-1 rounded-pill small mb-2">
                    <i class="bi bi-shield-fill-check text-warning"></i>
                    <span class="text-white fw-bold">Standar Keamanan Siber SMK &amp; Industri</span>
                </div>
                <h4 class="fw-bold mb-1"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Laboratorium Keamanan Web Laravel (6 Tipe Keamanan)</h4>
                <p class="text-white text-opacity-75 small mb-0">
                    Pelajari teknik pengamanan aplikasi yang wajib diketahui programmer: <strong>Role-Based Access Control (RBAC 403)</strong>, <strong>Rate Limiting / Throttle (Anti-Brute Force 429)</strong>, <strong>Bcrypt Password Hashing</strong>, <strong>XSS Sanitizer</strong>, <strong>Mass Assignment ($fillable)</strong>, dan <strong>Soft Deletes Data Integrity</strong>.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('belajar.keamanan') }}" class="btn btn-warning text-dark fw-bold px-4 py-2 shadow-sm">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Buka Lab Keamanan <i class="bi bi-arrow-right ms-1"></i>
                </a>
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
