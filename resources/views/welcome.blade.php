<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starter Kit Laravel SMK - Inventaris Lab</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .hero-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4ebd 100%);
            color: white;
            border-radius: 1rem;
        }
        .step-badge {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>Eskul Web SMK &bull; Fundamental Laravel
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Laravel {{ Illuminate\Foundation\Application::VERSION }}</span>
                <span class="badge bg-info text-dark">PHP {{ PHP_VERSION }}</span>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- HERO SECTION -->
        <div class="hero-banner p-4 p-md-5 mb-4 shadow-sm">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-warning text-dark mb-2 px-3 py-2 fw-semibold">Kurikulum Materi 1 (Kelas 10 & 11)</span>
                    <h1 class="display-6 fw-bold">Starter Kit Pembelajaran Laravel</h1>
                    <p class="lead mb-3">
                        Proyek starter untuk simulasi pembuatan aplikasi <strong>"Sistem Inventaris Barang Lab SMK"</strong> (CRUD 1 Tabel Berbasis MVC & Kolaborasi GitHub).
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="/template-statis" class="btn btn-warning fw-semibold px-4">
                            <i class="bi bi-layout-text-window-reverse me-1"></i> Preview Template Statis
                        </a>
                        <a href="#silabus" class="btn btn-outline-light px-4">
                            <i class="bi bi-journal-text me-1"></i> Silabus 6 Modul
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-4 mt-lg-0">
                    <div class="bg-white text-dark p-3 rounded-3 shadow-sm text-start">
                        <h6 class="fw-bold mb-2 text-primary"><i class="bi bi-hdd-network me-1"></i> Status Lingkungan</h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="py-1 border-bottom">Database: <strong class="badge bg-secondary">{{ config('database.default') }}</strong></li>
                            <li class="py-1 border-bottom">App Environment: <strong class="text-success">{{ app()->environment() }}</strong></li>
                            <li class="py-1 border-bottom">App Debug: <strong>{{ config('app.debug') ? 'Aktif (Local)' : 'Nonaktif' }}</strong></li>
                            <li class="py-1">Base URL: <code>{{ config('app.url') }}</code></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 PANDUAN CEPAT SETUP SISWA -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="step-badge bg-primary text-white me-2">1</span>
                            <h6 class="card-title mb-0 fw-bold">Clone / Fork Repo</h6>
                        </div>
                        <p class="card-text text-muted small">
                            Siswa melakukan fork ke akun GitHub masing-masing lalu clone ke direktori lokal (misal: <code>git clone &lt;repo&gt;</code>).
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="step-badge bg-primary text-white me-2">2</span>
                            <h6 class="card-title mb-0 fw-bold">Hidupkan Proyek</h6>
                        </div>
                        <p class="card-text text-muted small">
                            Jalankan perintah standar:
                            <br><code>composer install</code>
                            <br><code>cp .env.example .env</code>
                            <br><code>php artisan key:generate</code>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="step-badge bg-primary text-white me-2">3</span>
                            <h6 class="card-title mb-0 fw-bold">Branching per Modul</h6>
                        </div>
                        <p class="card-text text-muted small">
                            Gunakan branch untuk setiap tugas:
                            <br><code>feat/blade-layout</code>
                            <br><code>feat/database-migration</code>
                            <br><code>feat/crud-create-read</code>
                            <br><code>feat/crud-update-delete</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL SILABUS MODUL -->
        <div class="card border-0 shadow-sm mb-4" id="silabus">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="bi bi-book-half text-primary me-2"></i>Rincian 6 Modul Praktikum (Tingkat Pemula)
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Modul</th>
                                <th>Topik Pembelajaran</th>
                                <th>Fokus Materi (Ramah Pemula)</th>
                                <th>Target Output Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-primary">Modul 1</td>
                                <td><strong>Pengenalan & Setup</strong></td>
                                <td>Analogi rumah (PHP Native = buat bata sendiri, Laravel = bata siap pasang), Composer, struktur folder, <code>php artisan serve</code>.</td>
                                <td><span class="badge bg-success">Proyek Berjalan di Lokal</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Modul 2</td>
                                <td><strong>Routing & Controller</strong></td>
                                <td>Alur MVC dasar (Browser &rarr; Route &rarr; Controller &rarr; View), perintah <code>php artisan make:controller</code>, kirim array data.</td>
                                <td><span class="badge bg-primary">Paham Alur Request</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Modul 3</td>
                                <td><strong>Blade Templating</strong></td>
                                <td>Sintaks Blade <code>@{{ $data }}</code>, <code>@@foreach</code>, <code>@@if</code>, dan Layouting (<code>@@extends</code>, <code>@@yield</code>, <code>@@section</code>).</td>
                                <td><span class="badge bg-info text-dark">Template HTML Dinamis</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Modul 4</td>
                                <td><strong>Database & Migration</strong></td>
                                <td>File <code>.env</code>, konsep migration sebagai version control skema DB di Git, <code>php artisan migrate</code>.</td>
                                <td><span class="badge bg-secondary">Tabel via Migration</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Modul 5</td>
                                <td><strong>Eloquent ORM (Read & Create)</strong></td>
                                <td>Model <code>php artisan make:model</code>, <code>Model::all()</code>, form input dengan proteksi wajib <code>@@csrf</code>, dan <code>Model::create()</code>.</td>
                                <td><span class="badge bg-warning text-dark">Form & Tampil Data</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Modul 6</td>
                                <td><strong>Penyelesaian CRUD & Validasi</strong></td>
                                <td>Pencarian data (<code>findOrFail</code>), Update (<code>PUT/PATCH</code>), Hapus (<code>DELETE</code>), dan <code>$request-&gt;validate()</code>.</td>
                                <td><span class="badge bg-success">Aplikasi CRUD Lengkap</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SIMULASI KERJA KELOMPOK GITHUB -->
        <div class="card border-0 shadow-sm bg-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-people-fill text-primary me-2"></i>Simulasi Kerja Kolaboratif (Tim 2 Orang)</h5>
                <p class="text-muted small">
                    Untuk melatih kerja tim industri dan simulasi penanganan <em>merge conflict</em>:
                </p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <h6 class="fw-bold text-success"><i class="bi bi-person-fill me-1"></i> Siswa A</h6>
                            <p class="small mb-1"><strong>Branch:</strong> <code>feat/create-read</code></p>
                            <p class="small text-muted mb-0">
                                Bertanggung jawab membuat form tambah data barang baru dan menampilkan daftar barang pada tabel utama.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <h6 class="fw-bold text-warning"><i class="bi bi-person-fill me-1"></i> Siswa B</h6>
                            <p class="small mb-1"><strong>Branch:</strong> <code>feat/update-delete</code></p>
                            <p class="small text-muted mb-0">
                                Bertanggung jawab membuat halaman edit form, logika update data spesifik, dan fitur hapus barang.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-secondary mt-3 mb-0 small">
                    <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                    <strong>Poin Belajar:</strong> Saat Siswa A dan B melakukan Pull Request dan merge ke branch <code>main</code>, mereka akan belajar mengatasi <em>merge conflict</em> ringan pada file <code>routes/web.php</code> dan Controller.
                </div>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-3 mt-5">
        <div class="container text-center text-muted small">
            &copy; 2026 Modul Fundamental Laravel SMK &bull; Disiapkan untuk Guru & Siswa Kelas 10 & 11
        </div>
    </footer>

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
