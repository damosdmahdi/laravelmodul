@extends('layouts.belajar')

@section('title', 'Modul 4: Database & Migration - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 4: Database & Migrations (Version Control Skema Tabel)</h3>
            <p class="text-muted small mb-0">Penerapan nyata di industri, panduan Do's & Don'ts, dan simulator migrasi & rollback</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul3') }}" class="btn btn-outline-secondary btn-sm">Modul 3</a>
            <a href="{{ route('belajar.modul5') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 5 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- 1. PENERAPAN DI DUNIA NYATA & FILOSOFI -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fefce8 0%, #fef08a 100%);">
        <div class="card-body p-4 text-dark">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-warning text-dark px-3 py-2 fw-semibold"><i class="bi bi-database-gear me-1"></i> Standar Database Industri</span>
                <span class="badge bg-white text-dark border">Kenapa Bukan phpMyAdmin?</span>
            </div>
            <h5 class="fw-bold mb-2">
                Bagaimana Tim Programmer Menjaga Struktur Database Tetap Sama?
            </h5>
            <p class="small mb-3">
                Bayangkan kamu bekerja dalam tim 4 orang membuat aplikasi inventaris sekolah. Jika kamu membuat tabel di phpMyAdmin komputermu sendiri, 3 temanmu tidak akan punya tabel tersebut kecuali kamu ekspor file <code>.sql</code> lalu kirim lewat WhatsApp/Flashdisk. Jika besok kamu menambah 1 kolom baru, teman-temanmu pasti mengalami error karena skema databasenya berbeda!
            </p>
            <div class="p-3 bg-white rounded-3 border small">
                <strong class="text-primary"><i class="bi bi-check-circle-fill me-1"></i>Solusi Laravel Migration:</strong>
                Skema tabel ditulis sebagai <strong>kode PHP (Blueprint)</strong> yang masuk ke dalam Git. Teman satu timmu cukup menarik kode (<code>git pull</code>) lalu mengetik satu perintah sakti:
                <br><code class="fw-bold text-dark fs-6 bg-light p-1 rounded mt-1 d-inline-block">php artisan migrate</code> &rarr; Maka seluruh tabel otomatis terbentuk di komputernya tanpa perlu buka phpMyAdmin!
            </div>
        </div>
    </div>

    <!-- 2. SIMULATOR INTERAKTIF: SIKLUS MIGRASI & ROLLBACK -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-dark text-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-clock-history text-warning me-2"></i>Simulator Interaktif: Eksekusi Migrasi & Rollback</h5>
                <span class="text-secondary small">Amati bagaimana Laravel menambah dan menarik mundur kolom database secara visual</span>
            </div>
            <span class="badge bg-secondary" id="simMigrateStatus">Status: V1 Aktif</span>
        </div>

        <div class="row g-4 align-items-center">
            <!-- PANEL KONTROL ARTISAN MIGRATE -->
            <div class="col-lg-5">
                <div class="p-3 bg-secondary bg-opacity-25 rounded-3 border border-secondary mb-3">
                    <label class="form-label small fw-bold text-warning d-block mb-2">Pilih Perintah Artisan untuk Dijalankan:</label>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm text-start" onclick="runSimMigration('v1')">
                            <i class="bi bi-play-circle-fill me-1"></i> <strong>1. php artisan migrate (V1)</strong>
                            <div class="text-secondary small" style="font-size: 0.72rem;">Membuat tabel awal: id, kode_barang, nama_barang</div>
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm text-start" onclick="runSimMigration('v2')">
                            <i class="bi bi-plus-circle-fill me-1"></i> <strong>2. php artisan migrate (V2: Tambah Kolom)</strong>
                            <div class="text-secondary small" style="font-size: 0.72rem;">Menjalankan migrasi baru: tambah kolom stok & kondisi</div>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm text-start" onclick="runSimMigration('rollback')">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> <strong>3. php artisan migrate:rollback</strong>
                            <div class="text-secondary small" style="font-size: 0.72rem;">Membatalkan migrasi terakhir & mengembalikan skema tabel</div>
                        </button>
                    </div>
                </div>

                <div class="alert alert-secondary small mb-0">
                    <i class="bi bi-info-circle me-1"></i> Rollback sangat berguna saat ada kesalahan pembuatan kolom sebelum kode di-push ke server!
                </div>
            </div>

            <!-- VISUAL STRUKTUR TABEL DINAMIS -->
            <div class="col-lg-7">
                <label class="form-label fw-bold small text-light"><i class="bi bi-table me-1 text-primary"></i> Struktur Skema Tabel Database SQLite yang Terbentuk:</label>
                <div class="border rounded-3 p-3 bg-white text-dark shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <strong class="text-primary font-monospace">Tabel: items</strong>
                        <span class="badge bg-light text-muted border font-monospace" id="tableVersionLabel">Versi Skema: V1</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle small mb-0" id="schemaSimTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kolom</th>
                                    <th>Tipe Data</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>id</code></td><td>BIGINT</td><td><span class="badge bg-secondary">Primary Key</span></td></tr>
                                <tr><td><code>kode_barang</code></td><td>VARCHAR</td><td><span class="badge bg-primary">Unique</span></td></tr>
                                <tr><td><code>nama_barang</code></td><td>VARCHAR</td><td>Wajib diisi</td></tr>
                                <tr id="row-stok" class="d-none table-success"><td><code>stok</code></td><td>INTEGER</td><td><span class="badge bg-success">Baru di V2</span></td></tr>
                                <tr id="row-kondisi" class="d-none table-success"><td><code>kondisi</code></td><td>ENUM</td><td><span class="badge bg-success">Baru di V2</span></td></tr>
                                <tr><td><code>created_at</code></td><td>TIMESTAMP</td><td><span class="badge bg-light text-dark border">Bawaan</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-2 text-secondary small font-monospace" id="migrateConsoleLog">
                    // Menunggu perintah artisan migrate...
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DO'S & DON'TS DATABASE & MIGRATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-shaded text-primary me-2"></i>Panduan Do's & Don'ts Pengelolaan Database
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
                                    <strong>Jangan menambah atau merubah kolom langsung di phpMyAdmin!</strong>
                                    <div class="text-muted">Perubahan yang kamu lakukan di phpMyAdmin tidak tercatat di file kode mana pun, sehingga komputer teman timmu tidak akan pernah mendapatkan perubahan tersebut.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan mengedit file migrasi LAMA yang sudah di-push ke GitHub!</strong>
                                    <div class="text-muted">Jika temanmu sudah menjalankan file migrasi itu, Laravel tidak akan mengeksekusinya lagi kecuali tabel di-reset (bisa menghapus seluruh data siswa lain).</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan gunakan tipe data string/varchar untuk angka stok & harga!</strong>
                                    <div class="text-muted">Jika kolom stok bertipe string, query penjumlahan (SUM) dan pengurutan (ORDER BY) akan salah (misal: "10" dianggap lebih kecil dari "9").</div>
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
                                    <strong>Gunakan selalu <code>php artisan make:migration</code>!</strong>
                                    <div class="text-muted">Setiap butuh kolom baru, buat migrasi baru: <code>php artisan make:migration add_kondisi_to_items_table</code>.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Pilih tipe data yang tepat (integer, decimal, enum, boolean)!</strong>
                                    <div class="text-muted">Gunakan <code>$table->integer('stok')</code> dan <code>$table->enum('kondisi', ['Baik', 'Rusak'])</code> untuk validasi di tingkat database.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Gunakan SQLite di lab sekolah agar bebas konfigurasi server!</strong>
                                    <div class="text-muted">SQLite tidak memerlukan username/password MySQL, tidak butuh menyalakan XAMPP Apache, dan langsung tersimpan aman di <code>database/database.sqlite</code>.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. DATA TABEL REAL SAAT INI DI DATABASE (EXISTING) -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark"><i class="bi bi-hdd-network text-success me-2"></i>Data Aktual Tabel items di SQLite Saat Ini</span>
            <span class="badge bg-success">Tabel items ({{ $items->count() }} Data Aktif)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th>Waktu Migrasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span></td>
                                <td class="fw-bold">{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->stok }} Unit</td>
                                <td>
                                    @if ($item->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif ($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    function runSimMigration(action) {
        const rowStok = document.getElementById('row-stok');
        const rowKondisi = document.getElementById('row-kondisi');
        const labelVersion = document.getElementById('tableVersionLabel');
        const statusPill = document.getElementById('simMigrateStatus');
        const logEl = document.getElementById('migrateConsoleLog');

        if (action === 'v1') {
            rowStok.classList.add('d-none');
            rowKondisi.classList.add('d-none');
            labelVersion.textContent = 'Versi Skema: V1 (Awal)';
            statusPill.className = 'badge bg-secondary';
            statusPill.textContent = 'Status: V1 Aktif';
            logEl.innerHTML = `
<span class="text-success">$ php artisan migrate</span><br>
<span class="text-white">   INFO  Running migrations: 2026_create_items_table ... DONE</span><br>
<span class="text-info">   Tabel 'items' berhasil dibuat dengan 3 kolom utama (id, kode_barang, nama_barang).</span>
            `;
        } else if (action === 'v2') {
            rowStok.classList.remove('d-none');
            rowKondisi.classList.remove('d-none');
            labelVersion.textContent = 'Versi Skema: V2 (Lengkap)';
            statusPill.className = 'badge bg-success';
            statusPill.textContent = 'Status: V2 (Kolom Ditambahkan)';
            logEl.innerHTML = `
<span class="text-success">$ php artisan migrate</span><br>
<span class="text-white">   INFO  Running migrations: 2026_add_stok_and_kondisi_to_items_table ... DONE</span><br>
<span class="text-success fw-bold">   Kolom 'stok' (INTEGER) dan 'kondisi' (ENUM) berhasil ditambahkan ke tabel items!</span>
            `;
        } else if (action === 'rollback') {
            rowStok.classList.add('d-none');
            rowKondisi.classList.add('d-none');
            labelVersion.textContent = 'Versi Skema: V1 (Setelah Rollback)';
            statusPill.className = 'badge bg-warning text-dark';
            statusPill.textContent = 'Status: Di-Rollback ke V1';
            logEl.innerHTML = `
<span class="text-danger">$ php artisan migrate:rollback</span><br>
<span class="text-white">   INFO  Rolling back: 2026_add_stok_and_kondisi_to_items_table ... DONE</span><br>
<span class="text-warning">   Perubahan V2 ditarik mundur! Kolom 'stok' dan 'kondisi' dihapus aman dari skema.</span>
            `;
        }
    }
</script>
@endverbatim
@endpush
