<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Belajar Laravel SMK - Kelas 10 & 11')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-code: 'Fira Code', monospace;
        }
        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #f8fafc;
            color: #1e293b;
        }
        .code-font {
            font-family: var(--font-code);
        }
        /* Navbar styling */
        .navbar-brand-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        /* Identity Card in Header */
        .identity-badge {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            padding: 6px 14px;
            border-radius: 50rem;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .identity-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
        /* Animated Pipeline Nodes */
        .pipeline-node {
            border: 2px solid #e2e8f0;
            background: #ffffff;
            border-radius: 12px;
            padding: 16px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .pipeline-node.active-hit {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), 0 10px 15px -3px rgba(59, 130, 246, 0.1);
            transform: translateY(-4px) scale(1.02);
        }
        .pipeline-node.success-hit {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        }
        .pipeline-node.error-hit {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
        }
        /* Pulsing packet animation */
        @keyframes pulseDataPacket {
            0% { transform: scale(0.9); opacity: 0.6; }
            50% { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 8px #38bdf8); }
            100% { transform: scale(0.9); opacity: 0.6; }
        }
        .data-packet {
            animation: pulseDataPacket 1.5s infinite;
        }
        /* Code Box */
        .code-box {
            background: #0f172a;
            color: #e2e8f0;
            border-radius: 10px;
            font-family: var(--font-code);
            font-size: 0.88rem;
            line-height: 1.6;
            position: relative;
            overflow-x: auto;
        }
        .code-box .token-keyword { color: #f43f5e; font-weight: 600; }
        .code-box .token-class { color: #38bdf8; font-weight: 600; }
        .code-box .token-string { color: #a3e635; }
        .code-box .token-comment { color: #64748b; font-style: italic; }
        .code-box .token-var { color: #fbbf24; }

        /* Watermark Tag for Student Work */
        .student-watermark {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px dashed #3b82f6;
            border-radius: 12px;
            padding: 12px 18px;
        }

        /* Majastic Studio Brand Badge & Footer */
        .majastic-brand-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.85);
        }
        .majastic-brand-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4) !important;
            border-color: #fbbf24 !important;
        }
        .hover-white {
            transition: color 0.2s ease;
        }
        .hover-white:hover {
            color: #ffffff !important;
            text-decoration: underline !important;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-2">
        <div class="container-fluid px-lg-4">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white" href="{{ route('home') }}">
                <span class="navbar-brand-badge"><i class="bi bi-fire me-1"></i>LARAVEL SMK</span>
                <span class="fs-6 d-none d-sm-inline">Portal Belajar & Lab Praktikum</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('belajar.index') ? 'active text-primary fw-semibold' : '' }}" href="{{ route('belajar.index') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Modul
                        </a>
                    </li>
                    <!-- Dropdown Modul -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('belajar/modul*') || request()->routeIs('belajar.keamanan*') ? 'active text-primary fw-semibold' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-cpu me-1"></i> Modul &amp; Keamanan
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul1') }}"><i class="bi bi-folder2-open text-primary me-2"></i>Modul 1: Peta Folder &amp; Setup</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul2') }}"><i class="bi bi-diagram-3 text-success me-2"></i>Modul 2: Simulator Alur MVC &amp; Route</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul3') }}"><i class="bi bi-filetype-html text-danger me-2"></i>Modul 3: Blade Templating Studio</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul4') }}"><i class="bi bi-database text-warning me-2"></i>Modul 4: Database &amp; Migration</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul5') }}"><i class="bi bi-shield-check text-info me-2"></i>Modul 5: Eloquent &amp; Form CSRF</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('belajar.modul6') }}"><i class="bi bi-check2-all text-secondary me-2"></i>Modul 6: CRUD &amp; Validasi Form</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 fw-bold text-warning" href="{{ route('belajar.materi.lanjutan') }}">
                                    <i class="bi bi-stars text-warning me-2"></i>Materi Lanjutan: 7 Konsep Inti Laravel
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 fw-bold text-danger" href="{{ route('belajar.keamanan') }}">
                                    <i class="bi bi-shield-lock-fill text-danger me-2"></i>Laboratorium Keamanan Web (6 Tipe)
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('belajar/materi-lanjutan*') ? 'active text-warning fw-bold' : 'text-light' }}" href="{{ route('belajar.materi.lanjutan') }}">
                            <i class="bi bi-stars text-warning me-1"></i> Materi Lanjutan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tugas.*') ? 'active text-success fw-bold' : 'text-light' }}" href="{{ route('tugas.index') }}">
                            <i class="bi bi-patch-check-fill text-success me-1"></i> Autochecker Tugas
                        </a>
                    </li>
                    <!-- Dropdown Studi Kasus Lab Inventaris -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('lab-kasus*') ? 'active text-warning fw-semibold' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tools text-warning me-1"></i> Sistem Lab Inventaris
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item py-2" href="{{ route('lab-kasus.index') }}"><i class="bi bi-box-seam text-warning me-2"></i>Daftar Barang Inventaris</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('lab-kasus.peminjaman.index') }}"><i class="bi bi-arrow-left-right text-primary me-2"></i>Peminjaman Alat Lab</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('lab-kasus.trash') }}"><i class="bi bi-trash3 text-danger me-2"></i>Tong Sampah (Soft Deletes)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="{{ route('lab-kasus.laporan') }}"><i class="bi bi-printer text-success me-2"></i>Cetak Rekap Laporan Resmi</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('lab-kasus.api-docs') }}"><i class="bi bi-code-slash text-info me-2"></i>Dokumentasi RESTful API</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('belajar.keamanan') ? 'active text-danger fw-bold' : 'text-danger-subtle' }}" href="{{ route('belajar.keamanan') }}">
                            <i class="bi bi-shield-fill-exclamation text-danger me-1"></i> Lab Keamanan
                        </a>
                    </li>
                    <!-- DROPDOWN SOAL UKK RPL 2026/2027 (KELAS 12) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('belajar/ukk*') || request()->is('ukk/admin*') ? 'active text-danger fw-bold' : 'text-warning-subtle fw-semibold' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="badge bg-danger me-1">UKK RPL</span> Portofolio UMKM
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item py-2 fw-bold text-dark" href="{{ route('belajar.ukk.panduan') }}"><i class="bi bi-mortarboard text-danger me-2"></i>Panduan &amp; Analisis Soal UKK</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('ukk.admin.dashboard') }}"><i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard Admin UMKM</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('umkm.show', 'kue-enak-bu-sri') }}" target="_blank"><i class="bi bi-shop text-warning me-2"></i>Halaman Publik "Kue Bu Sri"</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 fw-bold text-success" href="{{ route('belajar.ukk.uji') }}">
                                    <i class="bi bi-patch-check-fill text-success me-2"></i>Uji Kompetensi (5 Skenario Uji)
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="{{ route('template.index') }}" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Template Mentah
                        </a>
                    </li>
                </ul>

                <!-- Identity Badge & Button -->
                <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    <button class="identity-badge btn d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                        <i class="bi bi-person-circle fs-5 text-warning"></i>
                        <div class="text-start lh-1">
                            <span class="d-block fw-bold text-white small" id="headerStudentName">Siswa Praktik</span>
                            <span class="text-light opacity-75" style="font-size: 0.72rem;" id="headerStudentRole">11 RPL &bull; Role Siswa A</span>
                        </div>
                        <i class="bi bi-pencil-fill ms-1 text-warning" style="font-size: 0.75rem;"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- FOOTER ELEGAN DENGAN BRANDING MAJASTIC STUDIO -->
    <footer class="text-white border-top border-secondary border-opacity-50 py-5 mt-5" style="background: radial-gradient(circle at 50% 0%, #1f2937 0%, #0f172a 60%, #030712 100%);">
        <div class="container">
            <div class="row align-items-center gy-4">
                <!-- SISI KIRI: INFORMASI KURIKULUM & SISTEM -->
                <div class="col-lg-4 text-center text-lg-start">
                    <div class="d-inline-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-danger p-2 shadow-sm"><i class="bi bi-fire fs-6"></i></span>
                        <span class="fs-5 fw-bold text-white tracking-wide">LARAVEL SMK</span>
                    </div>
                    <p class="text-secondary small mb-3 lh-sm">
                        Platform Pembelajaran Fundamental Laravel &amp; Arsitektur Sistem Inventaris Lab Berbasis Proyek Industri untuk SMK (Fase E &amp; F PPLG/RPL).
                    </p>
                    <div class="d-flex flex-wrap gap-1 justify-content-center justify-content-lg-start">
                        <span class="badge bg-dark border border-secondary text-light">Laravel {{ Illuminate\Foundation\Application::VERSION }}</span>
                        <span class="badge bg-dark border border-secondary text-light">PHP {{ PHP_VERSION }}</span>
                        <span class="badge bg-success bg-opacity-75">SQLite Active</span>
                        <span class="badge bg-primary bg-opacity-75">45 Routes</span>
                    </div>
                </div>

                <!-- SISI TENGAH: BRANDING UTAMA "by: MAJASTIC studio" -->
                <div class="col-lg-4 text-center">
                    <div class="majastic-brand-card p-3 px-4 rounded-4 d-inline-block shadow" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(12px);">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0 font-monospace small" style="font-size: 0.68rem; letter-spacing: 1px;">
                                OFFICIAL BRAND
                            </span>
                            <span class="text-secondary small fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 1.5px;">
                                by:
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <img src="{{ asset('images/majastic-studio.png') }}" alt="Majastic Studio Logo" style="height: 62px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));">
                            <div class="text-start border-start ps-3 border-secondary-subtle">
                                <span class="d-block fw-bolder text-dark font-monospace fs-5" style="letter-spacing: 2px; line-height: 1.1;">MAJASTIC</span>
                                <span class="d-block text-secondary small fw-semibold" style="letter-spacing: 4px; font-size: 0.72rem;">S T U D I O</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: TAUTAN CEPAT & STATUS -->
                <div class="col-lg-4 text-center text-lg-end">
                    <h6 class="text-white fw-bold small text-uppercase tracking-wider mb-2">
                        <i class="bi bi-compass me-1 text-warning"></i> Navigasi Pembelajaran
                    </h6>
                    <ul class="list-unstyled small mb-0 text-secondary">
                        <li class="mb-1"><a href="{{ route('belajar.index') }}" class="text-secondary text-decoration-none hover-white">&rarr; Dashboard 6 Modul Interaktif</a></li>
                        <li class="mb-1"><a href="{{ route('belajar.keamanan') }}" class="text-secondary text-decoration-none hover-white">&rarr; Laboratorium Keamanan Web (6 Tipe)</a></li>
                        <li class="mb-1"><a href="{{ route('lab-kasus.index') }}" class="text-secondary text-decoration-none hover-white">&rarr; Sistem Inventaris &amp; Peminjaman Lab</a></li>
                        <li class="mb-1"><a href="{{ route('tugas.index') }}" class="text-secondary text-decoration-none hover-white">&rarr; Autochecker Rapor Mandiri Siswa</a></li>
                        <li><a href="{{ route('belajar.ukk.panduan') }}" class="text-warning text-decoration-none hover-white">&rarr; Soal UKK 2026/2027: Portofolio UMKM</a></li>
                    </ul>
                </div>
            </div>

            <!-- GARIS BAWAH HAK CIPTA -->
            <div class="border-top border-secondary border-opacity-25 mt-4 pt-3 text-center small text-secondary">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <span>&copy; {{ date('Y') }} <strong>Eskul Web Laravel SMK</strong> &bull; Didedikasikan untuk kemajuan pendidikan vokasi PPLG / RPL Indonesia.</span>
                    <span class="text-light text-opacity-75 font-monospace" style="font-size: 0.76rem;">
                        Crafted &amp; Powered by: <strong class="text-warning">MAJASTIC Studio</strong>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- MODAL: ATUR IDENTITAS SISWA (PERSIST KE LOCALSTORAGE) -->
    <div class="modal fade" id="studentIdentityModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalLabel">
                        <i class="bi bi-person-badge me-2"></i>Kartu Identitas Siswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Identitas ini akan otomatis dicetak di setiap halaman pengerjaan tugas, log perbaikan, dan kartu penugasan agar Bapak/Ibu Guru mengetahui siapa yang mengerjakan.
                    </p>
                    <form id="studentIdForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputStudentName" placeholder="Contoh: Muhammad Rizky Pratama" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-bold small">Kelas & Jurusan <span class="text-danger">*</span></label>
                                <select class="form-select" id="inputStudentClass" required>
                                    <option value="10 RPL 1">10 RPL 1 / PPLG 1</option>
                                    <option value="10 RPL 2">10 RPL 2 / PPLG 2</option>
                                    <option value="11 RPL 1" selected>11 RPL 1</option>
                                    <option value="11 RPL 2">11 RPL 2</option>
                                    <option value="11 RPL 3">11 RPL 3</option>
                                    <option value="12 RPL 1">12 RPL 1 (Peserta UKK)</option>
                                    <option value="12 RPL 2">12 RPL 2 (Peserta UKK)</option>
                                    <option value="10 TKJ">10 TKJ</option>
                                    <option value="11 TKJ">11 TKJ</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold small">No. Absen</label>
                                <input type="number" class="form-control" id="inputStudentAbsen" placeholder="Contoh: 18" min="1" max="40">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Peran &amp; Hak Akses Aplikasi</label>
                            <select class="form-select" id="inputStudentRole">
                                <option value="Siswa (Hak Akses Biasa)" selected>Siswa (Hak Akses Peminjam &amp; Input Barang)</option>
                                <option value="Guru Lab (Hak Akses Admin)">Guru Lab / Administrator (Hak Akses Penuh &amp; Hapus Permanen)</option>
                                <option value="Mandiri (Pengerjaan Individual)">Siswa Mandiri (Semua Fitur CRUD &amp; Keamanan)</option>
                            </select>
                            <div class="form-text">Pilih peran untuk menguji proteksi Middleware Role (RBAC) pada sistem inventaris.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm px-3" onclick="saveStudentIdentity()">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Identitas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Student Identity Script -->
    <script>
        // Load Identitas Siswa dari localStorage
        function loadStudentIdentity() {
            const name = localStorage.getItem('smk_student_name') || 'Siswa SMK';
            const kelas = localStorage.getItem('smk_student_class') || '11 RPL 1';
            const absen = localStorage.getItem('smk_student_absen') || '01';
            const role = localStorage.getItem('smk_student_role') || 'Siswa A (Create & Read)';

            // Update di Navbar
            const headerNameEl = document.getElementById('headerStudentName');
            const headerRoleEl = document.getElementById('headerStudentRole');
            if (headerNameEl) headerNameEl.textContent = name;
            if (headerRoleEl) headerRoleEl.textContent = `${kelas} (No. ${absen}) • ${role.split(' ')[0]} ${role.split(' ')[1] || ''}`;

            // Update di Modal Form
            const inputName = document.getElementById('inputStudentName');
            const inputClass = document.getElementById('inputStudentClass');
            const inputAbsen = document.getElementById('inputStudentAbsen');
            const inputRole = document.getElementById('inputStudentRole');
            if (inputName) inputName.value = name === 'Siswa SMK' ? '' : name;
            if (inputClass) inputClass.value = kelas;
            if (inputAbsen) inputAbsen.value = absen;
            if (inputRole) inputRole.value = role;

            // Trigger custom event untuk halaman spesifik
            document.dispatchEvent(new CustomEvent('studentIdentityLoaded', {
                detail: { name, kelas, absen, role }
            }));
        }

        // Simpan Identitas Siswa ke localStorage
        function saveStudentIdentity() {
            const name = document.getElementById('inputStudentName').value.trim() || 'Siswa SMK';
            const kelas = document.getElementById('inputStudentClass').value;
            const absen = document.getElementById('inputStudentAbsen').value || '01';
            const role = document.getElementById('inputStudentRole').value;

            localStorage.setItem('smk_student_name', name);
            localStorage.setItem('smk_student_class', kelas);
            localStorage.setItem('smk_student_absen', absen);
            localStorage.setItem('smk_student_role', role);

            loadStudentIdentity();

            // Tutup modal
            const modalEl = document.getElementById('studentIdentityModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadStudentIdentity();
        });
    </script>
    @stack('scripts')
</body>
</html>
