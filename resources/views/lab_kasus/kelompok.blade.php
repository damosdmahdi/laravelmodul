@extends('layouts.belajar')

@section('title', 'Simulasi Kerja Kelompok & Merge Conflict - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Simulasi Kerja Kelompok (Tim 2 Siswa) & Latihan Merge Conflict</h3>
            <p class="text-muted small mb-0">Simulasi industri: Bekerja pada 1 repositori bersama menggunakan Branching dan menangani konflik kode Git</p>
        </div>
        <a href="{{ route('lab-kasus.index') }}" class="btn btn-primary btn-sm px-3">
            Buka Studi Kasus <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <!-- PEMBAGIAN TUGAS 2 SISWA -->
    <div class="row g-4 mb-4">
        <!-- SISWA A -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 border-top border-5 border-success">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success px-3 py-2">Siswa A (Create & Read)</span>
                    <span class="text-muted small font-monospace">branch: feat/create-read</span>
                </div>
                <h5 class="fw-bold text-dark mb-2">Tanggung Jawab Siswa A</h5>
                <p class="text-muted small mb-3">
                    Bertanggung jawab membuat form tambah barang baru dan menampilkan daftar barang di tabel utama.
                </p>
                <div class="p-3 bg-light rounded-3 small">
                    <strong class="d-block mb-1 text-success">File yang disentuh Siswa A:</strong>
                    <code>routes/web.php</code> (Menambah route GET /items & POST /items)<br>
                    <code>app/Http/Controllers/ItemController.php</code> (Method index & store)<br>
                    <code>resources/views/items/index.blade.php</code> & <code>create.blade.php</code>
                </div>
            </div>
        </div>

        <!-- SISWA B -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 border-top border-5 border-warning">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-warning text-dark px-3 py-2">Siswa B (Update & Delete)</span>
                    <span class="text-muted small font-monospace">branch: feat/update-delete</span>
                </div>
                <h5 class="fw-bold text-dark mb-2">Tanggung Jawab Siswa B</h5>
                <p class="text-muted small mb-3">
                    Bertanggung jawab membuat form edit data barang, logika update, dan tombol hapus data.
                </p>
                <div class="p-3 bg-light rounded-3 small">
                    <strong class="d-block mb-1 text-warning text-dark">File yang disentuh Siswa B:</strong>
                    <code>routes/web.php</code> (Menambah route PUT /items/{id} & DELETE /items/{id})<br>
                    <code>app/Http/Controllers/ItemController.php</code> (Method edit, update, & destroy)<br>
                    <code>resources/views/items/edit.blade.php</code>
                </div>
            </div>
        </div>
    </div>

    <!-- SIMULATOR RESOLVE MERGE CONFLICT -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-git me-2 text-danger"></i>Simulator Interaktif: Cara Mengatasi Merge Conflict di routes/web.php</span>
            <span class="badge bg-danger">Simulasi Konflik Nyata</span>
        </div>
        <div class="card-body p-4">
            <p class="text-muted small mb-3">
                Ketika Siswa A sudah melakukan merge ke branch <code>main</code>, lalu Siswa B mencoba melakukan merge setelahnya, Git akan berteriak:
                <br><strong class="text-danger font-monospace">CONFLICT (content): Merge conflict in routes/web.php! Automatic merge failed.</strong>
            </p>

            <div class="p-3 bg-dark rounded-3 mb-3">
                <span class="text-secondary small d-block mb-2">// Kondisi file routes/web.php saat conflict terjadi:</span>
                <div class="code-box p-3 small mb-0" id="conflictBox">
<span class="text-danger">&lt;&lt;&lt;&lt;&lt;&lt;&lt; HEAD (Branch main - Hasil Kerja Siswa A)</span>
<span class="text-success">Route::get('/items', [ItemController::class, 'index']);</span>
<span class="text-success">Route::post('/items', [ItemController::class, 'store']);</span>
<span class="text-warning">=======</span>
<span class="text-info">Route::put('/items/{id}', [ItemController::class, 'update']);</span>
<span class="text-info">Route::delete('/items/{id}', [ItemController::class, 'destroy']);</span>
<span class="text-danger">&gt;&gt;&gt;&gt;&gt;&gt;&gt; feat/update-delete (Branch Siswa B)</span>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <button type="button" class="btn btn-danger btn-sm" onclick="showMistakeSol()">
                    <i class="bi bi-x-circle me-1"></i> Cara SALAH: Menghapus Kode Teman
                </button>
                <button type="button" class="btn btn-success btn-sm" onclick="showCorrectSol()">
                    <i class="bi bi-check-circle me-1"></i> Cara BENAR: Gabungkan Kedua Rute (Resolve Conflict)
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetConflict()">
                    Reset Simulasi
                </button>
            </div>

            <!-- PENJELASAN HASIL RESOLVE -->
            <div class="p-3 rounded-3 border bg-light" id="resolveExplanation">
                <h6 class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle me-1 text-primary"></i> Pelajaran untuk Siswa:</h6>
                <p class="text-muted small mb-0">
                    Klik salah satu tombol di atas untuk melihat apa yang harus dilakukan siswa saat menghadapi tanda <code>&lt;&lt;&lt;&lt;&lt;&lt;&lt;</code> dan <code>&gt;&gt;&gt;&gt;&gt;&gt;&gt;</code> di editor VS Code mereka.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function resetConflict() {
        document.getElementById('conflictBox').innerHTML = `
<span class="text-danger">&lt;&lt;&lt;&lt;&lt;&lt;&lt; HEAD (Branch main - Hasil Kerja Siswa A)</span>
<span class="text-success">Route::get('/items', [ItemController::class, 'index']);</span>
<span class="text-success">Route::post('/items', [ItemController::class, 'store']);</span>
<span class="text-warning">=======</span>
<span class="text-info">Route::put('/items/{id}', [ItemController::class, 'update']);</span>
<span class="text-info">Route::delete('/items/{id}', [ItemController::class, 'destroy']);</span>
<span class="text-danger">&gt;&gt;&gt;&gt;&gt;&gt;&gt; feat/update-delete (Branch Siswa B)</span>
        `;
        document.getElementById('resolveExplanation').innerHTML = `
            <h6 class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle me-1 text-primary"></i> Pelajaran untuk Siswa:</h6>
            <p class="text-muted small mb-0">
                Klik salah satu tombol di atas untuk melihat simulasi penyelesaian conflict.
            </p>
        `;
    }

    function showMistakeSol() {
        document.getElementById('conflictBox').innerHTML = `
<span class="text-secondary">// Siswa B panik lalu menghapus rute Siswa A!</span>
<span class="text-info">Route::put('/items/{id}', [ItemController::class, 'update']);</span>
<span class="text-info">Route::delete('/items/{id}', [ItemController::class, 'destroy']);</span>
        `;
        document.getElementById('resolveExplanation').innerHTML = `
            <div class="alert alert-danger mb-0">
                <h6 class="fw-bold mb-1">❌ KESALAHAN UMUM SISWA PEMULA:</h6>
                <p class="small mb-0">
                    Siswa B menghapus kode Siswa A agar conflict hilang. Akibatnya, halaman daftar barang dan fitur tambah barang yang sudah dibuat Siswa A <strong>menjadi hilang / rusak!</strong> Ajarkan siswa untuk selalu berkoordinasi dan tidak menghapus kode rekan satu timnya.
                </p>
            </div>
        `;
    }

    function showCorrectSol() {
        document.getElementById('conflictBox').innerHTML = `
<span class="text-secondary">// HASIL BERSIH (Kedua rute digabung secara harmonis):</span>
<span class="text-success">Route::get('/items', [ItemController::class, 'index']);       // Dari Siswa A</span>
<span class="text-success">Route::post('/items', [ItemController::class, 'store']);      // Dari Siswa A</span>
<span class="text-info">Route::put('/items/{id}', [ItemController::class, 'update']);    // Dari Siswa B</span>
<span class="text-info">Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Dari Siswa B</span>
        `;
        document.getElementById('resolveExplanation').innerHTML = `
            <div class="alert alert-success mb-0">
                <h6 class="fw-bold mb-1">✅ CARA BENAR PENYELESAIAN CONFLICT:</h6>
                <p class="small mb-1">
                    1. Hapus tanda pemisah <code>&lt;&lt;&lt;&lt;&lt;&lt;&lt;</code>, <code>=======</code>, dan <code>&gt;&gt;&gt;&gt;&gt;&gt;&gt;</code>.
                    <br>2. Susun kedua blok rute agar keduanya tetap ada.
                    <br>3. Lakukan commit penyelesaian di terminal:
                </p>
                <div class="code-box p-2 small mt-2">
                    <code>git add routes/web.php</code><br>
                    <code>git commit -m "fix: resolve merge conflict between Siswa A and Siswa B"</code><br>
                    <code>git push origin main</code>
                </div>
            </div>
        `;
    }
</script>
@endpush
