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
            <h3 class="fw-bold mb-0 text-dark">Modul 5: Eloquent ORM & Rahasia Proteksi &#64;csrf</h3>
            <p class="text-muted small mb-0">Pelajari kemudahan manipulasi data lewat Model dan uji coba saklar proteksi keamanan form</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul4') }}" class="btn btn-outline-secondary btn-sm">Modul 4</a>
            <a href="{{ route('belajar.modul6') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 6 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- ELOQUENT ORM EXPLAINER -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);">
                <h5 class="fw-bold text-dark mb-2">
                    <i class="bi bi-magic text-info me-2"></i>Apa itu Eloquent ORM?
                </h5>
                <p class="text-muted small mb-3">
                    Di PHP native, kamu harus menulis query SQL panjang:
                    <br><code class="text-danger">"INSERT INTO items (kode, nama) VALUES ('$kode', '$nama')"</code>.
                    <br>Jika salah tanda kutip, langsung error!
                </p>
                <p class="small mb-2">
                    Dengan <strong>Eloquent Model</strong> di Laravel, tabel <code>items</code> diwakili oleh sebuah Class PHP bernama <code>Item</code>:
                </p>
                <div class="code-box p-3 small mb-0">
                    <span class="token-comment">// Ambil semua data barang:</span><br>
                    <span class="token-var">$barang</span> = Item::<span class="token-class">all</span>();<br><br>
                    <span class="token-comment">// Simpan data baru dari form:</span><br>
                    Item::<span class="token-class">create</span>([<br>
                    &nbsp;&nbsp;<span class="token-string">'kode_barang'</span> => <span class="token-var">$request</span>->kode_barang,<br>
                    &nbsp;&nbsp;<span class="token-string">'nama_barang'</span> => <span class="token-var">$request</span>->nama_barang,<br>
                    ]);
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 border border-info">
                <h5 class="fw-bold text-dark mb-2">
                    <i class="bi bi-shield-lock-fill text-primary me-2"></i>Kenapa Wajib Ada <code>&#64;csrf</code> di Setiap Form?
                </h5>
                <p class="text-muted small mb-3">
                    <strong>CSRF (Cross-Site Request Forgery)</strong> adalah celah di mana website penipu bisa mengirimkan data palsu ke websitemu tanpa izin pengguna. Laravel melindunginya dengan <strong>Token Rahasia</strong> (tiket masuk) yang dibuat otomatis oleh tag <code>&#64;csrf</code>.
                </p>
                <div class="alert alert-warning small mb-0">
                    <strong>Hukum Wajib Laravel:</strong> Setiap form dengan <code>method="POST"</code> <strong>WAJIB</strong> menyertakan tag <code>&#64;csrf</code>. Jika lupa, Laravel akan menolak mentah-mentah request tersebut dengan error <strong>419 | Page Expired</strong>!
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR SAKLAR CSRF -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-toggle-on text-warning me-2"></i>Laboratorium Uji Coba Form & Proteksi CSRF</span>
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

</div>
@endsection

@push('scripts')
<script>
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
            // SIMULASI ERROR 419 PAGE EXPIRED
            resultBox.innerHTML = `
                <div class="p-3 bg-white border border-danger rounded-3 text-center">
                    <h1 class="display-5 fw-bold text-danger mb-0">419</h1>
                    <h5 class="fw-bold text-danger">PAGE EXPIRED | CSRF TOKEN MISMATCH</h5>
                    <p class="text-muted small mb-3">
                        Ups! Server Laravel menolak permintaan form ini karena kamu <strong>lupa menambahkan tag <code>&#64;csrf</code></strong> di dalam tag <code>&lt;form&gt;</code>!
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
            // SIMULASI BERHASIL
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
@endpush
