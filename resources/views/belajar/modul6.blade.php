@extends('layouts.belajar')

@section('title', 'Modul 6: CRUD & Validasi Form - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 6: Penyelesaian CRUD & Proteksi Validasi Form</h3>
            <p class="text-muted small mb-0">Melengkapi operasi Update (PUT), Hapus (DELETE), dan mencegah input kosong via <code>$request->validate()</code></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul5') }}" class="btn btn-outline-secondary btn-sm">Modul 5</a>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning btn-sm px-3 text-dark fw-bold">
                Buka Studi Kasus Lab <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- 2 KONSEP INTI MODUL 6 -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                <h5 class="fw-bold text-dark mb-2">
                    <i class="bi bi-check2-circle text-success me-2"></i>1. Validasi Form (Mencegah Data Bodong)
                </h5>
                <p class="text-muted small mb-3">
                    Jangan biarkan pengguna mengirim form dalam keadaan kosong! Di Laravel, cukup panggil satu baris <code>$request->validate([...])</code> di Controller:
                </p>
                <div class="code-box p-3 small">
                    <span class="token-var">$request</span>-><span class="token-class">validate</span>([<br>
                    &nbsp;&nbsp;<span class="token-string">'kode_barang'</span> => <span class="token-string">'required|unique:items'</span>,<br>
                    &nbsp;&nbsp;<span class="token-string">'nama_barang'</span> => <span class="token-string">'required|min:3'</span>,<br>
                    &nbsp;&nbsp;<span class="token-string">'stok'</span> => <span class="token-string">'required|numeric|min:0'</span>,<br>
                    ]);
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                <h5 class="fw-bold text-dark mb-2">
                    <i class="bi bi-arrow-repeat text-primary me-2"></i>2. Method Spoofing (&#64;method('PUT') & DELETE)
                </h5>
                <p class="text-muted small mb-3">
                    Form HTML standar di browser hanya mengenal <code>GET</code> dan <code>POST</code>. Namun prinsip standar industri RESTful API menuntut operasi Update menggunakan <code>PUT</code> dan Hapus menggunakan <code>DELETE</code>.
                </p>
                <div class="alert alert-light border small mb-0">
                    <strong>Cara di Laravel:</strong> Tetap tulis <code>method="POST"</code> pada tag <code>&lt;form&gt;</code>, lalu tambahkan directive:
                    <br><code class="text-primary fw-bold">&#64;method('PUT')</code> untuk form edit, atau
                    <br><code class="text-danger fw-bold">&#64;method('DELETE')</code> untuk tombol hapus!
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR INTERAKTIF VALIDASI INPUT -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-ui-checks text-warning me-2"></i>Simulator Validasi Form Input Siswa</span>
            <span class="badge bg-primary">Uji Coba Validasi</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- FORM UJI COBA -->
                <div class="col-lg-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-pencil-fill me-1"></i> Coba Submit Form Ini Kosong atau Salah Format:</h6>
                    
                    <form id="simValForm" onsubmit="event.preventDefault(); runValidationSim();">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kode Barang (Wajib diisi & Unique)</label>
                            <input type="text" class="form-control" id="valKode" placeholder="Contoh: LAB-010">
                            <div class="text-danger small mt-1 d-none" id="errKode">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> <span id="errKodeText">Kode barang wajib diisi!</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Barang (Minimal 4 Karakter)</label>
                            <input type="text" class="form-control" id="valNama" placeholder="Contoh: Kabel UTP Cat6">
                            <div class="text-danger small mt-1 d-none" id="errNama">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> <span id="errNamaText">Nama barang minimal 4 karakter!</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jumlah Stok (Harus Angka & >= 0)</label>
                            <input type="text" class="form-control" id="valStok" placeholder="Contoh: 15">
                            <div class="text-danger small mt-1 d-none" id="errStok">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> <span id="errStokText">Stok harus berupa angka!</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="bi bi-check-lg me-1"></i> Submit & Jalankan Validasi
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetValForm()">
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>

                <!-- RESPON DIARY LARAVEL VALIDATOR -->
                <div class="col-lg-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-journal-code me-1"></i> Apa yang Terjadi di Balik Layar Laravel:</h6>
                    <div class="code-box p-3 small" style="min-height: 250px;" id="valLogBox">
                        <span class="text-secondary">// Tekan tombol 'Submit & Jalankan Validasi' untuk melihat bagaimana Laravel memeriksa isi variabel $request...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function resetValForm() {
        document.getElementById('valKode').value = '';
        document.getElementById('valNama').value = '';
        document.getElementById('valStok').value = '';

        ['errKode', 'errNama', 'errStok'].forEach(id => document.getElementById(id).classList.add('d-none'));
        ['valKode', 'valNama', 'valStok'].forEach(id => document.getElementById(id).classList.remove('is-invalid', 'is-valid'));

        document.getElementById('valLogBox').innerHTML = '<span class="text-secondary">// Form direset.</span>';
    }

    function runValidationSim() {
        const kode = document.getElementById('valKode').value.trim();
        const nama = document.getElementById('valNama').value.trim();
        const stok = document.getElementById('valStok').value.trim();
        const logBox = document.getElementById('valLogBox');

        let errors = [];

        // Reset visual
        ['errKode', 'errNama', 'errStok'].forEach(id => document.getElementById(id).classList.add('d-none'));
        ['valKode', 'valNama', 'valStok'].forEach(id => document.getElementById(id).classList.remove('is-invalid', 'is-valid'));

        // Cek kode
        if (!kode) {
            errors.push('kode_barang: Kolom kode barang wajib diisi!');
            document.getElementById('errKode').classList.remove('d-none');
            document.getElementById('valKode').classList.add('is-invalid');
        } else if (kode === 'LAB-001' || kode === 'LAB-002') {
            errors.push(`kode_barang: Kode '${kode}' sudah terdaftar di database (aturan: unique)!`);
            document.getElementById('errKodeText').textContent = `Kode '${kode}' sudah dipakai barang lain!`;
            document.getElementById('errKode').classList.remove('d-none');
            document.getElementById('valKode').classList.add('is-invalid');
        } else {
            document.getElementById('valKode').classList.add('is-valid');
        }

        // Cek nama
        if (!nama || nama.length < 4) {
            errors.push('nama_barang: Nama barang minimal harus 4 karakter (aturan: min:4)!');
            document.getElementById('errNama').classList.remove('d-none');
            document.getElementById('valNama').classList.add('is-invalid');
        } else {
            document.getElementById('valNama').classList.add('is-valid');
        }

        // Cek stok
        if (!stok || isNaN(stok) || parseInt(stok) < 0) {
            errors.push('stok: Jumlah stok harus berupa angka minimal 0 (aturan: numeric|min:0)!');
            document.getElementById('errStok').classList.remove('d-none');
            document.getElementById('valStok').classList.add('is-invalid');
        } else {
            document.getElementById('valStok').classList.add('is-valid');
        }

        if (errors.length > 0) {
            let errorItems = errors.map(err => `<li class="text-danger">${err}</li>`).join('');
            logBox.innerHTML = `
<span class="text-danger fw-bold">[VALIDATION FAILED] Permintaan ditolak Laravel!</span>
<span class="text-secondary">&rarr; Laravel membatalkan penyimpanan ke Database.</span>
<span class="text-warning">&rarr; Mengembalikan user ke halaman sebelumnya (redirect back).</span>
<span class="text-info">&rarr; Mengirimkan objek variabel $errors:</span>
<ul class="mb-0 mt-2">${errorItems}</ul>
            `;
        } else {
            logBox.innerHTML = `
<span class="text-success fw-bold">[VALIDATION PASSED] Semua aturan validasi terpenuhi!</span>
<span class="text-white">&rarr; $validated = $request->validate([...]);</span>
<span class="text-info">&rarr; Mengeksekusi: Item::create($validated);</span>
<span class="text-success">&rarr; [200 OK] Data berhasil disimpan dan dialihkan dengan session('success')!</span>
            `;
        }
    }
</script>
@endpush
