@extends('layouts.belajar')

@section('title', 'Materi & Panduan UKK RPL 2026/2027: Platform Web Portofolio UMKM')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard Modul
            </a>
            <div class="d-inline-flex align-items-center gap-2 mb-1">
                <span class="badge bg-danger px-3 py-1 font-monospace">SOAL RESMI UKK 2026/2027</span>
                <span class="badge bg-primary px-3 py-1">KELAS 12 RPL</span>
            </div>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-mortarboard-fill text-danger me-2"></i>Pengembangan Platform Web Portofolio UMKM
            </h3>
            <p class="text-muted small mb-0">Panduan lengkap arsitektur, database ERD, alur routing slug, dan aplikasi implementasi standar industri</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ukk.admin.login') }}" class="btn btn-primary btn-sm px-3 fw-bold">
                <i class="bi bi-speedometer2 me-1"></i> Buka Dashboard Admin UMKM
            </a>
            <a href="{{ route('umkm.show', 'kue-enak-bu-sri') }}" target="_blank" class="btn btn-warning btn-sm text-dark fw-bold px-3">
                <i class="bi bi-eye me-1"></i> Lihat Demo Publik (Kue Bu Sri)
            </a>
            <a href="{{ route('belajar.ukk.uji') }}" class="btn btn-success btn-sm px-3 fw-bold">
                <i class="bi bi-patch-check-fill me-1"></i> Uji Kompetensi (5 Skenario)
            </a>
        </div>
    </div>

    <!-- STAT SUMMARY WIDGETS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-primary border-4">
                <span class="text-muted small fw-bold">Alokasi Waktu Ujian</span>
                <h4 class="fw-bold text-dark mt-1 mb-0">8 Jam x 3 Hari</h4>
                <span class="text-secondary small">Penugasan Perorangan</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-success border-4">
                <span class="text-success small fw-bold">Model Layanan</span>
                <h4 class="fw-bold text-success mt-1 mb-0">Done-For-You</h4>
                <span class="text-secondary small">Terima Beres via WhatsApp</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-warning border-4">
                <span class="text-warning small fw-bold">Pintu Akses Sistem</span>
                <h4 class="fw-bold text-dark mt-1 mb-0">Single Dashboard</h4>
                <span class="text-secondary small">Admin kelola seluruh UMKM</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-danger border-4">
                <span class="text-danger small fw-bold">Akses Pengunjung</span>
                <h4 class="fw-bold text-danger mt-1 mb-0">Dynamic Slug URL</h4>
                <span class="text-secondary small">/umkm/{slug} + 404 Handler</span>
            </div>
        </div>
    </div>

    <!-- 1. ANALISIS STUDI KASUS & KONSEP MODEL BISNIS DONE-FOR-YOU -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge bg-danger mb-2">Kasus Nyata Industri</span>
                    <h5 class="fw-bold text-dark mb-2">Mengapa Model "Done-For-You (Terima Beres)" Sangat Efektif untuk UMKM?</h5>
                    <p class="text-secondary small mb-3">
                        Pelaku UMKM (pedagang kue basah, warung kopi, pengrajin batik) umumnya tidak memiliki waktu atau keahlian teknis untuk mendaftar akun, mengatur hosting, atau mendesain website sendiri.
                    </p>
                    <div class="bg-white p-3 rounded-3 border small shadow-sm">
                        <ul class="mb-0 ps-3 text-muted">
                            <li class="mb-1"><strong>Langkah 1:</strong> Pemilik UMKM cukup mengirimkan foto produk, nama toko, bio, dan nomor kontak via WhatsApp ke Admin.</li>
                            <li class="mb-1"><strong>Langkah 2:</strong> Admin login ke satu dashboard sentral, menginput profil, memverifikasi ketersediaan slug URL unik, dan menekan tombol <strong>"Terbitkan Website Portofolio"</strong>.</li>
                            <li class="mb-0"><strong>Langkah 3:</strong> Website instan 1-halaman langsung aktif dan bisa disebarkan ke media sosial pembeli!</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="p-3 bg-white rounded-4 border shadow-sm">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-check2-circle text-success me-2"></i>Tabel Fitur Wajib yang Diuji (UKK Page 2):</h6>
                        <table class="table table-sm table-bordered small mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Fitur Aplikasi</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Publik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Login &amp; Logout</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>CRUD Akun Admin</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>CRUD Portofolio UMKM &amp; Produk</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>Validasi Ketersediaan Slug/URL</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>Publish / Draft Portofolio</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>Log Aktivitas Perubahan Data</td><td class="text-center text-success fw-bold">✓</td><td class="text-center text-muted">-</td></tr>
                                <tr><td>Akses Portofolio via Slug Unik</td><td class="text-center text-muted">-</td><td class="text-center text-success fw-bold">✓</td></tr>
                                <tr><td>Notifikasi Halaman Tidak Ada (404)</td><td class="text-center text-muted">-</td><td class="text-center text-success fw-bold">✓</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DESAIN DATABASE (ERD) & RELASI TABEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-diagram-3-fill text-primary me-2"></i>Desain Basis Data Relasional (ERD UKK)
            </h5>
            <span class="badge bg-secondary">4 Tabel Terelasi</span>
        </div>
        <div class="card-body p-4">
            <p class="text-secondary small mb-3">
                Sesuai petunjuk kerja poin 5 &amp; 6, struktur database dibangun dengan relasi referensial integritas (Foreign Key cascade &amp; set null):
            </p>

            <div class="row g-3">
                <!-- TABEL 1: ADMINS -->
                <div class="col-md-3">
                    <div class="card border rounded-3 h-100">
                        <div class="card-header bg-dark text-white py-2 px-3 fw-bold small">
                            <i class="bi bi-person-fill-lock me-1"></i> admins
                        </div>
                        <div class="card-body p-3 small font-monospace">
                            <div><strong class="text-primary">id</strong> (PK, INT)</div>
                            <div>name (VARCHAR)</div>
                            <div><strong class="text-warning">username</strong> (UQ)</div>
                            <div>email (UQ)</div>
                            <div>password (HASH)</div>
                            <div>role (VARCHAR)</div>
                            <div>timestamps</div>
                        </div>
                    </div>
                </div>

                <!-- TABEL 2: PORTFOLIOS -->
                <div class="col-md-3">
                    <div class="card border rounded-3 h-100 border-primary">
                        <div class="card-header bg-primary text-white py-2 px-3 fw-bold small">
                            <i class="bi bi-briefcase-fill me-1"></i> portfolios (Master)
                        </div>
                        <div class="card-body p-3 small font-monospace">
                            <div><strong class="text-primary">id</strong> (PK, INT)</div>
                            <div><strong class="text-info">admin_id</strong> (FK)</div>
                            <div>nama_usaha</div>
                            <div>tagline</div>
                            <div><strong class="text-danger">slug</strong> (UQ, INDEX)</div>
                            <div>bio (TEXT)</div>
                            <div>whatsapp</div>
                            <div>status (ENUM)</div>
                            <div>views (INT)</div>
                            <div>deleted_at</div>
                        </div>
                    </div>
                </div>

                <!-- TABEL 3: PORTFOLIO_PRODUCTS -->
                <div class="col-md-3">
                    <div class="card border rounded-3 h-100">
                        <div class="card-header bg-success text-white py-2 px-3 fw-bold small">
                            <i class="bi bi-bag-check-fill me-1"></i> portfolio_products
                        </div>
                        <div class="card-body p-3 small font-monospace">
                            <div><strong class="text-primary">id</strong> (PK, INT)</div>
                            <div><strong class="text-info">portfolio_id</strong> (FK)</div>
                            <div>nama_produk</div>
                            <div>harga (INT)</div>
                            <div>foto (VARCHAR)</div>
                            <div>deskripsi (TEXT)</div>
                            <div>timestamps</div>
                        </div>
                    </div>
                </div>

                <!-- TABEL 4: ACTIVITY_LOGS -->
                <div class="col-md-3">
                    <div class="card border rounded-3 h-100">
                        <div class="card-header bg-secondary text-white py-2 px-3 fw-bold small">
                            <i class="bi bi-clock-history me-1"></i> activity_logs (Audit)
                        </div>
                        <div class="card-body p-3 small font-monospace">
                            <div><strong class="text-primary">id</strong> (PK, INT)</div>
                            <div>admin_name</div>
                            <div><strong class="text-info">portfolio_id</strong> (FK)</div>
                            <div>action (VARCHAR)</div>
                            <div>description (TEXT)</div>
                            <div>created_at</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SIMULATOR INTERAKTIF: SLUG AVAILABILITY & DEBOUNCE ENGINE -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" id="simulator-slug-card">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 bg-warning bg-opacity-25 text-warning rounded-3 fs-5">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Simulator Fitur UKK: Real-time Slug & Debounce Engine</h5>
                    <div class="small text-secondary">Validasi URL SEO, Anti-Bentrok Database & Optimalisasi Server AJAX</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary px-3 py-2 rounded-pill font-monospace"><i class="bi bi-clock-history me-1"></i>Debounce 300ms</span>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill font-monospace"><i class="bi bi-magic me-1"></i>Auto-Resolver</span>
                <span class="badge bg-success px-3 py-2 rounded-pill">Butir Soal 9c UKK</span>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-50">
            <!-- Pedagogical Alert: Mengapa Fitur Ini Krusial? -->
            <div class="alert alert-white border shadow-sm rounded-4 p-3 mb-4 bg-white">
                <div class="d-flex align-items-start gap-3">
                    <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-4">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1 text-dark">Mengapa Simulator Ini Sangat Penting Dipahami Siswa?</h6>
                        <p class="text-secondary small mb-2">
                            Dalam Ujian Kompetensi Keahlian (UKK), membuat form input nama toko saja belum cukup. Siswa harus membuktikan pemahaman 3 pilar arsitektur web modern:
                        </p>
                        <div class="row g-2 text-dark small">
                            <div class="col-md-4">
                                <div class="p-2 rounded bg-light border">
                                    <strong class="text-danger"><i class="bi bi-shield-x me-1"></i>1. Anti SQL Crash:</strong>
                                    <div class="text-muted" style="font-size: 0.78rem;">Mencegah error fatal <code>SQLSTATE 1062 Duplicate entry</code> saat form disimpan ke kolom <code>unique</code>.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2 rounded bg-light border">
                                    <strong class="text-primary"><i class="bi bi-speedometer2 me-1"></i>2. Debounce 300ms:</strong>
                                    <div class="text-muted" style="font-size: 0.78rem;">Menahan request agar tidak menembak server di setiap ketikan huruf (menghemat 90%+ beban database).</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2 rounded bg-light border">
                                    <strong class="text-success"><i class="bi bi-magic me-1"></i>3. Solusi Otomatis:</strong>
                                    <div class="text-muted" style="font-size: 0.78rem;">Jika URL sudah terpakai, sistem otomatis membuatkan saran slug unik baru yang bisa diklik langsung.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Scenarios -->
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <span class="small fw-bold text-secondary text-uppercase tracking-wide">
                    <i class="bi bi-play-circle-fill text-primary me-1"></i>Pilih Skenario Demonstrasi Cepat:
                </span>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" onclick="runScenario('duplicate')">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>1. Uji Tabrakan / Duplikat ('Kue Enak Bu Sri')
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3 shadow-sm" onclick="runScenario('available')">
                        <i class="bi bi-check-circle-fill me-1"></i>2. Uji Toko Baru Bebas ('Kopi Senja Nusantara')
                    </button>
                    <button type="button" class="btn btn-outline-warning text-dark btn-sm rounded-pill px-3 shadow-sm" onclick="runScenario('sanitize')">
                        <i class="bi bi-magic me-1"></i>3. Uji Sanitasi Simbol ('Toko Baju & Sepatu #1 (Diskon 50%!!)')
                    </button>
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" onclick="resetSimulator()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- LEFT COLUMN: INPUT STUDIO & DEBOUNCE VISUALIZER -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-secondary text-white font-monospace">1. INPUT FORM ADMIN</span>
                            <span class="small text-muted" id="charCountLabel">0 karakter</span>
                        </div>

                        <!-- Form Field 1: Nama Toko -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small d-flex justify-content-between">
                                <span><i class="bi bi-shop text-primary me-1"></i>Nama Toko / Usaha UMKM:</span>
                                <span class="text-muted fw-normal" style="font-size: 0.78rem;">Ketik bebas di sini</span>
                            </label>
                            <input type="text" id="simNamaUsaha" class="form-control form-control-lg fs-6 rounded-3 border-2" placeholder="Contoh: Kue Enak Bu Sri" oninput="handleSimNamaInput(this.value)" autocomplete="off">
                        </div>

                        <!-- Form Field 2: Slug Otomatis -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small d-flex justify-content-between">
                                <span><i class="bi bi-link-45deg text-success me-1"></i>Slug URL Publik (SEO-Friendly):</span>
                                <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.75rem;">Generated by Str::slug()</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small border-2 font-monospace">portofolio.id/umkm/</span>
                                <input type="text" id="simSlugInput" class="form-control font-monospace border-2 fw-bold text-primary" placeholder="kue-enak-bu-sri" oninput="handleDirectSlugInput(this.value)" autocomplete="off">
                                <button class="btn btn-outline-secondary border-2" type="button" onclick="copySlugToClipboard()" title="Salin URL">
                                    <i class="bi bi-clipboard" id="copyIcon"></i>
                                </button>
                            </div>
                            <div class="form-text text-muted small" style="font-size: 0.75rem;">
                                URL ini yang akan dibuka oleh calon pembeli, pelanggan WhatsApp, dan terindeks di Google.
                            </div>
                        </div>

                        <!-- DEBOUNCE ACTIVITY RADAR -->
                        <div class="p-3 rounded-4 bg-dark text-white mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small font-monospace text-warning fw-bold">
                                    <i class="bi bi-activity me-1"></i>DEBOUNCE BUFFER RADAR (300ms)
                                </span>
                                <span class="badge bg-secondary font-monospace" id="debounceStateBadge">STANDBY</span>
                            </div>

                            <!-- Progress bar -->
                            <div class="progress mb-2" style="height: 6px; background-color: rgba(255,255,255,0.1);">
                                <div id="debounceProgressBar" class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;"></div>
                            </div>

                            <!-- Live Counters -->
                            <div class="row g-2 text-center font-monospace mt-1">
                                <div class="col-4">
                                    <div class="p-2 rounded bg-secondary bg-opacity-25 border border-secondary border-opacity-50">
                                        <div class="text-muted" style="font-size: 0.7rem;">KETIKAN (KEYS)</div>
                                        <div class="fs-5 fw-bold text-info" id="metricKeystrokes">0</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded bg-secondary bg-opacity-25 border border-secondary border-opacity-50">
                                        <div class="text-muted" style="font-size: 0.7rem;">HTTP REQUEST</div>
                                        <div class="fs-5 fw-bold text-warning" id="metricRequests">0</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded bg-secondary bg-opacity-25 border border-secondary border-opacity-50">
                                        <div class="text-muted" style="font-size: 0.7rem;">QUERY DIHEMAT</div>
                                        <div class="fs-5 fw-bold text-success" id="metricSaved">0 (100%)</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 text-secondary text-center" style="font-size: 0.72rem;">
                                <i class="bi bi-info-circle me-1"></i>Debounce menahan timer. Request AJAX baru dikirim <strong>300ms</strong> setelah ketikan terakhir berhenti.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: LIVE MINI-BROWSER PREVIEW & RESOLUTION ENGINE -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white d-flex flex-column">
                        <!-- Mini Browser Chrome -->
                        <div class="p-2 bg-dark border-bottom border-secondary d-flex align-items-center gap-2">
                            <!-- 3 Mac dots -->
                            <div class="d-flex gap-1 ps-2">
                                <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #ff5f56;"></span>
                                <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #ffbd2e;"></span>
                                <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #27c93f;"></span>
                            </div>
                            <!-- Address bar -->
                            <div class="flex-grow-1 bg-secondary bg-opacity-25 rounded-pill px-3 py-1 d-flex align-items-center text-truncate small font-monospace">
                                <i class="bi bi-lock-fill text-success me-2" id="browserLockIcon"></i>
                                <span class="text-muted">https://</span>
                                <span class="text-white">portofolio.id/umkm/</span>
                                <span class="text-warning fw-bold text-truncate" id="browserSlugUrl">...</span>
                            </div>
                            <!-- HTTP Status Badge -->
                            <span class="badge bg-secondary font-monospace" id="browserStatusBadge">STANDBY</span>
                        </div>

                        <!-- Browser Viewport / Content Screen -->
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-center" id="browserScreen" style="min-height: 320px; background: #fafbfc;">
                            
                            <!-- SCREEN STATE 0: EMPTY -->
                            <div id="screenEmpty" class="text-center py-4">
                                <div class="display-5 text-muted mb-3"><i class="bi bi-globe2 text-secondary opacity-50"></i></div>
                                <h6 class="fw-bold text-dark">Mini-Browser Siap Menampilkan Preview</h6>
                                <p class="text-secondary small mx-auto" style="max-width: 320px;">
                                    Ketik nama usaha di formulir sebelah kiri atau pilih salah satu tombol skenario di atas untuk memverifikasi URL secara real-time.
                                </p>
                            </div>

                            <!-- SCREEN STATE 1: CHECKING (SPINNER) -->
                            <div id="screenChecking" class="text-center py-4 d-none">
                                <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                                <h6 class="fw-bold text-dark font-monospace">Memeriksa Database SQLite...</h6>
                                <p class="text-secondary small font-monospace">GET /api/check-slug?slug=<span class="checking-slug text-primary">...</span></p>
                            </div>

                            <!-- SCREEN STATE 2: AVAILABLE (GREEN SUCCESS PREVIEW) -->
                            <div id="screenAvailable" class="d-none">
                                <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-3 d-flex align-items-center gap-3">
                                    <div class="p-2 bg-success text-white rounded-circle fs-4">
                                        <i class="bi bi-check2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-success fs-6">HTTP 200 OK — URL TERSEDIA!</div>
                                        <div class="small text-dark">Slug bebas konflik. Aman disimpan ke database tanpa melanggar constraint <code>unique</code>.</div>
                                    </div>
                                </div>

                                <!-- Simulated Storefront Card -->
                                <div class="border rounded-4 p-3 bg-white shadow-sm mb-3">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 fs-3">
                                            <i class="bi bi-shop"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" id="previewStoreName">Nama Toko Anda</h6>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">
                                                <i class="bi bi-patch-check-fill me-1"></i>UMKM Resmi Terverifikasi
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-2 bg-light rounded-3 font-monospace small text-muted d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-link-45deg me-1"></i>URL Publik:</span>
                                        <strong class="text-primary text-truncate ms-2" id="previewFullUrl">portofolio.id/umkm/...</strong>
                                    </div>
                                </div>

                                <!-- SERP Google Preview -->
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="text-muted" style="font-size: 0.72rem;">GOOGLE SEARCH RESULT PREVIEW (SEO)</div>
                                    <div class="text-primary text-truncate small font-monospace" id="serpUrl">https://portofolio.id › umkm › ...</div>
                                    <div class="fw-bold text-dark small" id="serpTitle">Nama Toko | Portofolio UMKM Digital</div>
                                    <div class="text-secondary" style="font-size: 0.75rem;">Katalog produk unggulan, informasi kontak resmi WhatsApp, dan ulasan pelanggan UMKM.</div>
                                </div>
                            </div>

                            <!-- SCREEN STATE 3: DUPLICATE / CONFLICT (RED ALERT + SUGGESTIONS) -->
                            <div id="screenDuplicate" class="d-none">
                                <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="p-2 bg-danger text-white rounded-circle fs-4">
                                            <i class="bi bi-x-octagon-fill"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold text-danger fs-6">HTTP 409 CONFLICT — SLUG SUDAH DIPAKAI!</div>
                                            <div class="small text-dark mt-1" id="duplicateExplanation">
                                                URL ini sudah dimiliki oleh UMKM lain. Jika dipaksakan simpan, database akan crash!
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Smart Auto-Resolution Box -->
                                <div class="p-3 rounded-4 bg-white border border-danger border-opacity-25 shadow-sm">
                                    <div class="d-flex align-items-center gap-2 mb-2 text-dark fw-bold small">
                                        <i class="bi bi-magic text-warning fs-5"></i>
                                        <span>Rekomendasi Slug Alternatif Otomatis (Bebas Dipakai):</span>
                                    </div>
                                    <p class="text-muted small mb-2" style="font-size: 0.8rem;">
                                        Sistem secara cerdas memeriksa ketersediaan variasi nama berikut. <strong>Klik salah satu</strong> untuk menerapkan langsung:
                                    </p>
                                    <div class="d-flex gap-2 flex-wrap" id="suggestionPillsContainer">
                                        <!-- Dynamically generated suggestions -->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Terminal Snippet -->
                        <div class="p-2 bg-dark border-top border-secondary text-light font-monospace small px-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-terminal me-1 text-info"></i>API Route: <code>GET /api/check-slug</code>
                            </span>
                            <span class="text-warning" id="terminalLatency" style="font-size: 0.75rem;">Latency: ~12ms</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CODE INSPECTOR & ARCHITECTURE DEEP DIVE TABS -->
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-white py-2 px-3 border-bottom">
                    <ul class="nav nav-pills card-header-pills gap-2" id="slugInspectorTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active small py-1 px-3 rounded-pill fw-bold" id="tab-js-btn" data-bs-toggle="tab" data-bs-target="#tab-js" type="button">
                                <i class="bi bi-filetype-js text-warning me-1"></i>1. JavaScript (Frontend Debounce)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link small py-1 px-3 rounded-pill fw-bold" id="tab-controller-btn" data-bs-toggle="tab" data-bs-target="#tab-controller" type="button">
                                <i class="bi bi-filetype-php text-primary me-1"></i>2. Controller (Backend AJAX)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link small py-1 px-3 rounded-pill fw-bold" id="tab-sql-btn" data-bs-toggle="tab" data-bs-target="#tab-sql" type="button">
                                <i class="bi bi-database text-success me-1"></i>3. SQLite & Migration (Unique Rule)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link small py-1 px-3 rounded-pill fw-bold text-danger" id="tab-crash-btn" data-bs-toggle="tab" data-bs-target="#tab-crash" type="button">
                                <i class="bi bi-exclamation-octagon text-danger me-1"></i>4. Bahaya Tanpa Validasi (Simulasi Crash SQL)
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4 bg-light bg-opacity-25">
                    <div class="tab-content" id="slugInspectorContent">
                        
                        <!-- TAB 1: JAVASCRIPT -->
                        <div class="tab-pane fade show active" id="tab-js" role="tabpanel">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-code-slash text-warning me-1"></i>Implementasi Vanilla JavaScript Debounce (Tanpa Library Berat)</h6>
                            <p class="text-secondary small mb-3">
                                Siswa SMK cukup menggunakan fungsi bawaan <code>clearTimeout()</code> dan <code>setTimeout()</code>. Timer dibatalkan setiap ada ketikan baru, dan hanya berjalan jika siswa berhenti mengetik selama 300ms:
                            </p>
                            <pre class="bg-dark text-white p-3 rounded-3 font-monospace small mb-0 overflow-auto" style="max-height: 220px;"><code>let debounceTimer = null;

