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

        <!-- PILAR 3: STUDI KASUS & TIM -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-cone-striped me-2"></i>3. Kasus Lab & Kerja Tim</h6>
                    <span class="badge bg-dark text-white fw-bold">Praktikum</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">
                        Studi kasus aplikasi Inventaris Lab SMK dan simulasi kerja kelompok 2 siswa (Siswa A vs B) mengatasi *merge conflict*.
                    </p>
                    <ul class="list-unstyled mb-4 small">
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Identitas & Watermark Siswa</li>
                        <li class="py-1 border-bottom"><i class="bi bi-check-circle-fill text-success me-1"></i> Checklist 3 Misi Perbaikan</li>
                        <li class="py-1"><i class="bi bi-check-circle-fill text-success me-1"></i> Simulator Konflik Kode Git</li>
                    </ul>
                    <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-warning text-dark btn-sm w-100 fw-semibold">
                        Buka Studi Kasus Lab <i class="bi bi-arrow-right ms-1"></i>
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
