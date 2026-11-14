@extends('layouts.belajar')

@section('title', 'Modul 2: Simulator Alur MVC & Visual Explorer Folder - Belajar Laravel SMK')

@push('styles')
<style>
    /* =========================================
       TEMA VS CODE WORKSPACE EXPLORER
       ========================================= */
    .vscode-container {
        background-color: #181824;
        border: 1px solid #2d2d3f;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        font-family: 'Fira Code', 'Segoe UI', Consolas, monospace;
    }

    /* TOP TITLEBAR */
    .vscode-titlebar {
        background-color: #12121a;
        color: #94a3b8;
        padding: 8px 16px;
        font-size: 0.78rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #2d2d3f;
    }
    .vscode-dots {
        display: flex;
        gap: 6px;
    }
    .vscode-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
    }
    .dot-red { background: #ef4444; }
    .dot-yellow { background: #f59e0b; }
    .dot-green { background: #10b981; }

    /* SIDEBAR EXPLORER */
    .vscode-sidebar {
        background-color: #1e1e2e;
        border-right: 1px solid #2d2d3f;
        color: #cbd5e1;
        font-size: 0.82rem;
        user-select: none;
        overflow-y: auto;
        max-height: 580px;
    }
    .vscode-header-title {
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #94a3b8;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #28283d;
    }

    /* TREE ITEMS */
    .tree-item {
        display: flex;
        align-items: center;
        padding: 4px 10px;
        cursor: pointer;
        border-radius: 4px;
        margin: 1px 4px;
        transition: all 0.2s ease;
        position: relative;
    }
    .tree-item:hover {
        background-color: #2b2b40;
        color: #ffffff;
    }
    .tree-chevron {
        width: 16px;
        display: inline-block;
        font-size: 0.7rem;
        color: #64748b;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .tree-chevron.open {
        transform: rotate(90deg);
        color: #93c5fd;
    }
    .tree-icon {
        margin-right: 6px;
        font-size: 0.95rem;
    }

    /* INDENTATION */
    .tree-level-1 { padding-left: 12px; }
    .tree-level-2 { padding-left: 28px; }
    .tree-level-3 { padding-left: 44px; }
    .tree-level-4 { padding-left: 60px; }

    /* SUBFOLDER CONTAINER ANIMASI */
    .tree-children {
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s;
        max-height: 0;
        opacity: 0;
    }
    .tree-children.expanded {
        max-height: 500px;
        opacity: 1;
    }

    /* ANIMASI HIT PADA FILE & FOLDER */
    @keyframes pulseHitSuccess {
        0% { background-color: rgba(16, 185, 129, 0.2); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
        50% { background-color: rgba(16, 185, 129, 0.45); box-shadow: 0 0 15px 3px rgba(16, 185, 129, 0.8); }
        100% { background-color: rgba(16, 185, 129, 0.25); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    @keyframes pulseHitError {
        0% { background-color: rgba(239, 68, 68, 0.3); transform: translateX(-2px); }
        25% { transform: translateX(2px); }
        50% { background-color: rgba(239, 68, 68, 0.6); box-shadow: 0 0 15px 3px rgba(239, 68, 68, 0.8); }
        75% { transform: translateX(-2px); }
        100% { background-color: rgba(239, 68, 68, 0.3); transform: translateX(0); }
    }

    .tree-item.hit-active {
        animation: pulseHitSuccess 1.5s infinite;
        border: 1px solid #10b981;
        color: #ffffff !important;
        font-weight: 600;
    }
    .tree-item.hit-error {
        animation: pulseHitError 0.5s 3;
        border: 1px solid #ef4444;
        color: #f87171 !important;
        font-weight: 600;
    }

    /* BADGE LANGKAH EKSEKUSI */
    .hit-step-badge {
        margin-left: auto;
        font-size: 0.68rem;
        padding: 2px 6px;
        border-radius: 4px;
        background: #10b981;
        color: white;
        font-weight: bold;
        letter-spacing: 0.3px;
        display: none;
    }
    .hit-step-badge.show {
        display: inline-block;
    }

    /* EDITOR CODE PANE */
    .vscode-editor {
        background-color: #12121a;
        color: #e2e8f0;
        display: flex;
        flex-direction: column;
        min-height: 580px;
    }
    .vscode-tabs {
        display: flex;
        background-color: #181824;
        border-bottom: 1px solid #2d2d3f;
        overflow-x: auto;
    }
    .vscode-tab {
        padding: 8px 16px;
        font-size: 0.8rem;
        color: #94a3b8;
        cursor: pointer;
        border-right: 1px solid #2d2d3f;
        display: flex;
        align-items: center;
        gap: 6px;
        background: #181824;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .vscode-tab.active {
        background-color: #12121a;
        color: #38bdf8;
        border-top: 2px solid #38bdf8;
        font-weight: 600;
    }
    .vscode-code-content {
        padding: 16px;
        font-size: 0.86rem;
        line-height: 1.6;
        flex-grow: 1;
        overflow-y: auto;
    }

    /* HIGHLIGHT LINE DALAM KODE */
    .highlight-line {
        background: rgba(245, 158, 11, 0.2);
        border-left: 3px solid #f59e0b;
        display: block;
        padding-left: 4px;
        margin: 0 -16px;
        padding-right: 16px;
        animation: highlightPulse 2s infinite;
    }
    @keyframes highlightPulse {
        0%, 100% { background: rgba(245, 158, 11, 0.15); }
        50% { background: rgba(245, 158, 11, 0.3); }
    }

    /* EXPLANATION TOAST / CARD DI BAWAH EDITOR */
    .step-explain-card {
        background: #1e1e2e;
        border-top: 1px solid #2d2d3f;
        padding: 12px 18px;
    }

    /* ICON COLORING */
    .icon-php { color: #818cf8; }
    .icon-folder { color: #f59e0b; }
    .icon-view { color: #f97316; }
    .icon-route { color: #34d399; }
    .icon-db { color: #38bdf8; }
    .icon-gear { color: #cbd5e1; }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-4 py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-1">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 2: Visualisasi Alur MVC dengan Folder Explorer</h3>
            <p class="text-muted small mb-0">Lihat folder & file proyek terbuka satu per satu saat permintaan (request) dijalankan</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-dark text-white px-3 py-2 small">
                <i class="bi bi-speedometer2 me-1"></i> Kecepatan:
                <select id="simSpeed" class="bg-dark text-white border-0 small ms-1" style="outline: none;">
                    <option value="1800">Normal (1.8s)</option>
                    <option value="3000">Lambat / Presentasi Guru (3.0s)</option>
                    <option value="900">Cepat (0.9s)</option>
                </select>
            </span>
            <a href="{{ route('belajar.modul3') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 3 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- PUSAT KENDALI REQUEST & PRESET -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
        <div class="row align-items-center g-3">
            <!-- PRESETS -->
            <div class="col-lg-6">
                <label class="form-label fw-bold small text-muted mb-1">Pilih Skenario Permintaan (Request):</label>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setSimScenario('GET', '/barang')">
                        <i class="bi bi-list-check me-1"></i> <strong>GET /barang</strong> (Alur Penuh MVC)
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="setSimScenario('GET', '/barang/tambah')">
                        <i class="bi bi-file-earmark-plus me-1"></i> <strong>GET /barang/tambah</strong> (Form Input)
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="setSimScenario('POST', '/barang')">
                        <i class="bi bi-save me-1"></i> <strong>POST /barang</strong> (Simpan ke DB)
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="setSimScenario('GET', '/halaman-salah')">
                        <i class="bi bi-x-octagon me-1"></i> <strong>GET /halaman-salah</strong> (404 Error)
                    </button>
                </div>
            </div>

            <!-- INPUT MANUAL & TOMBOL JALANKAN -->
            <div class="col-lg-6">
                <div class="row g-2 align-items-center">
                    <div class="col-sm-7">
                        <label class="form-label fw-bold small text-muted mb-1">Input URL Pengujian:</label>
                        <div class="input-group input-group-sm">
                            <select class="form-select font-monospace flex-grow-0" style="width: 85px;" id="simMethod">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                            </select>
                            <input type="text" class="form-control font-monospace" id="simUrl" value="/barang">
                        </div>
                    </div>
                    <div class="col-sm-5 d-flex gap-2 mt-auto">
                        <button type="button" class="btn btn-primary btn-sm w-100 fw-bold py-2 shadow-sm" id="btnRunSim" onclick="startFolderAnimation()">
                            <i class="bi bi-play-circle-fill me-1"></i> Jalankan Alur
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" title="Tutup Semua Folder" onclick="resetAllFolders()">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WORKSPACE VS CODE UTAMA -->
    <div class="vscode-container mb-4">
        <!-- TOP TITLEBAR -->
        <div class="vscode-titlebar">
            <div class="vscode-dots">
                <span class="vscode-dot dot-red"></span>
                <span class="vscode-dot dot-yellow"></span>
                <span class="vscode-dot dot-green"></span>
            </div>
            <div class="small fw-semibold text-light font-monospace" id="titlebarUrl">
                <i class="bi bi-browser-chrome me-1 text-primary"></i> Browser Request: <span class="text-warning">GET /barang</span> &bull; Laravel Framework Simulator
            </div>
            <div class="small">
                <span class="badge bg-secondary" id="simStatusPill">Status: Standby</span>
            </div>
        </div>

        <div class="row g-0">
            <!-- =========================================
                 KOLOM KIRI: VS CODE EXPLORER (FOLDER TREE)
                 ========================================= -->
            <div class="col-md-4 col-lg-3 vscode-sidebar p-2">
                <div class="vscode-header-title">
                    <span><i class="bi bi-folder-symlink me-1"></i> EXPLORER: LARAVEL</span>
                    <div class="d-flex gap-2 text-muted" style="cursor: pointer;">
                        <i class="bi bi-arrow-repeat" title="Refresh" onclick="resetAllFolders()"></i>
                        <i class="bi bi-chevron-bar-contract" title="Collapse All" onclick="resetAllFolders()"></i>
                    </div>
                </div>

                <!-- TREE ROOT -->
                <div class="tree-item tree-level-1 fw-bold text-light" onclick="toggleFolder('c-root', this)">
                    <span class="tree-chevron open">▶</span>
                    <i class="bi bi-box text-danger tree-icon"></i>
                    <span>laravel</span>
                </div>

                <div class="tree-children expanded" id="c-root">

                    <!-- FOLDER 1: app -->
                    <div class="tree-item tree-level-2" id="item-folder-app" onclick="toggleFolder('c-app', this)">
                        <span class="tree-chevron" id="chev-app">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>app</span>
                    </div>
                    <div class="tree-children" id="c-app">
                        <!-- subfolder: Http -->
                        <div class="tree-item tree-level-3" id="item-folder-http" onclick="toggleFolder('c-http', this)">
                            <span class="tree-chevron" id="chev-http">▶</span>
                            <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                            <span>Http</span>
                        </div>
                        <div class="tree-children" id="c-http">
                            <!-- subfolder: Controllers -->
                            <div class="tree-item tree-level-4" id="item-folder-controllers" onclick="toggleFolder('c-controllers', this)">
                                <span class="tree-chevron" id="chev-controllers">▶</span>
                                <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                                <span>Controllers</span>
                            </div>
                            <div class="tree-children" id="c-controllers">
                                <!-- FILE: ItemController.php -->
                                <div class="tree-item tree-level-4 ps-5" id="file-ItemController" onclick="showFileCode('ItemController')">
                                    <i class="bi bi-filetype-php icon-php tree-icon"></i>
                                    <span>ItemController.php</span>
                                    <span class="hit-step-badge" id="badge-ItemController">STEP 2</span>
                                </div>
                            </div>
                        </div>

                        <!-- subfolder: Models -->
                        <div class="tree-item tree-level-3" id="item-folder-models" onclick="toggleFolder('c-models', this)">
                            <span class="tree-chevron" id="chev-models">▶</span>
                            <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                            <span>Models</span>
                        </div>
                        <div class="tree-children" id="c-models">
                            <!-- FILE: Item.php -->
                            <div class="tree-item tree-level-4" id="file-ItemModel" onclick="showFileCode('ItemModel')">
                                <i class="bi bi-filetype-php icon-php tree-icon"></i>
                                <span>Item.php</span>
                                <span class="hit-step-badge" id="badge-ItemModel">STEP 3</span>
                            </div>
                        </div>

                        <!-- subfolder: Providers -->
                        <div class="tree-item tree-level-3">
                            <span class="tree-chevron text-muted">▶</span>
                            <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                            <span class="text-secondary">Providers</span>
                        </div>
                    </div>

                    <!-- FOLDER 2: bootstrap -->
                    <div class="tree-item tree-level-2 text-secondary">
                        <span class="tree-chevron">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>bootstrap</span>
                    </div>

                    <!-- FOLDER 3: config -->
                    <div class="tree-item tree-level-2 text-secondary">
                        <span class="tree-chevron">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>config</span>
                    </div>

                    <!-- FOLDER 4: database -->
                    <div class="tree-item tree-level-2" id="item-folder-database" onclick="toggleFolder('c-database', this)">
                        <span class="tree-chevron" id="chev-database">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>database</span>
                    </div>
                    <div class="tree-children" id="c-database">
                        <div class="tree-item tree-level-3">
                            <i class="bi bi-database icon-db tree-icon"></i>
                            <span class="text-info font-monospace">database.sqlite</span>
                        </div>
                    </div>

                    <!-- FOLDER 5: resources -->
                    <div class="tree-item tree-level-2" id="item-folder-resources" onclick="toggleFolder('c-resources', this)">
                        <span class="tree-chevron" id="chev-resources">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>resources</span>
                    </div>
                    <div class="tree-children" id="c-resources">
                        <!-- subfolder: views -->
                        <div class="tree-item tree-level-3" id="item-folder-views" onclick="toggleFolder('c-views', this)">
                            <span class="tree-chevron" id="chev-views">▶</span>
                            <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                            <span>views</span>
                        </div>
                        <div class="tree-children" id="c-views">
                            <!-- subfolder: items -->
                            <div class="tree-item tree-level-4" id="item-folder-items" onclick="toggleFolder('c-items', this)">
                                <span class="tree-chevron" id="chev-items">▶</span>
                                <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                                <span>items</span>
                            </div>
                            <div class="tree-children" id="c-items">
                                <div class="tree-item tree-level-4 ps-5" id="file-indexBlade" onclick="showFileCode('indexBlade')">
                                    <i class="bi bi-file-earmark-code icon-view tree-icon"></i>
                                    <span>index.blade.php</span>
                                    <span class="hit-step-badge" id="badge-indexBlade">STEP 4</span>
                                </div>
                                <div class="tree-item tree-level-4 ps-5" id="file-createBlade" onclick="showFileCode('createBlade')">
                                    <i class="bi bi-file-earmark-code icon-view tree-icon"></i>
                                    <span>create.blade.php</span>
                                    <span class="hit-step-badge" id="badge-createBlade">STEP 4</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FOLDER 6: routes -->
                    <div class="tree-item tree-level-2" id="item-folder-routes" onclick="toggleFolder('c-routes', this)">
                        <span class="tree-chevron" id="chev-routes">▶</span>
                        <i class="bi bi-folder-fill icon-folder tree-icon"></i>
                        <span>routes</span>
                    </div>
                    <div class="tree-children" id="c-routes">
                        <!-- FILE: web.php -->
                        <div class="tree-item tree-level-3" id="file-webRoute" onclick="showFileCode('webRoute')">
                            <i class="bi bi-signpost-2 icon-route tree-icon"></i>
                            <span class="text-warning fw-semibold">web.php</span>
                            <span class="hit-step-badge" id="badge-webRoute">STEP 1</span>
                        </div>
                    </div>

                    <!-- FOLDER 7: vendor -->
                    <div class="tree-item tree-level-2 text-muted">
                        <span class="tree-chevron">▶</span>
                        <i class="bi bi-archive-fill tree-icon"></i>
                        <span>vendor/</span>
                    </div>

                    <!-- ROOT FILES -->
                    <div class="tree-item tree-level-2 text-muted">
                        <i class="bi bi-gear-fill icon-gear tree-icon"></i>
                        <span>.env</span>
                    </div>
                    <div class="tree-item tree-level-2 text-muted">
                        <i class="bi bi-terminal-fill tree-icon text-danger"></i>
                        <span>artisan</span>
                    </div>
                    <div class="tree-item tree-level-2 text-muted">
                        <i class="bi bi-filetype-json tree-icon text-warning"></i>
                        <span>composer.json</span>
                    </div>

                </div>
            </div>

            <!-- =========================================
                 KOLOM KANAN: CODE EDITOR TABS & PREVIEW
                 ========================================= -->
            <div class="col-md-8 col-lg-9 vscode-editor">
                <!-- TABS BAR -->
                <div class="vscode-tabs" id="editorTabs">
                    <div class="vscode-tab active" id="tab-webRoute" onclick="showFileCode('webRoute')">
                        <i class="bi bi-signpost-2 icon-route"></i> routes/web.php
                    </div>
                    <div class="vscode-tab" id="tab-ItemController" onclick="showFileCode('ItemController')">
                        <i class="bi bi-filetype-php icon-php"></i> ItemController.php
                    </div>
                    <div class="vscode-tab" id="tab-ItemModel" onclick="showFileCode('ItemModel')">
                        <i class="bi bi-filetype-php icon-php"></i> Item.php (Model)
                    </div>
                    <div class="vscode-tab" id="tab-indexBlade" onclick="showFileCode('indexBlade')">
                        <i class="bi bi-file-earmark-code icon-view"></i> index.blade.php
                    </div>
                    <div class="vscode-tab text-success" id="tab-browserPreview" onclick="showFileCode('browserPreview')">
                        <i class="bi bi-window-fullscreen"></i> Layar Browser Siswa
                    </div>
                </div>

                <!-- CODE EDITOR CONTENT -->
                <div class="vscode-code-content" id="editorCodeBox">
                    <!-- Dynamic code rendered by JS -->
                </div>

                <!-- EXPLANATION STRIP DI BAWAH EDITOR -->
                <div class="step-explain-card" id="stepExplainBox">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="badge bg-primary" id="explainStepPill">PANDUAN PEMBELAJARAN</span>
                        <span class="text-secondary small" id="explainTime">Siap Uji Coba</span>
                    </div>
                    <h6 class="fw-bold mb-1 text-light" id="explainTitle">Tekan Tombol "Jalankan Alur" di Atas</h6>
                    <p class="text-muted small mb-0" id="explainDesc">
                        Perhatikan bagaimana folder di sebelah kiri akan terbuka satu per satu secara otomatis untuk menemukan file yang bertanggung jawab atas rute URL yang diminta.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- TERMINAL LIVE LOG -->
    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold small text-muted"><i class="bi bi-terminal me-2 text-success"></i>Live Framework Trace Log: File & Method yang Di-HIT</span>
            <button class="btn btn-sm btn-outline-secondary py-0" style="font-size: 0.75rem;" onclick="clearLog()">Clear Log</button>
        </div>
        <div class="code-box p-3 font-monospace" style="height: 110px; font-size: 0.8rem; overflow-y: auto;" id="traceConsole">
            <span class="text-secondary">// Riwayat eksekusi sistem akan tercatat di sini...</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    // DATA KODE FILE UNTUK DITAMPILKAN DI EDITOR
    const fileCodes = {
        webRoute: {
            title: "routes/web.php",
            code: `&lt;?php

use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\ItemController;

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// RUTE-RUTE INVENTARIS LAB
<span id="line-route-index" class="d-block">Route::get('/barang', [ItemController::class, 'index'])->name('items.index');</span>
<span id="line-route-create" class="d-block">Route::get('/barang/tambah', [ItemController::class, 'create'])->name('items.create');</span>
<span id="line-route-store" class="d-block">Route::post('/barang', [ItemController::class, 'store'])->name('items.store');</span>`
        },
        ItemController: {
            title: "app/Http/Controllers/ItemController.php",
            code: `&lt;?php

namespace App\\Http\\Controllers;

use App\\Models\\Item;
use Illuminate\\Http\\Request;

class ItemController extends Controller
{
<span id="line-ctrl-index" class="d-block">    public function index()
    {
        // 1. Panggil Model untuk ambil semua data dari SQLite
        $items = Item::all();

        // 2. Kirim data ke file Blade
        return view('items.index', compact('items'));
    }</span>

<span id="line-ctrl-create" class="d-block">    public function create()
    {
        return view('items.create');
    }</span>

<span id="line-ctrl-store" class="d-block">    public function store(Request $request)
    {
        Item::create($request->all());
        return redirect()->route('items.index');
    }</span>
}`
        },
        ItemModel: {
            title: "app/Models/Item.php",
            code: `&lt;?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class Item extends Model
{
    // Mengizinkan kolom disimpan secara massal (Mass Assignment)
<span id="line-model-fillable" class="d-block">    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'stok',
        'kondisi',
    ];</span>
}`
        },
        indexBlade: {
            title: "resources/views/items/index.blade.php",
            code: `&#64;extends('layouts.app')

&#64;section('content')
&lt;div class="container"&gt;
    &lt;h3&gt;Daftar Inventaris Barang Lab&lt;/h3&gt;
    &lt;table class="table"&gt;
<span id="line-blade-foreach" class="d-block">        &#64;foreach ($items as $item)
            &lt;tr&gt;
                &lt;td&gt;{{ $item->kode_barang }}&lt;/td&gt;
                &lt;td&gt;{{ $item->nama_barang }}&lt;/td&gt;
                &lt;td&gt;{{ $item->stok }} Unit&lt;/td&gt;
            &lt;/tr&gt;
        &#64;endforeach</span>
    &lt;/table&gt;
&lt;/div&gt;
&#64;endsection`
        },
        createBlade: {
            title: "resources/views/items/create.blade.php",
            code: `&#64;extends('layouts.app')

&#64;section('content')
&lt;div class="container"&gt;
    &lt;h3&gt;Form Tambah Barang Lab&lt;/h3&gt;
    &lt;form action="/barang" method="POST"&gt;
<span id="line-blade-csrf" class="d-block">        &#64;csrf &lt;!-- Token Wajib Keamanan --&gt;</span>
        &lt;input type="text" name="kode_barang" placeholder="LAB-005"&gt;
        &lt;input type="text" name="nama_barang" placeholder="Nama Barang"&gt;
        &lt;button type="submit"&gt;Simpan&lt;/button&gt;
    &lt;/form&gt;
&lt;/div&gt;
&#64;endsection`
        },
        browserPreview: {
            title: "Layar Browser Siswa",
            code: `<!-- TAMPILAN AKHIR WEB BROWSER -->`
        }
    };

    let activeTabKey = 'webRoute';
    let isSimulating = false;

    // TOGGLE MANUAL FOLDER KLIK
    function toggleFolder(childrenId, itemEl) {
        const container = document.getElementById(childrenId);
        if (!container) return;
        const chevron = itemEl.querySelector('.tree-chevron');

        if (container.classList.contains('expanded')) {
            container.classList.remove('expanded');
            if (chevron) chevron.classList.remove('open');
        } else {
            container.classList.add('expanded');
            if (chevron) chevron.classList.add('open');
        }
    }

    // EXPAND FOLDER SECARA PROGRAMATIS DENGAN ANIMASI
    function expandFolderProgrammatically(childrenId, chevronId) {
        const container = document.getElementById(childrenId);
        const chevron = document.getElementById(chevronId);
        if (container) container.classList.add('expanded');
        if (chevron) chevron.classList.add('open');
    }

    // RESET SEMUA FOLDER MENUTUP
    function resetAllFolders() {
        document.querySelectorAll('.tree-children').forEach(el => {
            if (el.id !== 'c-root') el.classList.remove('expanded');
        });
        document.querySelectorAll('.tree-chevron').forEach(el => {
            if (!el.parentElement.classList.contains('tree-level-1')) el.classList.remove('open');
        });
        document.querySelectorAll('.tree-item').forEach(el => el.classList.remove('hit-active', 'hit-error'));
        document.querySelectorAll('.hit-step-badge').forEach(el => el.classList.remove('show'));
        showFileCode('webRoute');
        updateExplanation('PANDUAN SISTEM', 'Menunggu Request', 'Tekan Tombol "Jalankan Alur"', 'Pilih salah satu preset tombol rute di atas lalu klik Jalankan Alur untuk mengamati alur kerja framework.');
        document.getElementById('simStatusPill').className = 'badge bg-secondary';
        document.getElementById('simStatusPill').textContent = 'Status: Standby';
    }

    // GANTI TAMPILAN KODE FILE DI EDITOR
    function showFileCode(key) {
        activeTabKey = key;
        document.querySelectorAll('.vscode-tab').forEach(t => t.classList.remove('active'));
        const tabEl = document.getElementById('tab-' + key);
        if (tabEl) tabEl.classList.add('active');

        const editorBox = document.getElementById('editorCodeBox');
        if (key === 'browserPreview') {
            editorBox.innerHTML = `
                <div class="bg-white text-dark p-4 rounded-3 shadow-sm border m-2">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-box-seam me-2"></i>Lab Inventaris SMK - Live Render</h6>
                        <span class="badge bg-success">200 OK</span>
                    </div>
                    <table class="table table-sm table-bordered align-middle small">
                        <thead class="table-light"><tr><th>Kode</th><th>Nama Barang</th><th>Stok</th><th>Kondisi</th></tr></thead>
                        <tbody>
                            <tr><td><span class="badge bg-secondary">LAB-001</span></td><td>PC All-in-One Core i5</td><td>24 Unit</td><td><span class="badge bg-success">Baik</span></td></tr>
                            <tr><td><span class="badge bg-secondary">LAB-002</span></td><td>Router MikroTik RB750Gr3</td><td>12 Unit</td><td><span class="badge bg-success">Baik</span></td></tr>
                        </tbody>
                    </table>
                </div>
            `;
            return;
        }

        const data = fileCodes[key] || fileCodes.webRoute;
        editorBox.innerHTML = `<pre class="mb-0"><code>${data.code}</code></pre>`;
    }

    // UPDATE PENJELASAN DI BAWAH EDITOR
    function updateExplanation(pill, time, title, desc) {
        document.getElementById('explainStepPill').textContent = pill;
        document.getElementById('explainTime').textContent = time;
        document.getElementById('explainTitle').textContent = title;
        document.getElementById('explainDesc').innerHTML = desc;
    }

    // TAMBAHKAN LOG KE TERMINAL
    function logTrace(msg, type = 'info') {
        const consoleEl = document.getElementById('traceConsole');
        const color = type === 'success' ? 'text-success' : (type === 'error' ? 'text-danger fw-bold' : (type === 'warn' ? 'text-warning' : 'text-info'));
        consoleEl.innerHTML += `<span class="${color}">[${new Date().toLocaleTimeString()}] ${msg}</span><br>`;
        consoleEl.scrollTop = consoleEl.scrollHeight;
    }

    function clearLog() {
        document.getElementById('traceConsole').innerHTML = '<span class="text-secondary">// Terminal dibersihkan.</span><br>';
    }

    function setSimScenario(method, url) {
        document.getElementById('simMethod').value = method;
        document.getElementById('simUrl').value = url;
        startFolderAnimation();
    }

    // ==========================================================
    // ANIMASI UTAMA: MEMBUKA FOLDER SATU PERSATU SAAT DI-HIT
    // ==========================================================
    function startFolderAnimation() {
        if (isSimulating) return;
        isSimulating = true;

        const method = document.getElementById('simMethod').value;
        const url = document.getElementById('simUrl').value.trim();
        const speed = parseInt(document.getElementById('simSpeed').value) || 1800;

        document.getElementById('titlebarUrl').innerHTML = `<i class="bi bi-browser-chrome me-1 text-primary"></i> Browser Request: <span class="text-warning">${method} ${url}</span>`;
        document.getElementById('btnRunSim').disabled = true;

        resetAllFolders();
        clearLog();
        logTrace(`Browser mengirimkan HTTP Request: <strong>${method} ${url}</strong>`);
        document.getElementById('simStatusPill').className = 'badge bg-primary';
        document.getElementById('simStatusPill').innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Eksekusi Alur...`;

        // ----------------------------------------------------
        // TAHAP 1: BUKA FOLDER routes/ & HIT web.php
        // ----------------------------------------------------
        updateExplanation('LANGKAH 1 DARI 4', 'Pencocokan Rute', '1. Membuka Folder routes/ & Memeriksa web.php', `Laravel menerima URL <code>${url}</code> dan langsung mencari rute yang cocok di dalam buku menu <strong>routes/web.php</strong>.`);

        expandFolderProgrammatically('c-routes', 'chev-routes');

        setTimeout(() => {
            const fileWeb = document.getElementById('file-webRoute');
            const badgeWeb = document.getElementById('badge-webRoute');

            // Cek apakah rute cocok atau 404
            const isMatch = (url === '/barang' || url === '/barang/tambah');

            if (!isMatch) {
                // KASUS 404 NOT FOUND
                fileWeb.classList.add('hit-error');
                showFileCode('webRoute');
                logTrace(`[404 NOT FOUND] Rute "${method} ${url}" TIDAK DITEMUKAN di routes/web.php!`, 'error');
                logTrace(`&rarr; Eksekusi berhenti. Browser menampilkan layar 404 Not Found. Tidak ada Controller/Model/View yang dijalankan.`, 'warn');

                document.getElementById('simStatusPill').className = 'badge bg-danger';
                document.getElementById('simStatusPill').textContent = '404 Not Found';

                updateExplanation('GAGAL: 404 NOT FOUND', 'Rute Tidak Ada', '❌ Rute Tidak Terdaftar di routes/web.php', `Laravel menelusuri seluruh baris di <strong>routes/web.php</strong> namun tidak menemukan rute <code>${method} ${url}</code>. Karena itu eksekusi berhenti seketika tanpa membuka folder Controller maupun View!`);

                isSimulating = false;
                document.getElementById('btnRunSim').disabled = false;
                return;
            }

            // RUTE COCOK
            fileWeb.classList.add('hit-active');
            badgeWeb.classList.add('show');
            showFileCode('webRoute');

            const routeLine = url.includes('/tambah') ? 'line-route-create' : 'line-route-index';
            setTimeout(() => {
                const elLine = document.getElementById(routeLine);
                if (elLine) elLine.classList.add('highlight-line');
            }, 100);

            logTrace(`[HIT: routes/web.php] Rute "${method} ${url}" COCOK! Diarahkan ke ItemController.`, 'success');

            // ----------------------------------------------------
            // TAHAP 2: BUKA FOLDER app/ -> Http/ -> Controllers/ -> ItemController.php
            // ----------------------------------------------------
            setTimeout(() => {
                updateExplanation('LANGKAH 2 DARI 4', 'Eksekusi Logika', '2. Membuka app/Http/Controllers/ & Menjalankan ItemController', `Route mengarahkan alur ke controller. Folder <strong>app/</strong>, <strong>Http/</strong>, dan <strong>Controllers/</strong> terbuka satu per satu.`);

                expandFolderProgrammatically('c-app', 'chev-app');
                setTimeout(() => expandFolderProgrammatically('c-http', 'chev-http'), 200);
                setTimeout(() => expandFolderProgrammatically('c-controllers', 'chev-controllers'), 400);

                setTimeout(() => {
                    const fileCtrl = document.getElementById('file-ItemController');
                    const badgeCtrl = document.getElementById('badge-ItemController');
                    fileCtrl.classList.add('hit-active');
                    badgeCtrl.classList.add('show');
                    showFileCode('ItemController');

                    const methodLine = url.includes('/tambah') ? 'line-ctrl-create' : 'line-ctrl-index';
                    setTimeout(() => {
                        const elLine = document.getElementById(methodLine);
                        if (elLine) elLine.classList.add('highlight-line');
                    }, 100);

                    const methodName = url.includes('/tambah') ? 'create()' : 'index()';
                    logTrace(`[HIT: app/Http/Controllers/ItemController.php] Menjalankan method <strong>${methodName}</strong>.`, 'success');

                    // ----------------------------------------------------
                    // TAHAP 3: BUKA FOLDER app/Models/ -> Item.php (JIKA /barang)
                    // ----------------------------------------------------
                    setTimeout(() => {
                        if (!url.includes('/tambah')) {
                            updateExplanation('LANGKAH 3 DARI 4', 'Database Query', '3. Membuka app/Models/ & Menjalankan Item::all()', `Controller membutuhkan data barang, sehingga folder <strong>app/Models/</strong> terbuka untuk memanggil <strong>Item.php</strong> yang mengambil data tabel dari SQLite.`);

                            expandFolderProgrammatically('c-models', 'chev-models');
                            expandFolderProgrammatically('c-database', 'chev-database');

                            setTimeout(() => {
                                const fileModel = document.getElementById('file-ItemModel');
                                const badgeModel = document.getElementById('badge-ItemModel');
                                fileModel.classList.add('hit-active');
                                badgeModel.classList.add('show');
                                showFileCode('ItemModel');

                                logTrace(`[HIT: app/Models/Item.php] Mengeksekusi query <code>Item::all()</code> ke database/database.sqlite.`, 'warn');
                            }, 300);
                        } else {
                            logTrace(`[SKIP: Models] Form tambah tidak memerlukan query data tabel, lanjut ke View.`, 'info');
                        }

                        // ----------------------------------------------------
                        // TAHAP 4: BUKA FOLDER resources/views/items/ -> Blade View
                        // ----------------------------------------------------
                        setTimeout(() => {
                            const viewFileKey = url.includes('/tambah') ? 'createBlade' : 'indexBlade';
                            const viewFileName = url.includes('/tambah') ? 'create.blade.php' : 'index.blade.php';

                            updateExplanation('LANGKAH 4 DARI 4', 'Render Tampilan', `4. Membuka resources/views/items/ & Merender ${viewFileName}`, `Data telah siap! Controller menyerahkan data ke file Blade di dalam <strong>resources/views/items/${viewFileName}</strong> untuk dikonversi menjadi HTML.`);

                            expandFolderProgrammatically('c-resources', 'chev-resources');
                            setTimeout(() => expandFolderProgrammatically('c-views', 'chev-views'), 200);
                            setTimeout(() => expandFolderProgrammatically('c-items', 'chev-items'), 400);

                            setTimeout(() => {
                                const fileBlade = document.getElementById('file-' + viewFileKey);
                                const badgeBlade = document.getElementById('badge-' + viewFileKey);
                                if (fileBlade) fileBlade.classList.add('hit-active');
                                if (badgeBlade) badgeBlade.classList.add('show');

                                showFileCode(viewFileKey);
                                logTrace(`[HIT: resources/views/items/${viewFileName}] Template Blade berhasil di-compile menjadi respons HTML.`, 'success');
                                logTrace(`[200 OK SUCCESS] Siklus alur request selesai! Halaman tampil di browser siswa.`, 'success');

                                document.getElementById('simStatusPill').className = 'badge bg-success';
                                document.getElementById('simStatusPill').textContent = '200 OK (Selesai)';

                                setTimeout(() => {
                                    showFileCode('browserPreview');
                                    updateExplanation('ALUR SELESAI', '200 OK', '🎉 Siklus Request-Response Lengkap Selesai!', `Siswa telah melihat sendiri bahwa 1 klik di browser melibatkan pembukaan folder <strong>routes/</strong> &rarr; <strong>app/Http/Controllers/</strong> &rarr; <strong>app/Models/</strong> &rarr; <strong>resources/views/</strong> secara harmonis.`);
                                    isSimulating = false;
                                    document.getElementById('btnRunSim').disabled = false;
                                }, speed);

                            }, 450);

                        }, speed);

                    }, speed);

                }, 450);

            }, speed);

        }, 600);
    }

    // LOAD DEFAULT KODE PADA AWAL HALAMAN
    document.addEventListener('DOMContentLoaded', () => {
        showFileCode('webRoute');
    });
</script>
@endverbatim
@endpush
