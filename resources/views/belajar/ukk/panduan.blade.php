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

    <!-- 3. SIMULATOR INTERAKTIF: SLUG AVAILABILITY CHECKER REALTIME -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold"><i class="bi bi-link-45deg text-warning me-2"></i>Simulator Fitur UKK: Validasi Ketersediaan Slug/URL Real-time</span>
                <span class="badge bg-primary ms-2">AJAX Validator</span>
            </div>
            <span class="badge bg-success">Butir Soal 9c</span>
        </div>
        <div class="card-body p-4">
            <p class="text-secondary small mb-3">
                Siswa harus mampu membuat sistem auto-slug saat Admin mengetik nama toko dan memverifikasi apakah URL tersebut sudah pernah dipakai atau masih tersedia:
            </p>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label fw-bold small">1. Ketik Nama Toko / UMKM:</label>
                        <input type="text" id="simNamaUsaha" class="form-control mb-3" placeholder="Contoh: Kue Enak Bu Sri" oninput="handleSimNamaInput(this.value)">

                        <label class="form-label fw-bold small">2. Slug URL Otomatis:</label>
                        <div class="input-group">
                            <span class="input-group-text small bg-white text-muted">portofolio.id/umkm/</span>
                            <input type="text" id="simSlugInput" class="form-control font-monospace" placeholder="kue-enak-bu-sri" oninput="checkSlugAvailability(this.value)">
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="setPresetSlug('kue-enak-bu-sri')">
                                Uji Slug Duplikat ('kue-enak-bu-sri')
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="setPresetSlug('toko-sepatu-baru-2026')">
                                Uji Slug Baru / Bebas
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-3 bg-dark text-light h-100 font-monospace small d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center pb-2 border-bottom border-secondary mb-2">
                                <span class="text-info fw-bold"><i class="bi bi-cpu me-1"></i> Respon AJAX Server Laravel:</span>
                                <span class="badge bg-secondary" id="simSlugStatusBadge">MENUNGGU INPUT</span>
                            </div>
                            <div id="simSlugResponseBox" style="min-height: 80px;">
                                <span class="text-secondary">// Ketik nama usaha di samping atau klik tombol uji untuk memeriksa...</span>
                            </div>
                        </div>

                        <div class="p-2 rounded bg-secondary bg-opacity-25 small text-white border border-secondary border-opacity-50 mt-2">
                            <i class="bi bi-info-circle text-warning me-1"></i>
                            <strong>Kode Controller:</strong> <code>Portfolio::where('slug', $slug)->exists()</code>
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
    function handleSimNamaInput(nama) {
        const slug = nama.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('simSlugInput').value = slug;
        checkSlugAvailability(slug);
    }

    function setPresetSlug(slug) {
        document.getElementById('simSlugInput').value = slug;
        checkSlugAvailability(slug);
    }

    let slugTimer = null;
    async function checkSlugAvailability(slug) {
        clearTimeout(slugTimer);
        const box = document.getElementById('simSlugResponseBox');
        const badge = document.getElementById('simSlugStatusBadge');

        if (!slug || slug.trim() === '') {
            badge.textContent = 'KOSONG';
            badge.className = 'badge bg-secondary';
            box.innerHTML = '<span class="text-secondary">// Slug belum diisi...</span>';
            return;
        }

        badge.textContent = 'MEMERIKSA...';
        badge.className = 'badge bg-warning text-dark';
        box.innerHTML = '<span class="text-warning">&rarr; Mengirim request AJAX ke /api/check-slug?slug=' + encodeURIComponent(slug) + '</span>';

        slugTimer = setTimeout(async () => {
            try {
                const res = await fetch('/api/check-slug?slug=' + encodeURIComponent(slug));
                const data = await res.json();

                if (data.available) {
                    badge.textContent = 'TERSEDIA (VALID)';
                    badge.className = 'badge bg-success';
                    box.innerHTML = `
<span class="text-success fw-bold">[200 OK] ${data.message}</span><br>
<span class="text-white">&rarr; URL yang akan terbentuk: </span><span class="text-info">${data.url_preview}</span><br>
<span class="text-secondary">&rarr; Siap disimpan ke kolom unique database!</span>
                    `;
                } else {
                    badge.textContent = 'DUPLIKAT (DITOLAK)';
                    badge.className = 'badge bg-danger';
                    box.innerHTML = `
<span class="text-danger fw-bold">[422 UNPROCESSABLE] ${data.message}</span><br>
<span class="text-warning">&rarr; Larangan UKK: Slug '${slug}' sudah ada di database!</span><br>
<span class="text-white">&rarr; Saran: Tambahkan pembeda, contoh: '${slug}-2' atau '${slug}-jakarta'</span>
                    `;
                }
            } catch (err) {
                badge.textContent = 'ERROR';
                badge.className = 'badge bg-danger';
                box.textContent = 'Error: ' + err.message;
            }
        }, 300);
    }
</script>
@endverbatim
@endpush
