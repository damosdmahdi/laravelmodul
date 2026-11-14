@extends('layouts.belajar')

@section('title', 'Modul 1: Peta Struktur Folder & Setup - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 1: Pengenalan, Struktur Folder & Setup Laravel</h3>
            <p class="text-muted small mb-0">Penerapan nyata di industri, panduan Do's & Don'ts, dan simulator keamanan Git Push</p>
        </div>
        <a href="{{ route('belajar.modul2') }}" class="btn btn-primary btn-sm px-3">
            Lanjut ke Modul 2 <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <!-- 1. PENERAPAN DI DUNIA NYATA & ANALOGI -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary px-3 py-2 fw-semibold"><i class="bi bi-briefcase-fill me-1"></i> Standar Industri & Software House</span>
                <span class="badge bg-white text-dark border">Kenapa Butuh Framework?</span>
            </div>
            <h5 class="fw-bold text-dark mb-3">
                Bagaimana Laravel Diterapkan di Perusahaan Teknologi?
            </h5>
            <p class="text-secondary small mb-3">
                Di dunia kerja nyata (startup, software house, maupun instansi sekolah), programmer <strong>tidak pernah membuat sistem dari nol dengan PHP native</strong> untuk setiap proyek baru. Bayangkan jika setiap kali membuat website sekolah, kamu harus memikirkan enkripsi password sendiri, token anti-hack, session login, dan penataan folder dari nol—bisa memakan waktu berbulan-bulan dan rawan bocor celah keamanannya.
            </p>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 shadow-sm h-100 border">
                        <span class="badge bg-secondary mb-2">PHP Native (Tradisional)</span>
                        <h6 class="fw-bold text-dark">Bagaikan Bangun Rumah Cetak Bata Manual</h6>
                        <p class="small text-muted mb-0">
                            Kamu harus mencetak bata sendiri dari tanah liat, mengaduk semen dari pasir kali, dan merangkai engsel pintu. Bebas, tetapi sangat lama, rentan roboh jika ada salah adonan semen, dan sangat sulit dikerjakan bersama tim teman sekelas.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 shadow-sm h-100 border border-primary">
                        <span class="badge bg-danger mb-2">Laravel Framework (Modern)</span>
                        <h6 class="fw-bold text-danger">Bagaikan Rumah Rangka Baja & Bata Pracetak</h6>
                        <p class="small text-muted mb-0">
                            Fondasi keamanan, proteksi CSRF, sistem database (ORM), dan manajemen rute <strong>sudah dirancang oleh tim arsitek kelas dunia</strong>. Siswa dan tim tinggal fokus mengisi ruangan rumah (tabel inventaris lab dan halaman web)!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DO'S & DON'TS: APA YANG SEBAIKNYA DILAKUKAN VS JANGAN DILAKUKAN -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-shaded text-primary me-2"></i>Panduan Penting: Apa yang SEBAIKNYA Dilakukan vs JANGAN Dilakukan
            </h5>
            <span class="badge bg-danger text-white">Wajib Diingat Siswa</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- SISI KIRI: JANGAN DILAKUKAN (DON'TS) -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-danger bg-danger-subtle h-100">
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="bi bi-x-circle-fill me-2"></i>❌ JANGAN DILAKUKAN (Kesalahan Fatal Siswa):
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan pernah upload folder <code>vendor/</code> ke GitHub!</strong>
                                    <div class="text-muted">Folder vendor berisi ratusan megabyte library luar. Meng-uploadnya akan membuat proses push gagal/sangat berat dan membuat guru marah karena repository menjadi raksasa.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan pernah upload file <code>.env</code> ke repositori publik!</strong>
                                    <div class="text-muted">File <code>.env</code> memuat password database asli, token API, dan kunci rahasia. Siapa pun di internet bisa meretas database aplikasimu jika file ini terunggah.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan mengedit kode di dalam folder <code>vendor/</code>!</strong>
                                    <div class="text-muted">Jika kamu mengubah file di vendor, perubahanmu akan hilang seketika begitu perintah <code>composer update</code> atau <code>composer install</code> dijalankan.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SISI KANAN: SEBAIKNYA DILAKUKAN (DO'S) -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-success bg-success-subtle h-100">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>✅ SEBAIKNYA DILAKUKAN (Standar Industri):
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Selalu gunakan <code>.gitignore</code> untuk vendor & .env!</strong>
                                    <div class="text-muted">Pastikan file <code>.gitignore</code> bawaan Laravel tetap ada sehingga git secara otomatis mengabaikan file rahasia dan folder berat.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Sediakan <code>.env.example</code> sebagai cetakan teman!</strong>
                                    <div class="text-muted">Upload <code>.env.example</code> tanpa password asli agar rekan satu tim bisa membuat file <code>.env</code> sendiri dengan menyalinnya: <code>cp .env.example .env</code>.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Selalu jalankan <code>php artisan key:generate</code> setelah clone!</strong>
                                    <div class="text-muted">Kunci aplikasi (APP_KEY) wajib dibuat baru untuk mengenkripsi cookie dan session pengguna agar tidak terjadi error 500.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SIMULATOR INTERAKTIF: GIT PUSH & DETEKTOR KEAMANAN -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-dark text-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-git me-2 text-danger"></i>Simulator Interaktif: Git Push & Security Leak Scanner</h5>
                <span class="text-secondary small">Coba pilih file yang ingin kamu kirim ke GitHub dan lihat analisis keamanannya!</span>
            </div>
            <span class="badge bg-secondary">Uji Coba Git</span>
        </div>

        <div class="row g-4 align-items-center">
            <!-- CHECKLIST FILE SISWA -->
            <div class="col-lg-5">
                <div class="p-3 bg-secondary bg-opacity-25 rounded-3 border border-secondary mb-3">
                    <label class="form-label small fw-bold text-warning d-block mb-2">Pilih File untuk Di-Push ke GitHub:</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input git-check" type="checkbox" id="chkRoutes" checked onchange="calcGitPayload()">
                        <label class="form-check-label small text-light" for="chkRoutes">routes/web.php (4 KB)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input git-check" type="checkbox" id="chkApp" checked onchange="calcGitPayload()">
                        <label class="form-check-label small text-light" for="chkApp">app/ (Controllers & Models) (18 KB)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input git-check" type="checkbox" id="chkViews" checked onchange="calcGitPayload()">
                        <label class="form-check-label small text-light" for="chkViews">resources/views/ (Template Blade) (25 KB)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input git-check" type="checkbox" id="chkEnv" onchange="calcGitPayload()">
                        <label class="form-check-label small text-danger fw-bold" for="chkEnv">
                            .env (File Password & Kunci Rahasia)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input git-check" type="checkbox" id="chkVendor" onchange="calcGitPayload()">
                        <label class="form-check-label small text-warning fw-bold" for="chkVendor">
                            vendor/ (Folder Pustaka Pihak Ketiga - 145 Megabyte!)
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                    <span>Estimasi Ukuran Commit:</span>
                    <strong class="text-white font-monospace" id="gitPayloadSize">47 KB</strong>
                </div>

                <button type="button" class="btn btn-primary w-100 fw-bold py-2 shadow-sm" onclick="runGitSimulation()">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> 🚀 Simulasikan Git Push ke GitHub
                </button>
            </div>

            <!-- HASIL ANALISIS TERMINAL SCANNER -->
            <div class="col-lg-7">
                <label class="form-label fw-bold small text-light"><i class="bi bi-shield-check me-1 text-success"></i> Hasil Audit Keamanan GitHub CI/CD:</label>
                <div class="code-box p-3 font-monospace" id="gitAuditConsole" style="min-height: 220px; font-size: 0.82rem;">
                    <span class="text-secondary">// Tekan tombol 'Simulasikan Git Push' untuk melihat apakah repository kamu aman atau berbahaya...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. PETA INTERAKTIF STRUKTUR FOLDER LARAVEL (EXISTING) -->
    <div class="row g-4 mb-4">
        <!-- KOLOM KIRI: POHON FOLDER KLIK-ABLE -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-folder-fill text-warning me-2"></i>Peta 4 Folder Utama Laravel</span>
                    <span class="badge bg-primary small">Klik Folder</span>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i> Jangan takut dengan puluhan folder bawaan! Di tingkat SMK pemula, cukup kuasai <strong>4 area bertanda bintang emas</strong> berikut:
                    </p>

                    <div class="list-group list-group-flush small" id="folderList">
                        <button type="button" class="list-group-item list-group-item-action active p-3 rounded-3 mb-2" onclick="showFolderDetail('routes')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-signpost-2-fill text-warning me-2"></i>routes/web.php</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #1</span>
                            </div>
                            <small class="d-block mt-1 opacity-75">Pintu masuk utama URL website.</small>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('controllers')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-gear-wide-connected text-success me-2"></i>app/Http/Controllers/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #2</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Pelayan logika yang memproses data.</small>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('views')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-window-sidebar text-danger me-2"></i>resources/views/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #3</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Tampilan HTML/Blade yang dilihat pengguna.</small>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('database')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-database text-info me-2"></i>database/ & app/Models/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #4</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Struktur tabel migrasi & perwakilan data Model.</small>
                        </button>

                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('env')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-shield-lock text-secondary me-2"></i>.env & .gitignore</span>
                                <span class="badge bg-secondary">Konfigurasi</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Kunci rahasia & setelan database lokal.</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: INSPEKTOR DETAIL FOLDER & CONTOH KODE -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <span class="badge bg-primary me-2">Inspektor File</span>
                    <strong id="inspectorTitle">routes/web.php</strong>
                </div>
                <div class="card-body p-4" id="inspectorBody">
                    <!-- Dynamic Content Loaded by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- TERMINAL ARTISAN SIMULATOR -->
    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-white"><i class="bi bi-terminal me-2 text-success"></i>Simulator Terminal Artisan untuk Siswa</h5>
            <span class="badge bg-secondary">Coba Perintah</span>
        </div>
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button class="btn btn-outline-success btn-sm" onclick="runArtisanSim('php artisan serve')">
                <i class="bi bi-play-fill"></i> php artisan serve
            </button>
            <button class="btn btn-outline-info btn-sm" onclick="runArtisanSim('php artisan key:generate')">
                <i class="bi bi-key-fill"></i> php artisan key:generate
            </button>
            <button class="btn btn-outline-warning btn-sm" onclick="runArtisanSim('php artisan route:list')">
                <i class="bi bi-list-ul"></i> php artisan route:list
            </button>
            <button class="btn btn-outline-light btn-sm" onclick="runArtisanSim('clear')">
                <i class="bi bi-eraser-fill"></i> Bersihkan Terminal
            </button>
        </div>

        <div class="code-box p-3" style="min-height: 140px; font-size: 0.85rem;" id="terminalConsole">
            <span class="text-secondary">// Terminal interaktif siap. Klik salah satu tombol di atas...</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    function calcGitPayload() {
        let size = 0;
        if (document.getElementById('chkRoutes').checked) size += 4;
        if (document.getElementById('chkApp').checked) size += 18;
        if (document.getElementById('chkViews').checked) size += 25;
        if (document.getElementById('chkEnv').checked) size += 2;
        if (document.getElementById('chkVendor').checked) size += 145000;

        const sizeLabel = size >= 1000 ? (size / 1000).toFixed(1) + ' MB' : size + ' KB';
        const el = document.getElementById('gitPayloadSize');
        if (el) el.textContent = sizeLabel;
    }

    function runGitSimulation() {
        const hasEnv = document.getElementById('chkEnv').checked;
        const hasVendor = document.getElementById('chkVendor').checked;
        const consoleEl = document.getElementById('gitAuditConsole');

        consoleEl.innerHTML = `<span class="text-info">[GIT CLIENT] Menjalankan: git add . && git commit -m "feat: tugas siswa"</span><br>`;

        setTimeout(() => {
            if (hasEnv) {
                consoleEl.innerHTML += `
<span class="text-danger fw-bold">[🚨 SECURITY ALERT: FATAL ERROR] File .env terdeteksi di dalam commit!</span><br>
<span class="text-warning">   &bull; Celah Kredensial: DB_PASSWORD dan APP_KEY terekspos ke repositori publik.</span><br>
<span class="text-warning">   &bull; Konsekuensi: Hacker dapat mengunduh database Anda secara bebas.</span><br>
<span class="text-white">   &rarr; Solusi: Masukkan '.env' ke file .gitignore dan gunakan '.env.example'!</span><br><br>
`;
            }

            if (hasVendor) {
                consoleEl.innerHTML += `
<span class="text-danger fw-bold">[⛔ REPO BLOAT: PUSH REJECTED] Folder vendor/ (145 MB) terdeteksi!</span><br>
<span class="text-warning">   &bull; Peringatan Ukuran: Repository menjadi terlalu berat untuk di-clone rekan tim.</span><br>
<span class="text-white">   &rarr; Solusi: Jangan commit vendor/! Teman cukup menjalankan 'composer install' di komputernya!</span><br><br>
`;
            }

            if (!hasEnv && !hasVendor) {
                consoleEl.innerHTML += `
<span class="text-success fw-bold">[✅ CLEAN REPO: AUDIT PASSED] Commit berukuran sangat ringan & bersih!</span><br>
<span class="text-white">   &bull; Tidak ada rahasia .env yang bocor.</span><br>
<span class="text-white">   &bull; Folder vendor/ diabaikan dengan benar via .gitignore.</span><br>
<span class="text-info">   &bull; Status: SIAP DIPUSH KE GITHUB & DILAKUKAN PULL REQUEST (PR)!</span><br>
`;
            }
        }, 300);
    }

    const folderDetails = {
        routes: {
            title: "routes/web.php (Pintu Masuk URL)",
            role: "Buku Menu Restoran",
            desc: "File ini adalah tempat pertama kali browser bertanya: 'Ketika user membuka alamat ini, apa yang harus dilakukan?'. Semua URL website kita didaftarkan di sini.",
            tip: "Ajarkan siswa: Setiap membuat halaman baru, langkah 1 selalu buka routes/web.php!",
            code: `// routes/web.php
use App\\Http\\Controllers\\ItemController;

// Contoh 1: Menampilkan halaman selamat datang
Route::get('/', function () {
    return view('welcome');
});

// Contoh 2: Melempar ke Controller
Route::get('/barang', [ItemController::class, 'index']);`
        },
        controllers: {
            title: "app/Http/Controllers/ (Otak Logika Aplikasi)",
            role: "Pelayan Restoran yang Cekatan",
            desc: "Controller adalah jembatan antara Database dan Tampilan (View). Controller bertugas memanggil Model untuk mengambil data, memproses logika, lalu mengirimkan datanya ke file View Blade.",
            tip: "Gunakan perintah artisan 'php artisan make:controller NamaController' agar tidak membuat file secara manual.",
            code: `// app/Http/Controllers/ItemController.php
namespace App\\Http\\Controllers;
use App\\Models\\Item;

class ItemController extends Controller {
    public function index() {
        // Ambil semua data barang dari database
        $items = Item::all();
        // Kirim data ke tampilan
        return view('items.index', compact('items'));
    }
}`
        },
        views: {
            title: "resources/views/ (Tampilan Layar Pengunjung)",
            role: "Piring Saji Cantik Makanan",
            desc: "Tempat berkumpulnya semua file tampilan website (.blade.php). Berisi kode HTML yang dipercantik dengan CSS/Bootstrap serta tag cerdas khas Laravel (Blade) seperti {{ $variabel }} dan @foreach.",
            tip: "Ekstensi file wajib '.blade.php' agar Laravel bisa memproses sintaks pintasan templating.",
            code: `<!-- resources/views/items/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Barang Lab</h2>
    @foreach ($items as $item)
        <p>{{ $item->nama_barang }} - Stok: {{ $item->stok }}</p>
    @endforeach
</div>
@endsection`
        },
        database: {
            title: "database/migrations/ & app/Models/ (Pengelola Data)",
            role: "Koki & Gudang Bahan Makanan",
            desc: "Migration adalah cetakan skema tabel database yang dicatat dalam kode (bisa di-track di Git). Sedangkan Model (app/Models) adalah perwakilan tabel di kode PHP untuk memudahkan kita query tanpa menulis perintah SQL mentah (SELECT * FROM ...).",
            tip: "Di Laravel, kita tidak perlu sering-sering buka phpMyAdmin karena tabel dibuat otomatis lewat migration!",
            code: `// database/migrations/..._create_items_table.php
Schema::create('items', function (Blueprint $table) {
    $table->id();
    $table->string('kode_barang')->unique();
    $table->string('nama_barang');
    $table->integer('stok');
    $table->timestamps();
});`
        },
        env: {
            title: ".env (Konfigurasi Lingkungan Lokal)",
            role: "Kunci Brankas Rahasia",
            desc: "Menyimpan pengaturan lokal seperti nama aplikasi, URL server, dan koneksi database. File ini masuk ke dalam .gitignore sehingga TIDAK AKAN PERNAH terunggah ke repositori GitHub publik.",
            tip: "Ajarkan siswa: Jangan pernah upload password atau kunci API rahasia ke GitHub!",
            code: `APP_NAME=LaravelInventarisSMK
APP_ENV=local
APP_KEY=base64:UPeUoTK1WU+tAKR5VjDRV0N0Byif3FZCIkPDvXwwfs=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# Di Laravel 11+, sqlite default di database/database.sqlite`
        }
    };

    function showFolderDetail(key) {
        const buttons = document.querySelectorAll('#folderList button');
        buttons.forEach(btn => btn.classList.remove('active', 'text-white'));

        const data = folderDetails[key];
        document.getElementById('inspectorTitle').textContent = data.title;

        const bodyEl = document.getElementById('inspectorBody');
        bodyEl.innerHTML = `
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge bg-info text-dark">${data.role}</span>
                <span class="text-muted small"><i class="bi bi-star-fill text-warning"></i> Materi Inti SMK</span>
            </div>
            <p class="text-secondary">${data.desc}</p>
            <div class="alert alert-light border small my-3">
                <i class="bi bi-lightbulb-fill text-warning me-1"></i> <strong>Tips Pengajaran Guru:</strong> ${data.tip}
            </div>
            <h6 class="fw-bold small text-dark mb-2"><i class="bi bi-code-slash me-1"></i> Contoh Isi File:</h6>
            <div class="code-box p-3">
                <pre class="mb-0"><code>${escapeHtml(data.code)}</code></pre>
            </div>
        `;
    }

    function escapeHtml(string) {
        return string.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function runArtisanSim(cmd) {
        const consoleEl = document.getElementById('terminalConsole');
        if (cmd === 'clear') {
            consoleEl.innerHTML = '<span class="text-secondary">// Terminal dibersihkan.</span>';
            return;
        }

        let output = '';
        if (cmd === 'php artisan serve') {
            output = `
<span class="text-success">$ ${cmd}</span>
<span class="text-white">   INFO  Server running on [http://127.0.0.1:8000].</span>
<span class="text-secondary">   Press Ctrl+C to stop the server</span>
<span class="text-info">   [200] GET / - (Browser berhasil terhubung ke Laravel!)</span>
`;
        } else if (cmd === 'php artisan key:generate') {
            output = `
<span class="text-success">$ ${cmd}</span>
<span class="text-white">   INFO  Application key set successfully.</span>
<span class="text-secondary">   [APP_KEY telah diperbarui di file .env Anda]</span>
`;
        } else if (cmd === 'php artisan route:list') {
            output = `
<span class="text-success">$ ${cmd}</span>
<span class="text-white">  GET|HEAD   / .............................................. home</span>
<span class="text-white">  GET|HEAD   belajar/modul-1 ....................... belajar.modul1</span>
<span class="text-white">  GET|HEAD   belajar/modul-2 ....................... belajar.modul2</span>
<span class="text-white">  GET|HEAD   lab-kasus ............................ lab-kasus.index</span>
<span class="text-info">  Showing [7] routes registered</span>
`;
        }

        consoleEl.innerHTML += output;
        consoleEl.scrollTop = consoleEl.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', () => {
        showFolderDetail('routes');
        calcGitPayload();
    });
</script>
@endverbatim
@endpush
