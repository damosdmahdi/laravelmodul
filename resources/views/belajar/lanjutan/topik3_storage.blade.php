@extends('layouts.belajar')

@section('title', 'Topik 3: File Storage & Arsitektur Symlink - Belajar Laravel SMK')

@push('styles')
<style>
    .code-box-header {
        background: #111827;
        padding: 8px 16px;
        font-size: 0.78rem;
        font-family: 'Fira Code', monospace;
        color: #94a3b8;
        border-bottom: 1px solid #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .code-editor-body {
        background: #050811;
        padding: 16px;
        font-family: 'Fira Code', Consolas, monospace;
        font-size: 0.86rem;
        line-height: 1.7;
        color: #cbd5e1;
        overflow-x: auto;
    }
    .code-editor-body .kw { color: #f43f5e; font-weight: 600; }
    .code-editor-body .fn { color: #38bdf8; font-weight: 600; }
    .code-editor-body .str { color: #4ade80; }
    .code-editor-body .cm { color: #64748b; font-style: italic; }
    .code-editor-body .cls { color: #fbbf24; font-weight: 600; }
    .code-editor-body .var { color: #e2e8f0; }

    /* Storage Cross Section */
    .storage-partition {
        background: #0f172a;
        border: 2px dashed #334155;
        border-radius: 10px;
        padding: 16px;
        position: relative;
    }
    .symlink-arrow {
        position: relative;
        font-weight: 700;
        color: #38bdf8;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5 py-4">

    <!-- BREADCRUMB & HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('belajar.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('belajar.materi.lanjutan') }}" class="text-decoration-none">Materi Lanjutan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Topik 3: Storage &amp; Symlink</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info text-dark px-3 py-1">Topik 3 dari 7</span>
            <span class="badge bg-dark border border-secondary text-light">Filesystem Architecture</span>
        </div>
    </div>

    <!-- TITLE BANNER -->
    <div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0e7490 0%, #0f172a 100%); border-left: 6px solid #06b6d4;">
        <div class="card-body p-4 p-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-1 text-white">
                        <i class="bi bi-hdd-network-fill text-warning me-2"></i>File Storage, Validasi Upload &amp; Arsitektur Symlink
                    </h2>
                    <p class="text-light text-opacity-80 mb-0 small">
                        Mengapa file pengguna dilarang diletakkan langsung di dalam folder <code>public/</code>, bagaimana perintah <code>php artisan storage:link</code> menciptakan jembatan virtual OS, dan cara validasi MIME type yang aman.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('belajar.materi.lanjutan.2') }}" class="btn btn-outline-light btn-sm me-1">
                        <i class="bi bi-arrow-left me-1"></i> Topik 2
                    </a>
                    <a href="{{ route('belajar.materi.lanjutan.4') }}" class="btn btn-info text-dark btn-sm fw-bold">
                        Lanjut ke Topik 4 <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TEORI & PENJELASAN KEAMANAN -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Bahaya Fatal Menaruh Upload di Folder `public/`
                </h5>
                <p class="text-secondary small mb-3">
                    Banyak pemula tergoda menggunakan fungsi PHP native <code>move_uploaded_file()</code> langsung ke folder <code>public/uploads/</code>. Di dunia profesional, ini adalah celah kritis:
                </p>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-2"><strong>1. Bahaya Remote Code Execution (RCE):</strong> Jika pengguna mengunggah file berbahaya <code>shell.php</code> ke web root publik, peretas dapat langsung memanggil <code>https://domain.id/uploads/shell.php</code> di browser. Web server Apache/Nginx akan mengeksekusi kode PHP tersebut dan peretas langsung menguasai server Anda!</li>
                    <li class="mb-2"><strong>2. Mengotori Git Repository:</strong> Folder <code>public</code> berisi aset inti framework yang dilacak Git. File banner atau foto produk pengguna yang dinamis harus dipisahkan dari version control.</li>
                    <li class="mb-0"><strong>3. Kesiapan Cloud Storage:</strong> Jika aplikasi Anda berkembang dan menggunakan Amazon S3 atau Google Cloud Storage, kode yang menggunakan path statis folder publik akan rusak total. Abstraksi <code>Storage::disk('public')</code> memungkinkan migrasi mulus tanpa mengubah 1 baris pun kode controller!</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-info mb-3">
                    <i class="bi bi-link-45deg me-2"></i>Solusi Laravel: Isolasi Privat &amp; Symbolic Link
                </h5>
                <p class="text-secondary small mb-3">
                    Laravel memecahkan dilema keamanan ini dengan sangat cerdas menggunakan fitur bawaan sistem operasi:
                </p>
                <div class="alert alert-info py-2 small mb-3">
                    1. File disimpan di folder privat yang terkunci: <code>storage/app/public/banners/</code>.<br>
                    2. Perintah <code>php artisan storage:link</code> membuat **Symbolic Link (Shortcut Inode)** dari <code>public/storage</code> mengarah ke folder privat tersebut.<br>
                    3. Browser pengunjung membaca file lewat URL publik: <code>asset('storage/banners/...')</code>. Web server menyajikan file secara statis tanpa mengeksekusi PHP!
                </div>
                <h6 class="fw-bold text-dark mb-2">Validasi File yang Ketat:</h6>
                <p class="small text-secondary mb-0">
                    Jangan hanya memeriksa ekstensi file! Gunakan aturan <code>image|mimes:jpeg,png,webp|max:2048</code> di mana Laravel membaca *magic bytes* header biner file untuk memastikan file tersebut benar-benar gambar asli, bukan script berbahaya yang disamarkan.
                </p>
            </div>
        </div>
    </div>

    <!-- KODE ASLI LARAVEL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-code-square text-warning me-2"></i>Penerapan Kode Asli Upload &amp; Hapus File Lama</h5>
            <span class="badge bg-secondary font-monospace">Real Code Implementation</span>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3 bg-light border-bottom-0" id="topic3Tabs">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab3Controller">
                        <i class="bi bi-cpu text-info me-1"></i>app/Http/Controllers/UkkController.php
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab3Config">
                        <i class="bi bi-gear text-secondary me-1"></i>config/filesystems.php
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="topic3TabsContent">
                <div class="tab-pane fade show active" id="tab3Controller">
                    <div class="code-box-header">
                        <span><i class="bi bi-cpu me-1"></i>VALIDASI UPLOAD, PENYIMPANAN HASH &amp; HAPUS GAMBAR LAMA</span>
                        <span class="badge bg-info text-dark">app/Http/Controllers/UkkController.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="kw">use</span> Illuminate\Support\Facades\<span class="cls">Storage</span>;<br><br>
<span class="kw">public function</span> <span class="fn">updatePortfolio</span>(<span class="cls">Request</span> <span class="var">$request</span>, <span class="var">$id</span>)<br>
{<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span> = <span class="cls">Portfolio</span>::<span class="fn">findOrFail</span>(<span class="var">$id</span>);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 1. Validasi MIME Type & Ukuran Maksimal 2MB (2048 KB)</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$request</span>-&gt;<span class="fn">validate</span>([<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'banner'</span> =&gt; <span class="str">'nullable|image|mimes:jpeg,png,webp|max:2048'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// 2. Jika user mengunggah banner baru, simpan file & hapus banner lama!</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (<span class="var">$request</span>-&gt;<span class="fn">hasFile</span>(<span class="str">'banner'</span>)) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Hapus file gambar lama agar tidak menumpuk jadi sampah disk:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">if</span> (<span class="var">$portfolio</span>-&gt;banner &amp;&amp; <span class="cls">Storage</span>::<span class="fn">disk</span>(<span class="str">'public'</span>)-&gt;<span class="fn">exists</span>(<span class="var">$portfolio</span>-&gt;banner)) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cls">Storage</span>::<span class="fn">disk</span>(<span class="str">'public'</span>)-&gt;<span class="fn">delete</span>(<span class="var">$portfolio</span>-&gt;banner);<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Simpan file baru dengan hash acak di: storage/app/public/banners/</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span>-&gt;banner = <span class="var">$request</span>-&gt;<span class="fn">file</span>(<span class="str">'banner'</span>)-&gt;<span class="fn">store</span>(<span class="str">'banners'</span>, <span class="str">'public'</span>);<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$portfolio</span>-&gt;<span class="fn">save</span>();<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">back</span>()-&gt;<span class="fn">with</span>(<span class="str">'success'</span>, <span class="str">'Banner berhasil diperbarui!'</span>);<br>
}
                    </div>
                </div>

                <div class="tab-pane fade" id="tab3Config">
                    <div class="code-box-header">
                        <span><i class="bi bi-gear me-1"></i>KONFIGURASI MULTI-DISK LARAVEL</span>
                        <span class="badge bg-secondary">config/filesystems.php</span>
                    </div>
                    <div class="code-editor-body">
<span class="str">'disks'</span> =&gt; [<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'public'</span> =&gt; [<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'driver'</span> =&gt; <span class="str">'local'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'root'</span> =&gt; <span class="fn">storage_path</span>(<span class="str">'app/public'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'url'</span> =&gt; <span class="fn">env</span>(<span class="str">'APP_URL'</span>) . <span class="str">'/storage'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'visibility'</span> =&gt; <span class="str">'public'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;],<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="cm">// Siap untuk cloud storage tanpa ubah controller:</span><br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'s3'</span> =&gt; [<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'driver'</span> =&gt; <span class="str">'s3'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'key'</span> =&gt; <span class="fn">env</span>(<span class="str">'AWS_ACCESS_KEY_ID'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="str">'bucket'</span> =&gt; <span class="fn">env</span>(<span class="str">'AWS_BUCKET'</span>),<br>
&nbsp;&nbsp;&nbsp;&nbsp;],<br>
],
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF PENAMPANG PARTISI -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#090d16; border:1px solid #1e293b;">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-circle-fill text-info me-2"></i>Simulator Interaktif: Penampang Partisi Server &amp; Jembatan Inode Symlink</span>
            <span class="badge bg-info text-dark">Filesystem Inspector</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h6 class="fw-bold text-info mb-2">Pilih Sampel Payload File:</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="p-2 border border-secondary rounded-3 cursor-pointer d-flex align-items-center gap-2" id="choiceJpg" onclick="selectSampleFile('banner.jpg', 'image/jpeg', 720)">
                                <i class="bi bi-file-earmark-image fs-3 text-success"></i>
                                <div>
                                    <strong class="d-block text-white small">banner.jpg (720 KB)</strong>
                                    <span class="badge bg-success" style="font-size:0.65rem;">Gambar Asli &amp; Sah</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-2 border border-secondary rounded-3 cursor-pointer d-flex align-items-center gap-2" id="choicePhp" onclick="selectSampleFile('shell.php', 'application/x-php', 8)">
                                <i class="bi bi-file-earmark-code fs-3 text-danger"></i>
                                <div>
                                    <strong class="d-block text-white small">shell.php (8 KB)</strong>
                                    <span class="badge bg-danger" style="font-size:0.65rem;">Payload Script Jahat</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-2 border border-secondary rounded-3 cursor-pointer d-flex align-items-center gap-2" id="choiceOversize" onclick="selectSampleFile('video_banner.png', 'image/png', 5800)">
                                <i class="bi bi-file-earmark-image fs-3 text-warning"></i>
                                <div>
                                    <strong class="d-block text-white small">oversize.png (5.8 MB)</strong>
                                    <span class="badge bg-warning text-dark" style="font-size:0.65rem;">Ukuran Melebihi 2MB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-info text-dark fw-bold w-100 py-2 mb-3" onclick="runSymlinkPipelineAnimation()">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Eksekusi Upload ke Server
                    </button>
                </div>

                <div class="col-lg-8">
                    <!-- Partition Layout Cross Section -->
                    <div class="row g-2 mb-3">
                        <div class="col-5">
                            <div class="storage-partition text-center" id="partStorage">
                                <span class="badge bg-secondary mb-1" style="font-size:0.65rem;">Folder Privat Terkunci</span>
                                <div class="small fw-bold text-white mb-1" style="font-size:0.75rem;">storage/app/public/</div>
                                <div class="p-2 bg-dark rounded border border-secondary text-truncate" style="font-size:0.68rem;" id="storageFileBox">
                                    <i class="bi bi-file-lock text-muted me-1"></i>(Kosong)
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="symlink-arrow small fw-bold" style="font-size:0.68rem;">Symlink</div>
                            <i class="bi bi-arrow-left-right text-info fs-5" id="symlinkIcon"></i>
                            <span class="badge bg-secondary" style="font-size:0.58rem;" id="symlinkBadge">Inactive</span>
                        </div>
                        <div class="col-5">
                            <div class="storage-partition text-center" id="partPublic">
                                <span class="badge bg-success mb-1" style="font-size:0.65rem;">Folder Publik Internet</span>
                                <div class="small fw-bold text-white mb-1" style="font-size:0.75rem;">public/storage/</div>
                                <div class="p-2 bg-dark rounded border border-secondary text-truncate" style="font-size:0.68rem;" id="publicFileBox">
                                    <i class="bi bi-globe text-muted me-1"></i>(Belum terhubung)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Console Readout -->
                    <div class="bg-black p-3 rounded-3 border border-secondary font-monospace" style="font-size: 0.78rem; min-height: 100px;" id="simSymlinkConsole">
                        <span class="text-muted">// Pilih payload file di sebelah kiri dan klik "Eksekusi Upload ke Server"...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('belajar.materi.lanjutan.2') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Topik 2: Relasi &amp; N+1 Query
            </a>
            <a href="{{ route('belajar.materi.lanjutan') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-grid me-1"></i> Menu Silabus 7 Topik
            </a>
            <a href="{{ route('belajar.materi.lanjutan.4') }}" class="btn btn-info text-dark fw-bold">
                Topik 4: Database Transactions <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

@push('scripts')
@verbatim
<script>
    let sampleFile = { name: 'banner.jpg', mime: 'image/jpeg', sizeKb: 720 };

    function selectSampleFile(name, mime, sizeKb) {
        sampleFile = { name, mime, sizeKb };
        ['choiceJpg', 'choicePhp', 'choiceOversize'].forEach(id => {
            document.getElementById(id).classList.remove('border-info', 'bg-dark');
        });
        if (name.endsWith('.jpg')) document.getElementById('choiceJpg').classList.add('border-info', 'bg-dark');
        if (name.endsWith('.php')) document.getElementById('choicePhp').classList.add('border-info', 'bg-dark');
        if (name.endsWith('.png')) document.getElementById('choiceOversize').classList.add('border-info', 'bg-dark');
    }

    function runSymlinkPipelineAnimation() {
        const consoleEl = document.getElementById('simSymlinkConsole');
        const storageBox = document.getElementById('storageFileBox');
        const publicBox = document.getElementById('publicFileBox');
        const badge = document.getElementById('symlinkBadge');
        const icon = document.getElementById('symlinkIcon');

        consoleEl.innerHTML = '<span class="text-info">[UPLOAD] Menerima form multipart: "' + sampleFile.name + '" (' + sampleFile.sizeKb + ' KB)...</span><br>';

        setTimeout(() => {
            if (sampleFile.mime === 'application/x-php') {
                consoleEl.innerHTML += '<span class="text-danger fw-bold">[KEAMANAN DITOLAK] Deteksi file berbahaya! Ekstensi .php dilarang oleh aturan validator `image|mimes:jpeg,png,webp`. File dimusnahkan seketika!</span>';
                storageBox.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>Ditolak Validator</span>';
                return;
            }

            if (sampleFile.sizeKb > 2048) {
                consoleEl.innerHTML += '<span class="text-warning fw-bold">[VALIDASI GAGAL] Ukuran file ' + (sampleFile.sizeKb / 1024).toFixed(1) + ' MB melebihi kuota `max:2048` (2 MB)!</span>';
                storageBox.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Ukuran Terlalu Besar</span>';
                return;
            }

            consoleEl.innerHTML += '<span class="text-success">[VALIDASI SUKSES] File diverifikasi sebagai gambar asli (MIME: ' + sampleFile.mime + ').</span><br>';
            storageBox.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check2-circle me-1"></i>banners/hash_99a.jpg</span>';
            consoleEl.innerHTML += '<span class="text-info">[STORAGE] File disimpan di folder privat yang aman dari akses publik langsung: `storage/app/public/banners/hash_99a.jpg`.</span><br>';

            setTimeout(() => {
                badge.className = 'badge bg-success';
                badge.innerText = 'Active Linked';
                icon.className = 'bi bi-arrow-left-right text-success fs-4';
                publicBox.innerHTML = '<span class="text-info fw-bold"><i class="bi bi-link-45deg me-1"></i>/storage/banners/hash_99a.jpg</span>';
                consoleEl.innerHTML += '<span class="text-success fw-bold">[SYMLINK RESOLVED] Inode link aktif! Nginx langsung menyajikan file ke browser pengunjung via URL `asset("storage/banners/hash_99a.jpg")` tanpa membebani PHP!</span>';
            }, 600);
        }, 400);
    }

    document.addEventListener('DOMContentLoaded', function() {
        selectSampleFile('banner.jpg', 'image/jpeg', 720);
    });
</script>
@endverbatim
@endpush
@endsection
