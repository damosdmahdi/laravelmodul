@extends('layouts.belajar')

@section('title', 'Modul 6: CRUD & Proteksi Validasi Form - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB & NAVIGASI -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-check text-success me-2"></i>Modul 6: Penyelesaian CRUD & Proteksi Validasi Form
            </h3>
            <p class="text-muted small mb-0">Menyempurnakan operasi Update (PUT), Hapus (DELETE), proteksi serangan Web Crawler, serta validasi ketat via <code>$request->validate()</code></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul5') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-chevron-left me-1"></i> Modul 5
            </a>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning btn-sm px-3 text-dark fw-bold">
                <i class="bi bi-tools me-1"></i> Praktik di Studi Kasus Lab <i class="bi bi-arrow-right ms-1"></i>
            </a>
            <a href="{{ route('tugas.index') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-clipboard-check me-1"></i> Cek Tugas Siswa
            </a>
        </div>
    </div>

    <!-- 1. ANALOGI & PENERAPAN NYATA DI INDUSTRI -->
    <div class="row g-4 mb-4">
        <!-- ANALOGI DUNIA NYATA -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success text-white rounded-3 p-2 me-3 fs-4 shadow-sm">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle mb-1">Pedagogi SMK</span>
                        <h5 class="fw-bold text-dark mb-0">Analogi: Pintu X-Ray Bandara & Bea Cukai</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Bayangkan database aplikasi sekolah seperti <strong>kabin pesawat terbang</strong> yang harus steril dan aman:
                </p>
                <div class="p-3 bg-white rounded-3 border border-success-subtle small shadow-sm mb-3">
                    <ul class="mb-0 ps-3 text-muted">
                        <li class="mb-2"><strong>Penumpang & Bagasi:</strong> Data yang diisi pengunjung melalui form input web (misal nama barang, stok, dll).</li>
                        <li class="mb-2"><strong>Mesin Scanner X-Ray (<code>$request->validate()</code>):</strong> Petugas memeriksa apakah barang bawaan memenuhi aturan (stok tidak boleh negatif, nama barang wajib ada, dilarang membawa senjata tajam/skrip jahat).</li>
                        <li class="mb-0"><strong>Tolak & Kembalikan (Redirect Back with <code>old()</code>):</strong> Jika melanggar aturan, penumpang tidak boleh naik pesawat dan disuruh merapikan koper tanpa kehilangan identitasnya.</li>
                    </ul>
                </div>
                <div class="small text-success fw-bold">
                    <i class="bi bi-lightbulb-fill me-1"></i> Tanpa validasi di Controller, database akan cepat rusak oleh data palsu, stok bernilai minus, atau karakter perusak!
                </div>
            </div>
        </div>

        <!-- PENERAPAN DI DUNIA KERJA -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger text-white rounded-3 p-2 me-3 fs-4 shadow-sm">
                        <i class="bi bi-shield-slash-fill"></i>
                    </div>
                    <div>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1">Industri & Keamanan</span>
                        <h5 class="fw-bold text-dark mb-0">Bencana Menghapus Pakai Link GET (Tag &lt;a&gt;)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-2">
                    Di dunia kerja, <strong>JANGAN PERNAH</strong> membuat tombol hapus menggunakan tag link biasa:
                    <br><code class="text-danger">&lt;a href="/barang/hapus/1"&gt;Hapus&lt;/a&gt;</code>
                </p>
                <div class="p-3 bg-white rounded-3 border border-danger-subtle small shadow-sm mb-3">
                    <strong class="text-danger"><i class="bi bi-bug-fill me-1"></i> Mengapa Sangat Fatal?</strong>
                    <ol class="mb-0 ps-3 mt-1 text-muted">
                        <li class="mb-1"><strong>Web Crawler Googlebot / Bing:</strong> Bot mesin pencari merayapi semua link <code>&lt;a href="..."&gt;</code> di web Anda secara otomatis. Jika tombol hapus berbentuk GET, robot crawler akan <em>menghapus seluruh database</em> dalam hitungan menit!</li>
                        <li class="mb-0"><strong>Browser Prefetch:</strong> Browser modern (Chrome/Edge) sering me-load halaman link di latar belakang demi kecepatan. Jika diarahkan ke link hapus GET, data terhapus tanpa pengguna mengkliknya!</li>
                    </ol>
                </div>
                <div class="small text-danger fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Solusi Industri: Operasi hapus WAJIB menggunakan form <code>POST</code> dengan directive <code>&#64;method('DELETE')</code> dan proteksi token <code>&#64;csrf</code>!
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KARTU DO'S & DON'TS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-journal-check text-primary me-2"></i>Panduan Penting Siswa SMK: Praktik Benar vs Kesalahan Fatal
            </h5>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Wajib Dipahami</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- SISI KIRI: JANGAN DILAKUKAN -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-danger bg-danger-subtle h-100">
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="bi bi-x-circle-fill me-2"></i>❌ JANGAN DILAKUKAN (Kesalahan Umum Pemula):
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Tombol hapus pakai tag link biasa &lt;a href="..."&gt;!</strong>
                                    <div class="text-muted">Link GET tidak memiliki proteksi CSRF dan bisa di-trigger oleh robot pencari, gambar jahat, atau ekstensi browser.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Memanggil <code>Item::find($id)->delete()</code> tanpa pengecekan!</strong>
                                    <div class="text-muted">Jika ID barang tidak ditemukan di DB, <code>Item::find($id)</code> menghasilkan <code>null</code>, memicu error fatal layar merah: <em>"Call to a member function delete() on null"</em>.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Membuat form input tanpa fungsi <code>old('nama_field')</code>!</strong>
                                    <div class="text-muted">Jika pengguna salah mengisi 1 kolom dari 10 input, seluruh form yang sudah diketik akan terhapus kosong saat di-redirect balik! Pengguna akan sangat jengkel.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Memasukkan data langsung dari <code>$request->all()</code> tanpa validasi!</strong>
                                    <div class="text-muted">Membuka celah Mass Assignment Vulnerability di mana penyerang bisa menyisipkan kolom yang tidak diizinkan.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SISI KANAN: SEBAIKNYA DILAKUKAN -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-success bg-success-subtle h-100">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>✅ SEBAIKNYA DILAKUKAN (Standar Industri Laravel):
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Gunakan form dengan <code>&#64;csrf</code> dan <code>&#64;method('DELETE')</code>!</strong>
                                    <div class="text-muted">Ditambah konfirmasi dialog JavaScript: <code>onsubmit="return confirm('Yakin ingin menghapus barang ini?')"</code> demi keamanan ganda.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Gunakan <code>Item::findOrFail($id)</code> untuk mengambil data!</strong>
                                    <div class="text-muted">Jika ID tidak ada di database, Laravel otomatis mengembalikan halaman 404 (Not Found) yang bersih dan aman tanpa crash.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Selalu gunakan <code>value="&#123;&#123; old('field', $barang->field ?? '') &#125;&#125;"</code>!</strong>
                                    <div class="text-muted">Isian teks pengguna yang sudah benar tetap bertahan di layar ketika terjadi kegagalan validasi, didampingi <code>&#64;error('field')</code>.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Tangkap hasil validasi: <code>$validated = $request->validate([...]);</code></strong>
                                    <div class="text-muted">Lalu simpan menggunakan <code>Item::create($validated);</code> agar hanya data yang lolos aturan validasi yang masuk ke database.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SIMULATOR INTERAKTIF 1: WEB CRAWLER VS METHOD SPOOFING -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold"><i class="bi bi-robot text-warning me-2"></i>Simulator Keamanan: Serangan Web Crawler Bot vs Tombol Hapus</span>
                <span class="badge bg-danger ms-2">GET Vulnerability vs Method Spoofing</span>
            </div>
            <button class="btn btn-sm btn-outline-light" onclick="resetCrawlerSim()">
                <i class="bi bi-arrow-clockwise me-1"></i> Reset Data Barang
            </button>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-info small border-0 d-flex align-items-center mb-3">
                <i class="bi bi-info-circle-fill fs-5 me-3"></i>
                <div>
                    Pilih arsitektur tombol hapus di bawah ini (Link GET atau Form DELETE), lalu klik tombol <strong>"Jalankan Googlebot Crawler"</strong> untuk melihat apakah data barang inventaris Anda selamat atau terhapus bersih!
                </div>
            </div>

            <!-- TOGGLE ARSITEKTUR HAPUS -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 cursor-pointer" id="cardModeGet" onclick="setDeleteMode('get')" style="border-width: 2px !important; cursor: pointer;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deleteMode" id="radioGet" value="get" checked onchange="setDeleteMode('get')">
                            <label class="form-check-label fw-bold text-danger" for="radioGet">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Mode Rentan: Link Biasa Tag &lt;a&gt; (Method GET)
                            </label>
                        </div>
                        <div class="small text-muted mt-2 ps-4">
                            Kodingan di view:
                            <br><code class="text-danger">&lt;a href="/barang/hapus/{id}" class="btn btn-danger"&gt;Hapus&lt;/a&gt;</code>
                            <br><span class="text-secondary small">&rarr; Siapapun yang mengunjungi link ini akan menghapus data!</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100 cursor-pointer" id="cardModeDelete" onclick="setDeleteMode('delete')" style="cursor: pointer;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deleteMode" id="radioDelete" value="delete" onchange="setDeleteMode('delete')">
                            <label class="form-check-label fw-bold text-success" for="radioDelete">
                                <i class="bi bi-shield-lock-fill me-1"></i> Mode Aman Standar Laravel: Form &amp; &#64;method('DELETE')
                            </label>
                        </div>
                        <div class="small text-muted mt-2 ps-4">
                            Kodingan di view:
                            <br><code class="text-success">&lt;form method="POST"&gt; &#64;csrf &#64;method('DELETE') &lt;button&gt;Hapus&lt;/button&gt;&lt;/form&gt;</code>
                            <br><span class="text-secondary small">&rarr; Hanya request bertanda token dan method DELETE yang diterima.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL DATA BARANG SIMULASI -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-database me-1"></i> Tabel Barang Inventaris Lab (Simulasi):</h6>
                        <span class="badge bg-secondary" id="badgeItemCount">4 Barang Tersimpan</span>
                    </div>

                    <div class="table-responsive border rounded-3">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Tombol Aksi di Halaman</th>
                                </tr>
                            </thead>
                            <tbody id="crawlerTableBody">
                                <!-- Generated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PANEL STATUS BOT CRAWLER -->
                <div class="col-lg-4">
                    <div class="card bg-light border-0 rounded-3 h-100 p-3">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-terminal-fill text-dark me-1"></i> Aktivitas Web Crawler:
                        </h6>
                        <div class="p-3 bg-dark text-light rounded-3 font-monospace small mb-3" style="min-height: 150px; max-height: 180px; overflow-y: auto;" id="crawlerLog">
                            <span class="text-secondary">// Bot crawler sedang idle (siap dijalankan)...</span>
                        </div>

                        <button class="btn btn-danger w-100 fw-bold py-2 shadow-sm" id="btnRunCrawler" onclick="runCrawlerAttack()">
                            <i class="bi bi-play-circle-fill me-1"></i> 🤖 Jalankan Googlebot Crawler
                        </button>
                    </div>
                </div>
            </div>

            <!-- HASIL SIMULASI ALERT -->
            <div id="crawlerResultAlert" class="d-none"></div>
        </div>
    </div>

    <!-- 4. SIMULATOR INTERAKTIF 2: VALIDASI INPUT & FITUR old() -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold"><i class="bi bi-ui-checks text-warning me-2"></i>Simulator Validasi Form Input &amp; Magic Helper old()</span>
                <span class="badge bg-warning text-dark ms-2">UX &amp; Controller Validator</span>
            </div>
            <button class="btn btn-sm btn-light" onclick="resetValFormDemo()">
                <i class="bi bi-arrow-clockwise me-1"></i> Kosongkan Form
            </button>
        </div>
        <div class="card-body p-4">
            <!-- PENGATURAN SIMULATOR -->
            <div class="bg-light p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="switchOld" checked onchange="toggleHelperConfig()">
                        <label class="form-check-label fw-bold text-dark small" for="switchOld">
                            Gunakan Helper <code>old('field')</code> di Input
                        </label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="switchError" checked onchange="toggleHelperConfig()">
                        <label class="form-check-label fw-bold text-dark small" for="switchError">
                            Tampilkan Alert <code>&#64;error('field')</code>
                        </label>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-sm" onclick="fillTestScenario('wrong')">
                        <i class="bi bi-lightning-charge me-1"></i> Contoh Input Salah (Uji Validasi)
                    </button>
                    <button class="btn btn-outline-success btn-sm ms-1" onclick="fillTestScenario('valid')">
                        <i class="bi bi-check-circle me-1"></i> Contoh Input Benar
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <!-- FORM INPUT SISWA -->
                <div class="col-lg-6">
                    <div class="border rounded-4 p-3 bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-primary me-1"></i> Form Tambah Barang Inventaris Lab</h6>
                            <span class="badge bg-secondary-subtle text-secondary border small">Simulasi View</span>
                        </div>

                        <form id="formDemoValidasi" onsubmit="event.preventDefault(); submitValidationDemo();">
                            <!-- KODE BARANG -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="inputKode" placeholder="Contoh: LAB-010">
                                <div class="invalid-feedback d-block d-none" id="feedbackKode"></div>
                                <div class="form-text small">Aturan: <code>required|unique:items</code> (Kode LAB-001 &amp; LAB-002 sudah dipakai)</div>
                            </div>

                            <!-- NAMA BARANG -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="inputNama" placeholder="Contoh: Kabel UTP Cat6 305M">
                                <div class="invalid-feedback d-block d-none" id="feedbackNama"></div>
                                <div class="form-text small">Aturan: <code>required|min:4</code></div>
                            </div>

                            <!-- KATEGORI -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Kategori Barang <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="inputKategori">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Jaringan">Jaringan</option>
                                    <option value="Komputer">Komputer</option>
                                    <option value="Elektronik">Elektronik</option>
                                </select>
                                <div class="invalid-feedback d-block d-none" id="feedbackKategori"></div>
                                <div class="form-text small">Aturan: <code>required</code></div>
                            </div>

                            <!-- STOK -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" id="inputStok" placeholder="Contoh: 15">
                                <div class="invalid-feedback d-block d-none" id="feedbackStok"></div>
                                <div class="form-text small">Aturan: <code>required|numeric|min:0</code></div>
                            </div>

                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">
                                    <i class="bi bi-send-fill me-1"></i> Simulasikan Kirim Form (POST)
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetValFormDemo()">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- RESPON DIARY & INSIGHT LARAVEL -->
                <div class="col-lg-6">
                    <div class="border rounded-4 p-3 bg-dark text-light shadow-sm h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-secondary">
                            <span class="small fw-bold text-info"><i class="bi bi-cpu-fill me-1"></i> Proses di Controller &amp; Siklus Request:</span>
                            <span class="badge bg-secondary font-monospace" id="statusBadge">IDLE</span>
                        </div>

                        <div class="code-box p-3 small flex-grow-1" id="valResponseLog" style="background: transparent; color: #e2e8f0; overflow-y: auto;">
                            <span class="text-secondary">// Klik tombol 'Simulasikan Kirim Form' untuk menguji respon $request->validate() di Controller...</span>
                        </div>

                        <div class="mt-3 p-2 rounded-3 bg-secondary bg-opacity-25 border border-secondary border-opacity-50 small" id="uxMessageCard">
                            <span class="text-warning fw-bold"><i class="bi bi-stars me-1"></i> Tips Pedagogi Guru:</span>
                            <span class="text-light" id="uxMessageText"> Cobalah matikan toggle <code>old('field')</code> lalu kirim input yang salah, amati bagaimana ketikan nama barang yang panjang bisa hilang seketika!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. CHEAT-SHEET ROUTE RESOURCE & HTTP VERBS STANDAR RESTful -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-signpost-split-fill text-warning me-2"></i>7 Pasang Route Resource Standar Laravel (<code>Route::resource</code>)
            </h5>
            <span class="badge bg-primary">php artisan route:list</span>
        </div>
        <div class="card-body p-4">
            <p class="text-secondary small mb-3">
                Cukup dengan menulis <code>Route::resource('items', ItemController::class);</code> di <code>routes/web.php</code>, Laravel otomatis membuatkan 7 pasang rute lengkap:
            </p>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>HTTP Verb</th>
                            <th>URI Path</th>
                            <th>Method Controller</th>
                            <th>Nama Route (<code>route(...)</code>)</th>
                            <th>Fungsi / Kegunaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><span class="badge bg-success">GET</span></td>
                            <td><code>/items</code></td>
                            <td><code>index()</code></td>
                            <td><code>items.index</code></td>
                            <td>Menampilkan daftar seluruh barang lab</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-success">GET</span></td>
                            <td><code>/items/create</code></td>
                            <td><code>create()</code></td>
                            <td><code>items.create</code></td>
                            <td>Menampilkan form tambah barang baru (kosong)</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-primary">POST</span></td>
                            <td><code>/items</code></td>
                            <td><code>store(Request $r)</code></td>
                            <td><code>items.store</code></td>
                            <td>Menerima data form &amp; menyimpannya ke database</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-success">GET</span></td>
                            <td><code>/items/{id}</code></td>
                            <td><code>show($id)</code></td>
                            <td><code>items.show</code></td>
                            <td>Menampilkan detail 1 barang spesifik</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-success">GET</span></td>
                            <td><code>/items/{id}/edit</code></td>
                            <td><code>edit($id)</code></td>
                            <td><code>items.edit</code></td>
                            <td>Menampilkan form edit dengan data barang yang ada</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-warning text-dark">PUT / PATCH</span></td>
                            <td><code>/items/{id}</code></td>
                            <td><code>update(Request $r, $id)</code></td>
                            <td><code>items.update</code></td>
                            <td>Menyimpan perubahan data dari form edit (pakai <code>&#64;method('PUT')</code>)</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge bg-danger">DELETE</span></td>
                            <td><code>/items/{id}</code></td>
                            <td><code>destroy($id)</code></td>
                            <td><code>items.destroy</code></td>
                            <td>Menghapus barang dari database (pakai <code>&#64;method('DELETE')</code>)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CALL TO ACTION / NEXT STEP -->
    <div class="card border-0 rounded-4 p-4 text-white shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <h4 class="fw-bold mb-1"><i class="bi bi-award-fill text-warning me-2"></i>Selamat! Anda Telah Mempelajari Seluruh 6 Modul!</h4>
                <p class="text-light text-opacity-75 small mb-0">
                    Sekarang saatnya menguji keterampilan Anda secara nyata di <strong>Studi Kasus Lab Inventaris</strong> (memperbaiki bug yang tersisa) dan menyelesaikan proyek mandiri di folder <strong>tugas-siswa</strong>!
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning fw-bold px-4 py-2 me-2 mb-2 mb-sm-0">
                    <i class="bi bi-play-fill me-1"></i> Studi Kasus Lab
                </a>
                <a href="{{ route('tugas.index') }}" class="btn btn-outline-light px-3 py-2">
                    <i class="bi bi-clipboard-check me-1"></i> Autochecker Tugas
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    // ==========================================
    // BAGIAN 1: SIMULATOR SERANGAN WEB CRAWLER
    // ==========================================
    let currentDeleteMode = 'get'; // 'get' atau 'delete'
    let crawlerRunning = false;

    const initialSimItems = [
        { id: 1, kode: 'LAB-001', nama: 'Kabel UTP Cat6 305M Belden', stok: 50 },
        { id: 2, kode: 'LAB-002', nama: 'Mikrotik Router RB750Gr3', stok: 8 },
        { id: 3, kode: 'LAB-003', nama: 'Switch Cisco Catalyst 24 Port', stok: 4 },
        { id: 4, kode: 'LAB-004', nama: 'Laptop Asus ExpertBook Guru', stok: 12 }
    ];

    let simItems = JSON.parse(JSON.stringify(initialSimItems));

    function setDeleteMode(mode) {
        if (crawlerRunning) return;
        currentDeleteMode = mode;
        const cardGet = document.getElementById('cardModeGet');
        const cardDelete = document.getElementById('cardModeDelete');
        const radioGet = document.getElementById('radioGet');
        const radioDelete = document.getElementById('radioDelete');

        if (mode === 'get') {
            radioGet.checked = true;
            cardGet.style.border = '2px solid #dc3545';
            cardGet.style.background = '#fff5f5';
            cardDelete.style.border = '1px solid #dee2e6';
            cardDelete.style.background = '#ffffff';
        } else {
            radioDelete.checked = true;
            cardDelete.style.border = '2px solid #198754';
            cardDelete.style.background = '#f0fdf4';
            cardGet.style.border = '1px solid #dee2e6';
            cardGet.style.background = '#ffffff';
        }
        renderCrawlerTable();
    }

    function renderCrawlerTable() {
        const tbody = document.getElementById('crawlerTableBody');
        const countBadge = document.getElementById('badgeItemCount');
        countBadge.textContent = `${simItems.length} Barang Tersimpan`;

        if (simItems.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-danger fw-bold">
                        <i class="bi bi-trash3-fill fs-3 d-block mb-1"></i>
                        SEMUA DATA HILANG / TERHAPUS!
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = simItems.map(item => {
            let buttonHtml = '';
            if (currentDeleteMode === 'get') {
                buttonHtml = `
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle p-2">
                        &lt;a href="/barang/hapus/${item.id}"&gt;Hapus (GET)&lt;/a&gt;
                    </span>
                `;
            } else {
                buttonHtml = `
                    <span class="badge bg-success-subtle text-success border border-success-subtle p-2">
                        &lt;form method="POST"&gt; @csrf @method('DELETE') &lt;button&gt;Hapus&lt;/button&gt;&lt;/form&gt;
                    </span>
                `;
            }

            return `
                <tr id="row-item-${item.id}">
                    <td class="font-monospace fw-bold">${item.kode}</td>
                    <td>${item.nama}</td>
                    <td><span class="badge bg-light text-dark border">${item.stok} unit</span></td>
                    <td>${buttonHtml}</td>
                </tr>
            `;
        }).join('');
    }

    function resetCrawlerSim() {
        if (crawlerRunning) return;
        simItems = JSON.parse(JSON.stringify(initialSimItems));
        document.getElementById('crawlerLog').innerHTML = '<span class="text-secondary">// Data di-reset. Bot crawler siap dijalankan.</span>';
        document.getElementById('crawlerResultAlert').className = 'd-none';
        document.getElementById('btnRunCrawler').disabled = false;
        renderCrawlerTable();
    }

    async function runCrawlerAttack() {
        if (crawlerRunning) return;
        crawlerRunning = true;
        const btn = document.getElementById('btnRunCrawler');
        const log = document.getElementById('crawlerLog');
        const resultAlert = document.getElementById('crawlerResultAlert');

        btn.disabled = true;
        resultAlert.className = 'd-none';

        log.innerHTML = `<span class="text-warning">[START] Googlebot / Scraper mendatangi URL: http://sekolah.sch.id/barang</span><br>`;
        log.innerHTML += `<span class="text-info">&rarr; Bot memindai seluruh tag HTML pada halaman...</span><br>`;

        await new Promise(r => setTimeout(r, 900));

        if (currentDeleteMode === 'get') {
            log.innerHTML += `<span class="text-danger fw-bold">[DANGER] Bot menemukan 4 tag link &lt;a href="..."&gt;!</span><br>`;
            log.innerHTML += `<span class="text-secondary">&rarr; Bot mengunjungi setiap link untuk keperluan pengindeksan...</span><br>`;

            for (let i = 0; i < initialSimItems.length; i++) {
                const item = initialSimItems[i];
                await new Promise(r => setTimeout(r, 800));
                
                log.innerHTML += `<span class="text-danger">&rarr; [HTTP GET] /barang/hapus/${item.id} -> 200 OK (Barang ${item.kode} terhapus!)</span><br>`;
                log.scrollTop = log.scrollHeight;

                const row = document.getElementById(`row-item-${item.id}`);
                if (row) {
                    row.style.background = '#fee2e2';
                    row.style.transition = 'all 0.4s';
                    setTimeout(() => {
                        if (row) row.remove();
                    }, 400);
                }
            }

            simItems = [];
            renderCrawlerTable();

            await new Promise(r => setTimeout(r, 600));

            resultAlert.className = 'alert alert-danger border-danger mt-3 shadow-sm d-block';
            resultAlert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-octagon-fill fs-2 me-3 text-danger"></i>
                    <div>
                        <h5 class="fw-bold text-danger mb-1">BENCANA DATABASE! Semua Barang Terhapus!</h5>
                        <p class="small mb-0">
                            Karena tombol hapus menggunakan tag link <code>&lt;a href="..."&gt;</code> (Method GET), Googlebot yang merayapi website menganggap link tersebut adalah halaman biasa untuk dibaca. Akibatnya, server mengeksekusi penghapusan untuk setiap link yang dikunjungi robot!
                        </p>
                    </div>
                </div>
            `;
        } else {
            // Mode Safe DELETE
            log.innerHTML += `<span class="text-success fw-bold">[SAFE] Bot mendeteksi 4 tombol hapus dibungkus tag &lt;form method="POST"&gt;!</span><br>`;
            await new Promise(r => setTimeout(r, 800));
            log.innerHTML += `<span class="text-light">&rarr; Standar W3C: Web crawler mengabaikan form POST/DELETE untuk mencegah manipulasi data.</span><br>`;
            log.innerHTML += `<span class="text-success fw-bold">&rarr; [200 OK] Tidak ada request hapus yang dikirim crawler!</span><br>`;
            log.scrollTop = log.scrollHeight;

            resultAlert.className = 'alert alert-success border-success mt-3 shadow-sm d-block';
            resultAlert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check fs-2 me-3 text-success"></i>
                    <div>
                        <h5 class="fw-bold text-success mb-1">DATABASE 100% AMAN DARI CRAWLER!</h5>
                        <p class="small mb-0">
                            Karena tombol hapus menggunakan <code>&lt;form method="POST"&gt; @csrf @method('DELETE')</code>, mesin pencari dan robot otomatis tidak akan pernah mengeksekusinya. Data inventaris sekolah tetap utuh dan terlindungi!
                        </p>
                    </div>
                </div>
            `;
        }

        crawlerRunning = false;
        btn.disabled = false;
    }

    // ==========================================
    // BAGIAN 2: SIMULATOR VALIDASI & HELPER old()
    // ==========================================
    let useOldHelper = true;
    let showErrorAlert = true;

    function toggleHelperConfig() {
        useOldHelper = document.getElementById('switchOld').checked;
        showErrorAlert = document.getElementById('switchError').checked;
        updateUxMessage();
    }

    function updateUxMessage() {
        const msg = document.getElementById('uxMessageText');
        if (!useOldHelper) {
            msg.innerHTML = ' <span class="text-danger fw-bold">Perhatian:</span> Helper <code>old()</code> dinonaktifkan! Jika validasi gagal, seluruh isi form akan dikosongkan total!';
        } else {
            msg.innerHTML = ' Helper <code>old()</code> aktif. Jika validasi gagal, teks yang sudah diketik akan tetap ada di input field.';
        }
    }

    function fillTestScenario(type) {
        if (type === 'wrong') {
            document.getElementById('inputKode').value = 'LAB-001'; // duplikat
            document.getElementById('inputNama').value = 'Kabel UTP patch cord 5 meter kualitas cat6 gigabit original'; // panjang
            document.getElementById('inputKategori').value = ''; // kosong
            document.getElementById('inputStok').value = '-5'; // minus
        } else {
            document.getElementById('inputKode').value = 'LAB-099';
            document.getElementById('inputNama').value = 'Konektor RJ-45 Cat6 Passthrough (Isi 50)';
            document.getElementById('inputKategori').value = 'Jaringan';
            document.getElementById('inputStok').value = '25';
        }
        clearValidationErrors();
    }

    function clearValidationErrors() {
        ['Kode', 'Nama', 'Kategori', 'Stok'].forEach(field => {
            const fb = document.getElementById('feedback' + field);
            const input = document.getElementById('input' + field);
            if (fb) fb.classList.add('d-none');
            if (input) input.classList.remove('is-invalid', 'is-valid');
        });
    }

    function resetValFormDemo() {
        document.getElementById('inputKode').value = '';
        document.getElementById('inputNama').value = '';
        document.getElementById('inputKategori').value = '';
        document.getElementById('inputStok').value = '';
        clearValidationErrors();
        document.getElementById('valResponseLog').innerHTML = '<span class="text-secondary">// Form dikosongkan. Siap diuji kembali.</span>';
        document.getElementById('statusBadge').textContent = 'IDLE';
        document.getElementById('statusBadge').className = 'badge bg-secondary font-monospace';
    }

    function submitValidationDemo() {
        const kode = document.getElementById('inputKode').value.trim();
        const nama = document.getElementById('inputNama').value.trim();
        const kategori = document.getElementById('inputKategori').value;
        const stok = document.getElementById('inputStok').value.trim();

        clearValidationErrors();

        let errors = {};

        // Aturan: required|unique:items (LAB-001 & LAB-002 duplikat)
        if (!kode) {
            errors.kode = 'Kolom kode barang wajib diisi!';
        } else if (kode === 'LAB-001' || kode === 'LAB-002') {
            errors.kode = `Kode barang '${kode}' sudah terdaftar di database!`;
        }

        // Aturan: required|min:4
        if (!nama) {
            errors.nama = 'Kolom nama barang wajib diisi!';
        } else if (nama.length < 4) {
            errors.nama = 'Nama barang minimal harus 4 karakter!';
        }

        // Aturan: required
        if (!kategori) {
            errors.kategori = 'Kategori barang wajib dipilih!';
        }

        // Aturan: required|numeric|min:0
        if (stok === '') {
            errors.stok = 'Kolom jumlah stok wajib diisi!';
        } else if (isNaN(stok) || parseInt(stok) < 0) {
            errors.stok = 'Jumlah stok harus berupa angka minimal 0 (tidak boleh minus)!';
        }

        const log = document.getElementById('valResponseLog');
        const badge = document.getElementById('statusBadge');

        const hasErrors = Object.keys(errors).length > 0;

        if (hasErrors) {
            badge.textContent = '302 REDIRECT BACK (ERRORS)';
            badge.className = 'badge bg-danger font-monospace';

            // Visual error di form jika switchError aktif
            if (showErrorAlert) {
                if (errors.kode) {
                    document.getElementById('feedbackKode').textContent = errors.kode;
                    document.getElementById('feedbackKode').classList.remove('d-none');
                    document.getElementById('inputKode').classList.add('is-invalid');
                } else {
                    document.getElementById('inputKode').classList.add('is-valid');
                }

                if (errors.nama) {
                    document.getElementById('feedbackNama').textContent = errors.nama;
                    document.getElementById('feedbackNama').classList.remove('d-none');
                    document.getElementById('inputNama').classList.add('is-invalid');
                } else {
                    document.getElementById('inputNama').classList.add('is-valid');
                }

                if (errors.kategori) {
                    document.getElementById('feedbackKategori').textContent = errors.kategori;
                    document.getElementById('feedbackKategori').classList.remove('d-none');
                    document.getElementById('inputKategori').classList.add('is-invalid');
                } else {
                    document.getElementById('inputKategori').classList.add('is-valid');
                }

                if (errors.stok) {
                    document.getElementById('feedbackStok').textContent = errors.stok;
                    document.getElementById('feedbackStok').classList.remove('d-none');
                    document.getElementById('inputStok').classList.add('is-invalid');
                } else {
                    document.getElementById('inputStok').classList.add('is-valid');
                }
            }

            // Simulasi Efek old()
            if (!useOldHelper) {
                // Semua input lenyap dikosongkan!
                document.getElementById('inputKode').value = '';
                document.getElementById('inputNama').value = '';
                document.getElementById('inputKategori').value = '';
                document.getElementById('inputStok').value = '';
            }

            let errorListHtml = Object.keys(errors).map(k => `<li><strong class="text-danger">$errors->first('${k}')</strong>: ${errors[k]}</li>`).join('');

            log.innerHTML = `
<span class="text-danger fw-bold">[VALIDATION FAILED] Permintaan ditolak oleh $request->validate([...])!</span>
<span class="text-white">&rarr; Database TIDAK disentuh sama sekali (mencegah data kotor).</span>
<span class="text-warning">&rarr; Laravel melakukan redirect back() ke halaman form sebelumnya.</span>
<span class="text-info">&rarr; Objek Flash Session dikirim ke View:</span>
<ul class="mb-2 ps-3 mt-1">${errorListHtml}</ul>
<span class="${useOldHelper ? 'text-success' : 'text-danger fw-bold'}">
    &rarr; Status helper old(): ${useOldHelper ? '✅ Input lama tersimpan di session, pengguna tidak capek mengetik ulang!' : '❌ Input lama hilang! Pengguna harus mengetik ulang semuanya dari awal!'}
</span>
            `;
        } else {
            badge.textContent = '302 REDIRECT WITH SUCCESS';
            badge.className = 'badge bg-success font-monospace';

            ['Kode', 'Nama', 'Kategori', 'Stok'].forEach(f => {
                document.getElementById('input' + f).classList.add('is-valid');
            });

            log.innerHTML = `
<span class="text-success fw-bold">[VALIDATION PASSED] Semua data valid dan lolos sensor!</span>
<span class="text-white">&rarr; $validated = $request->validate([ ... ]);</span>
<span class="text-info">&rarr; Item::create($validated);</span>
<span class="text-success">&rarr; [INSERT INTO items] Data berhasil disimpan ke Database!</span>
<span class="text-warning">&rarr; return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');</span>
            `;
        }
    }

    // Inisialisasi awal saat load
    document.addEventListener('DOMContentLoaded', () => {
        setDeleteMode('get');
    });
</script>
@endverbatim
@endpush