function handleSimNamaInput(nama) {
    // 1. Sanitasi nama menjadi slug SEO-friendly
    const slug = nama.toLowerCase()
        .replace(/[^\w ]+/g, '') // Hapus simbol aneh (@, #, $, %, dll)
        .replace(/ +/g, '-');    // Ubah spasi ganda menjadi strip tunggal

    document.getElementById('simSlugInput').value = slug;

    // 2. Batalkan timer sebelumnya jika user masih mengetik
    clearTimeout(debounceTimer);

    // 3. Pasang jeda 300ms sebelum menembak server
    debounceTimer = setTimeout(async () => {
        const response = await fetch('/api/check-slug?slug=' + encodeURIComponent(slug));
        const data = await response.json();
        
        if (data.available) {
            // Tampilkan hijau & aktifkan tombol simpan
        } else {
            // Tampilkan merah & berikan alternatif slug dari data.suggestions
        }
    }, 300);
}</code></pre>
                        </div>

                        <!-- TAB 2: CONTROLLER -->
                        <div class="tab-pane fade" id="tab-controller" role="tabpanel">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-cpu text-primary me-1"></i>Method Controller Laravel: <code>UkkController@checkSlug</code></h6>
                            <p class="text-secondary small mb-3">
                                Controller menerima slug via AJAX query string, mengecek keberadaannya di tabel <code>portfolios</code>, dan jika sudah ada, membuatkan alternatif variasi angka/tahun:
                            </p>
                            <pre class="bg-dark text-white p-3 rounded-3 font-monospace small mb-0 overflow-auto" style="max-height: 220px;"><code>public function checkSlug(Request $request): JsonResponse
{
    $slug = Str::slug($request->query('slug', ''));
    
    // Cek keberadaan slug di database
    $exists = Portfolio::where('slug', $slug)->exists();

    if ($exists) {
        // Buat variasi rekomendasi otomatis jika bentrok
        $suggestions = [
            $slug . '-2',
            $slug . '-' . date('Y'),
            $slug . '-official'
        ];
        return response()->json([
            'available' => false,
            'message' => "Slug sudah dipakai!",
            'suggestions' => $suggestions
        ]);
    }

    return response()->json([
        'available' => true,
        'message' => "Slug tersedia!"
    ]);
}</code></pre>
                        </div>

                        <!-- TAB 3: SQL & MIGRATION -->
                        <div class="tab-pane fade" id="tab-sql" role="tabpanel">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-database-check text-success me-1"></i>Integritas Database: Definisi Schema & Query SQLite</h6>
                            <p class="text-secondary small mb-3">
                                Pada file migrasi Laravel, kolom <code>slug</code> wajib diberi constraint <code>unique()</code> untuk menjamin data tidak kembar di level storage engine:
                            </p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 bg-dark text-white rounded-3 font-monospace small h-100">
                                        <div class="text-warning fw-bold mb-1">// Laravel Migration:</div>
                                        <code>Schema::create('portfolios', function (Blueprint $table) {
    $table->id();
    $table->string('nama_usaha');
    $table->string('slug')->unique(); // <--- WAJIB UNIQUE
    $table->timestamps();
});</code>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-dark text-white rounded-3 font-monospace small h-100">
                                        <div class="text-info fw-bold mb-1">-- SQL Query yang Dijalankan:</div>
                                        <code>SELECT EXISTS(
    SELECT 1 FROM "portfolios" 
    WHERE "slug" = 'kue-enak-bu-sri' 
    AND "deleted_at" IS NULL
) AS "exists";</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: CRASH SIMULATION -->
                        <div class="tab-pane fade" id="tab-crash" role="tabpanel">
                            <div class="alert alert-danger border-0 rounded-3 p-3 mb-3">
                                <div class="fw-bold fs-6"><i class="bi bi-exclamation-triangle-fill me-2"></i>Bencana yang Terjadi Jika Fitur Ini Tidak Dibuat Siswa:</div>
                                <div class="small mt-1">
                                    Ketika dua Admin mendaftarkan toko dengan nama sama (atau Admin lupa bahwa nama tersebut sudah terdaftar), menekan tombol <strong>Simpan</strong> akan langsung melempar error layar merah Laravel yang sangat memalukan saat dinilai penguji:
                                </div>
                            </div>
                            <div class="p-3 bg-dark text-danger rounded-3 font-monospace small">
                                <div class="text-white fw-bold mb-2">💥 LARAVEL EXCEPTION TRACE (ERROR 500):</div>
                                <div class="text-danger fw-bold">Illuminate\Database\QueryException</div>
                                <div class="text-light">SQLSTATE[23000]: Integrity constraint violation: 19 UNIQUE constraint failed: portfolios.slug</div>
                                <div class="text-secondary mt-2">// Insert failed at app/Http/Controllers/UkkController.php:124</div>
                                <div class="text-warning mt-2">&rarr; Dampak: Form ter-reset, foto unggahan hilang, user frustrasi, dan nilai UKK siswa anjlok!</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 4. PINTU MENUJU MODUL APLIKASI NYATA UKK -->
    <div class="row g-4 mb-4">
        <!-- MODUL 1: DASHBOARD ADMIN -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-3 p-3 me-3 fs-4 shadow-sm">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-1">Aplikasi Admin</span>
                        <h5 class="fw-bold text-dark mb-0">Dashboard Admin UKK</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Replikasi dashboard persis seperti Lampiran Page 5 Soal UKK: Form buat portofolio, stats widget, tabel aktivitas, edit, hapus, dan switch publish/draft.
                </p>
                <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Buka Dashboard Admin &rarr;
                </a>
            </div>
        </div>

        <!-- MODUL 2: DEMO PUBLIK "KUE ENAK BU SRI" -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning text-dark rounded-3 p-3 me-3 fs-4 shadow-sm">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div>
                        <span class="badge bg-warning-subtle text-dark border border-warning-subtle mb-1">Landing Page Publik</span>
                        <h5 class="fw-bold text-dark mb-0">Web UMKM "Kue Bu Sri"</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Halaman portofolio instan satu halaman (Lampiran Page 5): headline, bio, grid produk unggulan (lapis legit, kastengel, dll), dan tombol order WhatsApp.
                </p>
                <a href="{{ route('umkm.show', 'kue-enak-bu-sri') }}" target="_blank" class="btn btn-warning text-dark btn-sm w-100 fw-bold">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Landing Page Publik &rarr;
                </a>
            </div>
        </div>

        <!-- MODUL 3: UJI KOMPETENSI 5 SKENARIO -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success text-white rounded-3 p-3 me-3 fs-4 shadow-sm">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle mb-1">Pengujian Mandiri</span>
                        <h5 class="fw-bold text-dark mb-0">Uji 5 Skenario UKK</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Jalankan pengujian otomatis untuk 5 skenario wajib UKK: Login Admin, Tambah Portofolio, Cegah Slug Duplikat, Akses Publik Valid, dan Penanganan 404.
                </p>
                <a href="{{ route('belajar.ukk.uji') }}" class="btn btn-success btn-sm w-100 fw-bold">
                    <i class="bi bi-play-circle-fill me-1"></i> Jalankan 5 Uji Kompetensi &rarr;
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    let debounceTimer = null;
    let animTimer = null;
    let keystrokes = 0;
    let requestCount = 0;

    function handleSimNamaInput(nama) {
        keystrokes++;
        document.getElementById('metricKeystrokes').textContent = keystrokes;
        document.getElementById('charCountLabel').textContent = nama.length + ' karakter';

        // Auto slug sanitization (replaces special chars, spaces to dash)
        const slug = nama.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');

        document.getElementById('simSlugInput').value = slug;
        triggerDebounce(slug, nama);
    }

    function handleDirectSlugInput(rawSlug) {
        keystrokes++;
        document.getElementById('metricKeystrokes').textContent = keystrokes;
        const cleanSlug = rawSlug.toLowerCase().replace(/[^\w-]+/g, '');
        document.getElementById('simSlugInput').value = cleanSlug;
        const storeName = document.getElementById('simNamaUsaha').value || cleanSlug;
        triggerDebounce(cleanSlug, storeName);
    }

    function triggerDebounce(slug, storeName) {
        clearTimeout(debounceTimer);
        clearInterval(animTimer);

        const debounceBadge = document.getElementById('debounceStateBadge');
        const progressBar = document.getElementById('debounceProgressBar');
        const browserSlugUrl = document.getElementById('browserSlugUrl');
        const browserBadge = document.getElementById('browserStatusBadge');
        const lockIcon = document.getElementById('browserLockIcon');

        // Update address bar text immediately as you type
        browserSlugUrl.textContent = slug || '...';

        if (!slug || slug.trim() === '') {
            showScreen('empty');
            debounceBadge.textContent = 'STANDBY';
            debounceBadge.className = 'badge bg-secondary font-monospace';
            progressBar.style.width = '0%';
            browserBadge.textContent = 'KOSONG';
            browserBadge.className = 'badge bg-secondary font-monospace';
            lockIcon.className = 'bi bi-lock text-muted me-2';
            return;
        }

        // Set debounce status: BUFFERING
        debounceBadge.textContent = 'MENGETIK (BUFFERING...)';
        debounceBadge.className = 'badge bg-warning text-dark font-monospace';
        
        // Animate progress bar across 300ms
        let progress = 0;
        progressBar.style.width = '0%';
        const step = 20; // 20ms intervals
        const totalSteps = 300 / step;
        let currentStep = 0;

        animTimer = setInterval(() => {
            currentStep++;
            progress = Math.min(100, Math.round((currentStep / totalSteps) * 100));
            progressBar.style.width = progress + '%';
            if (currentStep >= totalSteps) {
                clearInterval(animTimer);
            }
        }, step);

        // Debounce wait 300ms
        debounceTimer = setTimeout(async () => {
            clearInterval(animTimer);
            progressBar.style.width = '100%';

            // Increment request count
            requestCount++;
            document.getElementById('metricRequests').textContent = requestCount;
            
            // Calculate saved queries
            const saved = Math.max(0, keystrokes - requestCount);
            const percentSaved = keystrokes > 0 ? Math.round((saved / keystrokes) * 100) : 0;
            document.getElementById('metricSaved').textContent = `${saved} (${percentSaved}%)`;

            // Update badge: SENDING
            debounceBadge.textContent = 'MENGIRIM AJAX...';
            debounceBadge.className = 'badge bg-info text-dark font-monospace';
            browserBadge.textContent = 'MEMERIKSA...';
            browserBadge.className = 'badge bg-warning text-dark font-monospace';
            
            // Show loading spinner
            const checkingEl = document.querySelector('.checking-slug');
            if (checkingEl) checkingEl.textContent = slug;
            showScreen('checking');

            const startTime = performance.now();

            try {
                const res = await fetch('/api/check-slug?slug=' + encodeURIComponent(slug));
                const data = await res.json();
                const latency = Math.round(performance.now() - startTime);
                document.getElementById('terminalLatency').textContent = `Latency: ~${latency}ms`;

                debounceBadge.textContent = 'SELESAI (OK)';
                debounceBadge.className = 'badge bg-success font-monospace';

                if (data.available) {
                    // STATUS 200 AVAILABLE
                    browserBadge.textContent = '200 TERSEDIA';
                    browserBadge.className = 'badge bg-success font-monospace';
                    lockIcon.className = 'bi bi-lock-fill text-success me-2';

                    // Update Preview Card
                    document.getElementById('previewStoreName').textContent = storeName || slug;
                    document.getElementById('previewFullUrl').textContent = `portofolio.id/umkm/${slug}`;
                    document.getElementById('serpUrl').textContent = `https://portofolio.id › umkm › ${slug}`;
                    document.getElementById('serpTitle').textContent = `${storeName || slug} | Portofolio UMKM Digital`;

                    showScreen('available');
                } else {
                    // STATUS 409 DUPLICATE
                    browserBadge.textContent = '409 KONFLIK';
                    browserBadge.className = 'badge bg-danger font-monospace';
                    lockIcon.className = 'bi bi-shield-x text-danger me-2';

                    const owner = data.existing_owner || 'UMKM Terdaftar Lain';
                    document.getElementById('duplicateExplanation').innerHTML = 
                        `URL slug <strong>'${slug}'</strong> sudah digunakan oleh toko <strong>"${owner}"</strong>. Jika disimpan, database SQLite akan melempar <em>IntegrityConstraintViolation</em>.`;

                    // Render dynamic suggestion pills
                    const container = document.getElementById('suggestionPillsContainer');
                    container.innerHTML = '';
                    const suggestions = (data.suggestions && data.suggestions.length > 0) 
                        ? data.suggestions 
                        : [`${slug}-2`, `${slug}-2026`, `${slug}-official`];

                    suggestions.forEach(sug => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-danger btn-sm rounded-pill fw-bold font-monospace shadow-sm';
                        btn.innerHTML = `<i class="bi bi-arrow-right-short text-warning"></i> ${sug}`;
                        btn.onclick = () => applySuggestion(sug);
                        container.appendChild(btn);
                    });

                    showScreen('duplicate');
                }
            } catch (err) {
                debounceBadge.textContent = 'GAGAL (ERROR)';
                debounceBadge.className = 'badge bg-danger font-monospace';
                browserBadge.textContent = 'ERROR 500';
                browserBadge.className = 'badge bg-danger font-monospace';
            }
        }, 300);
    }

    function showScreen(type) {
        document.getElementById('screenEmpty').classList.add('d-none');
        document.getElementById('screenChecking').classList.add('d-none');
        document.getElementById('screenAvailable').classList.add('d-none');
        document.getElementById('screenDuplicate').classList.add('d-none');

        if (type === 'empty') document.getElementById('screenEmpty').classList.remove('d-none');
        else if (type === 'checking') document.getElementById('screenChecking').classList.remove('d-none');
        else if (type === 'available') document.getElementById('screenAvailable').classList.remove('d-none');
        else if (type === 'duplicate') document.getElementById('screenDuplicate').classList.remove('d-none');
    }

    function applySuggestion(slug) {
        document.getElementById('simSlugInput').value = slug;
        const storeName = document.getElementById('simNamaUsaha').value || slug;
        triggerDebounce(slug, storeName);
    }

    function runScenario(type) {
        if (type === 'duplicate') {
            const val = 'Kue Enak Bu Sri';
            document.getElementById('simNamaUsaha').value = val;
            handleSimNamaInput(val);
        } else if (type === 'available') {
            const val = 'Kopi Senja Nusantara';
            document.getElementById('simNamaUsaha').value = val;
            handleSimNamaInput(val);
        } else if (type === 'sanitize') {
            const val = 'Toko Baju & Sepatu #1 (Diskon 50%!!)';
            document.getElementById('simNamaUsaha').value = val;
            handleSimNamaInput(val);
        }
    }

    function resetSimulator() {
        keystrokes = 0;
        requestCount = 0;
        document.getElementById('simNamaUsaha').value = '';
        document.getElementById('simSlugInput').value = '';
        document.getElementById('metricKeystrokes').textContent = '0';
        document.getElementById('metricRequests').textContent = '0';
        document.getElementById('metricSaved').textContent = '0 (100%)';
        document.getElementById('charCountLabel').textContent = '0 karakter';
        document.getElementById('browserSlugUrl').textContent = '...';
        document.getElementById('debounceProgressBar').style.width = '0%';
        document.getElementById('debounceStateBadge').textContent = 'STANDBY';
        document.getElementById('debounceStateBadge').className = 'badge bg-secondary font-monospace';
        document.getElementById('browserStatusBadge').textContent = 'STANDBY';
        document.getElementById('browserStatusBadge').className = 'badge bg-secondary font-monospace';
        showScreen('empty');
    }

    function copySlugToClipboard() {
        const slug = document.getElementById('simSlugInput').value;
        if (!slug) return;
        const url = `https://portofolio.id/umkm/${slug}`;
        navigator.clipboard.writeText(url).then(() => {
            const icon = document.getElementById('copyIcon');
            icon.className = 'bi bi-check2 text-success';
            setTimeout(() => {
                icon.className = 'bi bi-clipboard';
            }, 1500);
        });
    }
</script>
@endverbatim
@endpush
