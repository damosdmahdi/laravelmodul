@extends('layouts.belajar')

@section('title', 'Modul 5: Eloquent ORM & Form CSRF - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 5: Eloquent ORM & Rahasia Proteksi Form &#64;csrf</h3>
            <p class="text-muted small mb-0">Penerapan nyata di industri, panduan Do's & Don'ts, dan simulator uji serangan SQL Injection vs CSRF</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul4') }}" class="btn btn-outline-secondary btn-sm">Modul 4</a>
            <a href="{{ route('belajar.modul6') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 6 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- 1. PENERAPAN DI DUNIA NYATA & FILOSOFI -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-info text-dark px-3 py-2 fw-semibold"><i class="bi bi-magic me-1"></i> Standar ORM Industri</span>
                    <span class="badge bg-white text-dark border">Eloquent vs SQL Mentah</span>
                </div>
                <h5 class="fw-bold text-dark mb-2">Apa Keunggulan Eloquent di Industri?</h5>
                <p class="text-secondary small mb-3">
                    Di PHP native, kamu harus menulis query SQL panjang:
                    <br><code class="text-danger">"SELECT * FROM items WHERE kode_barang = '$kode' AND stok > 0"</code>.
                    <br>Jika salah tanda kutip satu saja, aplikasi langsung crash.
                </p>
                <p class="small mb-2">
                    Di Laravel, tabel <code>items</code> diwakili oleh sebuah Class PHP bernama <code>Item</code> yang bersih dan elegan:
                </p>
                <div class="code-box p-3 small mb-0">
                    <span class="token-comment">// Ambil semua data:</span><br>
                    <span class="token-var">$barang</span> = Item::<span class="token-class">all</span>();<br><br>
                    <span class="token-comment">// Simpan data baru otomatis:</span><br>
                    Item::<span class="token-class">create</span>([<br>
                    &nbsp;&nbsp;<span class="token-string">'kode_barang'</span> => <span class="token-var">$request</span>->kode_barang,<br>
                    &nbsp;&nbsp;<span class="token-string">'nama_barang'</span> => <span class="token-var">$request</span>->nama_barang,<br>
                    ]);
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 border border-info">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary text-white px-3 py-2 fw-semibold"><i class="bi bi-shield-lock-fill me-1"></i> Keamanan Transaksi</span>
                    <span class="badge bg-light text-dark border">Token Anti-Pemalsuan</span>
                </div>
                <h5 class="fw-bold text-dark mb-2">Kenapa Wajib Ada <code>&#64;csrf</code> di Setiap Form?</h5>
                <p class="text-secondary small mb-3">
                    <strong>CSRF (Cross-Site Request Forgery)</strong> adalah serangan di mana website penipu bisa diam-diam mengirimkan request POST atas nama pengguna yang sedang login tanpa disadari.
                </p>
                <div class="alert alert-warning small mb-0">
                    <strong>Hukum Wajib Laravel:</strong> Setiap form dengan <code>method="POST"</code> <strong>WAJIB</strong> menyertakan tag <code>&#64;csrf</code>. Laravel secara cerdas memeriksa token rahasia ini di setiap request. Jika tidak ada, Laravel menolaknya dengan error <strong>419 | Page Expired</strong>!
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SIMULATOR INTERAKTIF: UJI SERANGAN SQL INJECTION (RAW SQL VS ELOQUENT) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-dark text-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-bug-fill text-danger me-2"></i>Simulator Interaktif: Uji Coba Serangan SQL Injection</h5>
                <span class="text-secondary small">Bandingkan bagaimana Raw SQL dibobol vs bagaimana Eloquent ORM kebal dari serangan</span>
            </div>
            <span class="badge bg-danger" id="sqliStatusPill">Uji Keamanan</span>
        </div>

        <div class="row g-4 align-items-center">
            <!-- INPUT SERANGAN -->
            <div class="col-lg-5">
                <div class="p-3 bg-secondary bg-opacity-25 rounded-3 border border-secondary mb-3">
                    <label class="form-label small fw-bold text-warning d-block mb-1">Coba Masukkan Input Pencarian Kode Barang:</label>
                    <div class="input-group input-group-sm mb-2">
                        <input type="text" class="form-control font-monospace" id="sqliInput" value="LAB-001' OR '1'='1">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="setSqliInput('LAB-001')">Input Normal (LAB-001)</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="setSqliInput(`LAB-001' OR '1'='1`)">Input Serangan Hacker</button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger btn-sm fw-bold py-2 shadow-sm" onclick="testRawSql()">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> 1. Uji dengan PHP Native Raw SQL (Rentan!)
                    </button>
                    <button type="button" class="btn btn-success btn-sm fw-bold py-2 shadow-sm" onclick="testEloquentSql()">
                        <i class="bi bi-shield-check me-1"></i> 2. Uji dengan Laravel Eloquent (Aman!)
                    </button>
                </div>
            </div>

            <!-- TERMINAL HASIL SERANGAN -->
            <div class="col-lg-7">
                <label class="form-label fw-bold small text-light"><i class="bi bi-terminal me-1 text-info"></i> Output Hasil Eksekusi Database:</label>
                <div class="code-box p-3 font-monospace" id="sqliOutputBox" style="min-height: 200px; font-size: 0.8rem;">
                    <span class="text-secondary">// Klik salah satu tombol uji di samping kiri untuk mengamati perbedaan Raw SQL vs Eloquent...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SIMULATOR INTERAKTIF: SAKLAR CSRF ERROR 419 (EXISTING ENHANCED) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-toggle-on text-warning me-2"></i>Laboratorium Uji Coba Form & Proteksi CSRF (Error 419)</span>
            <span class="badge bg-primary">Uji Coba Langsung</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <!-- PANEL SAKLAR -->
                <div class="col-lg-5">
                    <div class="p-3 rounded-3 bg-light border mb-3">
                        <label class="form-label fw-bold small text-dark d-block">Saklar Uji Keamanan:</label>
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input" type="checkbox" id="csrfSwitch" checked onchange="toggleCsrfSwitch()">
                            <label class="form-check-label fs-6 fw-semibold" for="csrfSwitch" id="csrfSwitchLabel">
                                <span class="text-success"><i class="bi bi-shield-check me-1"></i> Proteksi @csrf AKTIF (Aman)</span>
                            </label>
                        </div>
                        <div class="form-text small mt-2" id="csrfHelpText">
                            Token rahasia terpasang di form. Form siap dikirim dengan aman.
                        </div>
                    </div>

                    <div class="p-3 rounded-3 bg-white border">
                        <label class="form-label fw-bold small">Simulasi Isi Form Barang:</label>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm" id="simKode" value="LAB-005" placeholder="Kode Barang">
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm" id="simNama" value="Kabel HDMI 3 Meter" placeholder="Nama Barang">
                        </div>
                        <button type="button" class="btn btn-primary btn-sm w-100 py-2 fw-semibold" onclick="submitCsrfSim()">
                            <i class="bi bi-send-fill me-1"></i> Coba Kirim Form (Simulasi)
                        </button>
                    </div>
                </div>

                <!-- HASIL RESPON SERVER -->
                <div class="col-lg-7">
                    <label class="form-label fw-bold small text-dark"><i class="bi bi-terminal me-1"></i> Respons Server Laravel Saat Menerima Request:</label>
                    <div class="border rounded-3 p-4 bg-light shadow-sm text-center" id="csrfResultBox" style="min-height: 220px;">
                        <i class="bi bi-shield-check text-success fs-1 mb-2 d-block"></i>
                        <h6 class="fw-bold text-dark">Form Belum Disubmit</h6>
                        <p class="text-muted small">
                            Coba matikan saklar <strong>@csrf</strong> di samping kiri lalu tekan tombol kirim untuk melihat bagaimana Laravel menolak form tanpa proteksi!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. DO'S & DON'TS ELOQUENT & FORM -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-shaded text-primary me-2"></i>Panduan Do's & Don'ts Model Eloquent & Form
            </h5>
            <span class="badge bg-danger text-white">Praktik Benar vs Salah</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- SISI KIRI: JANGAN DILAKUKAN -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-danger bg-danger-subtle h-100">
                        <h6 class="fw-bold text-danger mb-3">
                            <i class="bi bi-x-circle-fill me-2"></i>❌ JANGAN DILAKUKAN:
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan menggunakan <code>protected $guarded = [];</code> tanpa validasi ketat!</strong>
                                    <div class="text-muted">Ini membuka celah Mass Assignment Vulnerability di mana pengguna iseng bisa menyisipkan input tersembunyi seperti <code>&lt;input name="is_admin" value="1"&gt;</code> ke database.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan menyambung string langsung ke query SQL (Raw SQL)!</strong>
                                    <div class="text-muted">Menulis <code>"WHERE kode = '$input'"</code> sangat berbahaya karena hacker bisa menyisipkan string <code>' OR '1'='1</code> yang membocorkan seluruh database.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan lupa tag <code>&#64;csrf</code> di form POST!</strong>
                                    <div class="text-muted">Setiap form POST tanpa @csrf akan ditolak mentah-mentah oleh middleware Laravel dengan kode HTTP 419 Page Expired.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SISI KANAN: SEBAIKNYA DILAKUKAN -->
                <div class="col-md-6">
                    <div class="p-3 rounded-3 border border-success bg-success-subtle h-100">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>✅ SEBAIKNYA DILAKUKAN:
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Gunakan selalu <code>protected $fillable = [...]</code>!</strong>
                                    <div class="text-muted">Daftarkan kolom apa saja yang diizinkan untuk diisi massal oleh form (contoh: <code>kode_barang</code>, <code>nama_barang</code>, <code>stok</code>).</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Manfaatkan fitur ORM: <code>Item::where(...)->first()</code>!</strong>
                                    <div class="text-muted">Eloquent secara otomatis menggunakan PDO Prepared Statements yang membuat serangan SQL Injection mustahil tembus.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Tulis <code>&#64;csrf</code> tepat di bawah tag <code>&lt;form&gt;</code>!</strong>
                                    <div class="text-muted">Jadikan kebiasaan otomatis: setiap mengetik form POST, baris pertama berikutnya selalu <code>&#64;csrf</code>.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    function setSqliInput(val) {
        document.getElementById('sqliInput').value = val;
    }

    function testRawSql() {
        const input = document.getElementById('sqliInput').value;
        const box = document.getElementById('sqliOutputBox');
        const pill = document.getElementById('sqliStatusPill');

        box.innerHTML = `
<span class="text-danger fw-bold">[RAW PHP NATIVE SQL DIJALANKAN]</span><br>
<span class="text-white">$query = "SELECT * FROM items WHERE kode_barang = '$input'";</span><br>
<span class="text-warning">Query Kompilasi: SELECT * FROM items WHERE kode_barang = '${input}'</span><br><br>
`;

        if (input.includes(`' OR '1'='1`)) {
            pill.className = 'badge bg-danger';
            pill.textContent = '🚨 DATABASE JEBOL!';
            box.innerHTML += `
<span class="text-danger fw-bold">🚨 [ALERTA: SQL INJECTION BERHASIL TEMBUS!]</span><br>
<span class="text-white">Karena kondisi '1'='1' selalu bernilai TRUE, database mengembalikan SELURUH BARANG:</span><br>
<span class="text-info">&bull; LAB-001 (PC Core i5)</span><br>
<span class="text-info">&bull; LAB-002 (Router MikroTik)</span><br>
<span class="text-info">&bull; LAB-003 (Crimping Tool)</span><br>
<span class="text-info">&bull; LAB-004 (Switch D-Link)</span><br>
<span class="text-danger">&rarr; Akibat: Hacker berhasil membocorkan seluruh data inventaris sekolah!</span>
            `;
        } else {
            pill.className = 'badge bg-secondary';
            pill.textContent = 'Query Biasa';
            box.innerHTML += `
<span class="text-success">[HASIL]: Menemukan 1 data dengan kode '${input}'.</span><br>
<span class="text-muted">(Query berjalan normal karena tidak ada karakter manipulasi kutip).</span>
            `;
        }
    }

    function testEloquentSql() {
        const input = document.getElementById('sqliInput').value;
        const box = document.getElementById('sqliOutputBox');
        const pill = document.getElementById('sqliStatusPill');

        pill.className = 'badge bg-success';
        pill.textContent = '🛡️ ELOQUENT AMAN 100%';

        box.innerHTML = `
<span class="text-success fw-bold">[LARAVEL ELOQUENT ORM DIJALANKAN]</span><br>
<span class="text-white">$item = Item::where('kode_barang', $input)->first();</span><br>
<span class="text-info">Prepared Statement: SELECT * FROM items WHERE kode_barang = ? [Param: "${input}"]</span><br><br>
<span class="text-success fw-bold">🛡️ [HASIL: SERANGAN GAGAL!]</span><br>
<span class="text-white">Eloquent memperlakukan karakter <code class="text-warning">' OR '1'='1</code> sebagai teks murni biasa, bukan perintah SQL!</span><br>
<span class="text-muted">&rarr; Hasil Query: null (Tidak ada barang dengan kode literal '${input}').</span><br>
<span class="text-success">&rarr; Database aman 100% dari SQL Injection!</span>
        `;
    }

    function toggleCsrfSwitch() {
        const isChecked = document.getElementById('csrfSwitch').checked;
        const label = document.getElementById('csrfSwitchLabel');
        const help = document.getElementById('csrfHelpText');

        if (isChecked) {
            label.innerHTML = '<span class="text-success"><i class="bi bi-shield-check me-1"></i> Proteksi @csrf AKTIF (Aman)</span>';
            help.textContent = 'Token rahasia terpasang di form. Form siap dikirim dengan aman.';
        } else {
            label.innerHTML = '<span class="text-danger"><i class="bi bi-shield-slash me-1"></i> Tag @csrf DIMATIKAN (Bahaya / Error!)</span>';
            help.textContent = 'Tag @csrf sengaja dihilangkan. Server Laravel akan mendeteksi permintaan ini sebagai serangan tidak sah.';
        }
    }

    function submitCsrfSim() {
        const isCsrfActive = document.getElementById('csrfSwitch').checked;
        const kode = document.getElementById('simKode').value || 'LAB-005';
        const nama = document.getElementById('simNama').value || 'Barang Baru';
        const resultBox = document.getElementById('csrfResultBox');

        if (!isCsrfActive) {
            resultBox.innerHTML = `
                <div class="p-3 bg-white border border-danger rounded-3 text-center">
                    <h1 class="display-5 fw-bold text-danger mb-0">419</h1>
                    <h5 class="fw-bold text-danger">PAGE EXPIRED | CSRF TOKEN MISMATCH</h5>
                    <p class="text-muted small mb-3">
                        Ups! Server Laravel menolak form ini karena kamu <strong>lupa menambahkan tag <code>&#64;csrf</code></strong> di dalam tag <code>&lt;form&gt;</code>!
                    </p>
                    <div class="alert alert-light border small text-start mb-0">
                        <strong>Solusi Perbaikan Siswa:</strong>
                        <pre class="code-box p-2 mt-1 mb-0 small"><code>&lt;form action="/barang" method="POST"&gt;
    <span class="token-keyword">@csrf</span> <span class="token-comment">&lt;!-- WAJIB DITULIS DI SINI! --&gt;</span>
    &lt;input type="text" name="nama_barang"&gt;
    &lt;button type="submit"&gt;Simpan&lt;/button&gt;
&lt;/form&gt;</code></pre>
                    </div>
                </div>
            `;
        } else {
            resultBox.innerHTML = `
                <div class="p-3 bg-white border border-success rounded-3 text-center">
                    <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                    <h5 class="fw-bold text-success">Token Valid & Data Diterima!</h5>
                    <p class="text-muted small mb-3">
                        Token CSRF cocok. Controller berhasil mengeksekusi:
                        <br><code class="text-dark bg-light p-1 rounded">Item::create(['kode_barang' => '${kode}', 'nama_barang' => '${nama}'])</code>
                    </p>
                    <div class="badge bg-success px-3 py-2">
                        Data berhasil disimpan ke database SQLite!
                    </div>
                </div>
            `;
        }
    }
</script>
@endverbatim
@endpush
