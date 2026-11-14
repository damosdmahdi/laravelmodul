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
            <p class="text-muted small mb-0">Memahami mengapa kita butuh framework & menjelajahi 4 folder utama tanpa rasa bingung</p>
        </div>
        <a href="{{ route('belajar.modul2') }}" class="btn btn-primary btn-sm px-3">
            Lanjut ke Modul 2 <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <!-- ANALOGI RUMAH -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-lightbulb-fill text-warning me-2"></i>Analogi untuk Siswa SMK: Mengapa Kita Butuh Framework?
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 shadow-sm h-100 border">
                        <span class="badge bg-secondary mb-2">PHP Native</span>
                        <h6 class="fw-bold">Bagaikan Bangun Rumah dari Nol Sendiri</h6>
                        <p class="small text-muted mb-0">
                            Kamu harus <strong>mencetak bata sendiri dari tanah liat</strong>, mengaduk semen manual, membuat engsel pintu, dan menyusun pipa air dari nol. Sangat bebas, tapi memakan waktu lama, mudah rapuh jika ada salah adukan, dan rawan celah keamanan bagi orang lain yang masuk!
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 shadow-sm h-100 border border-primary">
                        <span class="badge bg-danger mb-2">Laravel Framework</span>
                        <h6 class="fw-bold text-danger">Bagaikan Bangun Rumah dengan Rangka Siap Pasang</h6>
                        <p class="small text-muted mb-0">
                            Fondasi keamanan, bata hebel standar pabrik, dan rangka atap baja ringan <strong>sudah disediakan oleh tim ahli arsitek (Laravel)</strong>. Siswa dan tim tinggal fokus mendesain tata letak kamar (halaman web) dan furnitur (data aplikasi)!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PETA INTERAKTIF STRUKTUR FOLDER LARAVEL -->
    <div class="row g-4 mb-4">
        <!-- KOLOM KIRI: POHON FOLDER KLIK-ABLE -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-folder-fill text-warning me-2"></i>Peta File & Folder Laravel</span>
                    <span class="badge bg-primary small">Klik Folder untuk Eksplor</span>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i> Jangan takut dengan puluhan folder bawaan! Di tingkat SMK pemula, cukup kuasai <strong>4 area bertanda bintang emas</strong> berikut:
                    </p>

                    <div class="list-group list-group-flush small" id="folderList">
                        <!-- ITEM 1: routes -->
                        <button type="button" class="list-group-item list-group-item-action active p-3 rounded-3 mb-2" onclick="showFolderDetail('routes')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-signpost-2-fill text-warning me-2"></i>routes/web.php</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #1</span>
                            </div>
                            <small class="d-block mt-1 opacity-75">Buku menu alamat URL website.</small>
                        </button>

                        <!-- ITEM 2: app/Http/Controllers -->
                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('controllers')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-gear-wide-connected text-success me-2"></i>app/Http/Controllers/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #2</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Pelayan logika yang mengatur request dan view.</small>
                        </button>

                        <!-- ITEM 3: resources/views -->
                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('views')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-window-sidebar text-danger me-2"></i>resources/views/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #3</span>
                            </div>
                            <small class="d-block mt-1 text-muted">File tampilan HTML & Blade (yang dilihat mata pengunjung).</small>
                        </button>

                        <!-- ITEM 4: database/migrations & Models -->
                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('database')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-database text-info me-2"></i>database/ & app/Models/</span>
                                <span class="badge bg-warning text-dark">⭐ Wajib #4</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Cetakan tabel database (Migration) dan pengelola data (Model).</small>
                        </button>

                        <!-- ITEM 5: .env -->
                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 mb-2 border" onclick="showFolderDetail('env')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-shield-lock text-secondary me-2"></i>.env</span>
                                <span class="badge bg-secondary">Konfigurasi</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Kunci rahasia & setelan database lokal.</small>
                        </button>

                        <!-- ITEM 6: vendor/ -->
                        <button type="button" class="list-group-item list-group-item-action p-3 rounded-3 border" onclick="showFolderDetail('vendor')">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <span class="fw-bold fs-6"><i class="bi bi-archive text-muted me-2"></i>vendor/ & .gitignore</span>
                                <span class="badge bg-danger">Jangan Disentuh</span>
                            </div>
                            <small class="d-block mt-1 text-muted">Ribuan pustaka Composer (masuk .gitignore).</small>
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
            <span class="badge bg-secondary">Coba Jalankan Perintah</span>
        </div>
        <p class="text-secondary small mb-3">
            Klik salah satu tombol perintah di bawah untuk melihat bagaimana terminal merespons di lingkungan nyata:
        </p>
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

        <div class="code-box p-3" style="min-height: 180px; font-size: 0.85rem;" id="terminalConsole">
            <span class="text-secondary">// Terminal interaktif siap. Klik salah satu tombol perintah di atas...</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
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
            desc: "Tempat berkumpulnya semua file tampilan website (.blade.php). Berisi kode HTML yang dipercantik dengan CSS/Bootstrap serta tag cerdas khas Laravel (Blade) seperti @{{ $variabel }} dan @@foreach.",
            tip: "Ekstensi file wajib '.blade.php' agar Laravel bisa memproses sintaks pintasan templating.",
            code: `<!-- resources/views/items/index.blade.php -->
@@extends('layouts.app')

@@section('content')
<div class="container">
    <h2>Daftar Barang Lab</h2>
    @@foreach ($items as $item)
        <p>@{{ $item->nama_barang }} - Stok: @{{ $item->stok }}</p>
    @@endforeach
</div>
@@endsection`
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
        },
        vendor: {
            title: "vendor/ & .gitignore (Pustaka Dependensi)",
            role: "Gudang Komponen Mesin",
            desc: "Folder vendor berisi ratusan megabyte kode pustaka pihak ketiga yang diunduh otomatis oleh Composer. Folder ini TIDAK BOLEH di-push ke GitHub (diabaikan lewat file .gitignore).",
            tip: "Saat siswa clone proyek temannya dari GitHub, folder vendor belum ada. Mereka wajib mengetik 'composer install' untuk mengunduhnya!",
            code: `# .gitignore (Laravel bawaan)
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache`
        }
    };

    function showFolderDetail(key) {
        // Update styling tombol aktif
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

    // Default load routes
    document.addEventListener('DOMContentLoaded', () => {
        showFolderDetail('routes');
    });
</script>
@endpush
