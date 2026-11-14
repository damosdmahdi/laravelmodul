@extends('layouts.belajar')

@section('title', 'Modul 3: Blade Templating Studio - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 3: Blade Templating & Master Layout Studio</h3>
            <p class="text-muted small mb-0">Penerapan nyata di industri, panduan Do's & Don'ts, dan simulator efisiensi Master Layout</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul2') }}" class="btn btn-outline-secondary btn-sm">Modul 2</a>
            <a href="{{ route('belajar.modul4') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 4 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- 1. PENERAPAN DI DUNIA NYATA & ANALOGI -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fdf4ff 0%, #fae8ff 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-danger px-3 py-2 fw-semibold"><i class="bi bi-window-stack me-1"></i> Studi Kasus Industri</span>
                <span class="badge bg-white text-dark border">Efisiensi Pemeliharaan Web</span>
            </div>
            <h5 class="fw-bold text-dark mb-2">
                Bagaimana Blade Digunakan di Website Skala Menengah & Besar?
            </h5>
            <p class="text-secondary small mb-3">
                Bayangkan sebuah portal SMK memiliki 20 halaman: <em>Beranda, Profil, Jurusan RPL, Jurusan TKJ, Sarana Lab, Inventaris Barang, Hubungi Kami</em>, dan lainnya.
                Suatu hari, Kepala Sekolah meminta: <strong>"Tolong tambahkan nomor WhatsApp sekolah dan logo baru di Navbar bagian atas!"</strong>
            </p>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border">
                        <span class="badge bg-secondary mb-2">Cara Kuno (Copy-Paste HTML)</span>
                        <h6 class="fw-bold text-dark">Mengedit 20 File Satu per Satu</h6>
                        <p class="small text-muted mb-0">
                            Kamu harus membuka file <code>beranda.html</code>, <code>profil.html</code>, <code>rpl.html</code>, sampai <code>kontak.html</code> satu per satu. Memakan waktu 2 jam, rawan salah ketik di halaman tertentu, dan menghasilkan tampilan yang tidak seragam.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border border-danger">
                        <span class="badge bg-danger mb-2">Cara Modern Laravel Blade</span>
                        <h6 class="fw-bold text-danger">Ubah 1 File Saja: layouts/app.blade.php</h6>
                        <p class="small text-muted mb-0">
                            Kamu hanya perlu mengedit <strong>1 file Master Layout</strong>. Dalam 10 detik, seluruh 20 halaman website secara ajaib ter-update bersamaan karena semuanya mewarisi template utama melalui tag <code>&#64;extends('layouts.app')</code>!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SIMULATOR EFISIENSI MASTER LAYOUT (LIVE SYNCHRONIZER) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-broadcast text-warning me-2"></i>Simulator Interaktif: Ubah di 1 File Master, 4 Halaman Berubah Seketika!</span>
            <span class="badge bg-danger">Live Demo</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4 align-items-center mb-3">
                <!-- CONTROLLER MASTER LAYOUT -->
                <div class="col-lg-5">
                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-primary mb-2 small"><i class="bi bi-gear-fill me-1"></i> Edit Pengaturan di Master: layouts/app.blade.php</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama / Judul Sekolah di Navbar:</label>
                            <input type="text" class="form-control form-control-sm" id="syncNavbarTitle" value="Lab Komputer SMK 1" oninput="syncMasterLayout()">
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold">Pilih Warna Tema Navbar:</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary px-3" onclick="setNavbarTheme('bg-primary', 'Biru Modern')">Biru</button>
                                <button type="button" class="btn btn-sm btn-success px-3" onclick="setNavbarTheme('bg-success', 'Hijau Edukasi')">Hijau</button>
                                <button type="button" class="btn btn-sm btn-danger px-3" onclick="setNavbarTheme('bg-danger', 'Merah Berani')">Merah</button>
                                <button type="button" class="btn btn-sm btn-dark px-3" onclick="setNavbarTheme('bg-dark', 'Dark Elegan')">Hitam</button>
                            </div>
                        </div>
                        <div class="form-text small mt-2">
                            Tema aktif: <strong id="currentThemeLabel">Biru Modern</strong>
                        </div>
                    </div>
                </div>

                <!-- EXPLANATION BOX -->
                <div class="col-lg-7">
                    <div class="alert alert-info border mb-0 small">
                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> <strong>Apa yang Sedang Kamu Lihat?</strong>
                        <p class="mb-0 mt-1">
                            Di bawah ini adalah 4 halaman anak yang berbeda (<em>Daftar Barang, Form Tambah, Detail Barang, Profil Lab</em>). Perhatikan bagian atas setiap halaman: begitu kamu mengubah nama atau warna navbar di Master Layout di sebelah kiri, <strong>ke-4 halaman seketika berubah seragam</strong> tanpa menyentuh file anak sama sekali!
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4 THUMBNAIL HALAMAN ANAK TER-SINKRONISASI -->
            <div class="row g-3">
                <!-- HALAMAN 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-3 shadow-sm overflow-hidden bg-light">
                        <div class="p-2 text-white sync-nav bg-primary text-center small fw-bold" style="font-size: 0.72rem;">
                            <span class="sync-title">Lab Komputer SMK 1</span>
                        </div>
                        <div class="p-2 bg-white small" style="min-height: 100px;">
                            <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">items/index.blade.php</span>
                            <div class="fw-bold" style="font-size: 0.75rem;">📋 Daftar Barang</div>
                            <div class="text-muted" style="font-size: 0.7rem;">PC Core i5 (24 Unit)<br>Router RB750 (12 Unit)</div>
                        </div>
                    </div>
                </div>

                <!-- HALAMAN 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-3 shadow-sm overflow-hidden bg-light">
                        <div class="p-2 text-white sync-nav bg-primary text-center small fw-bold" style="font-size: 0.72rem;">
                            <span class="sync-title">Lab Komputer SMK 1</span>
                        </div>
                        <div class="p-2 bg-white small" style="min-height: 100px;">
                            <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">items/create.blade.php</span>
                            <div class="fw-bold" style="font-size: 0.75rem;">➕ Form Tambah</div>
                            <div class="text-muted" style="font-size: 0.7rem;">[Input Kode Barang]<br>[Input Nama Barang]</div>
                        </div>
                    </div>
                </div>

                <!-- HALAMAN 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-3 shadow-sm overflow-hidden bg-light">
                        <div class="p-2 text-white sync-nav bg-primary text-center small fw-bold" style="font-size: 0.72rem;">
                            <span class="sync-title">Lab Komputer SMK 1</span>
                        </div>
                        <div class="p-2 bg-white small" style="min-height: 100px;">
                            <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">items/edit.blade.php</span>
                            <div class="fw-bold" style="font-size: 0.75rem;">✏️ Form Edit Barang</div>
                            <div class="text-muted" style="font-size: 0.7rem;">LAB-001 (Kondisi: Baik)<br>Method PUT Spoofing</div>
                        </div>
                    </div>
                </div>

                <!-- HALAMAN 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="border rounded-3 shadow-sm overflow-hidden bg-light">
                        <div class="p-2 text-white sync-nav bg-primary text-center small fw-bold" style="font-size: 0.72rem;">
                            <span class="sync-title">Lab Komputer SMK 1</span>
                        </div>
                        <div class="p-2 bg-white small" style="min-height: 100px;">
                            <span class="badge bg-secondary mb-1" style="font-size: 0.65rem;">pages/profil.blade.php</span>
                            <div class="fw-bold" style="font-size: 0.75rem;">🏢 Profil Jurusan RPL</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Kapasitas: 36 Siswa<br>Guru: Pembimbing RPL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DO'S & DON'TS BLADE TEMPLATING -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-shaded text-primary me-2"></i>Panduan Do's & Don'ts Blade Templating
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
                                    <strong>Jangan menulis query database di dalam file Blade!</strong>
                                    <div class="text-muted">Misal menulis <code>&lt;?php $items = DB::select(...); ?&gt;</code> di dalam file blade. Ini melanggar pola MVC. File Blade hanya bertugas menampilkan data, bukan mengambil data dari database.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan mencetak data user dengan raw HTML <code>&#123;!! $data !!&#125;</code> sembarangan!</strong>
                                    <div class="text-muted">Jika user memasukkan skrip jahat <code>&lt;script&gt;stealCookies()&lt;/script&gt;</code>, browser akan langsung mengeksekusinya (Celah XSS - Cross-Site Scripting).</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-dash-circle-fill text-danger me-2 mt-1"></i>
                                <div>
                                    <strong>Jangan copy-paste CDN Bootstrap/CSS di setiap halaman anak!</strong>
                                    <div class="text-muted">CSS dan JS CDN cukup ditaruh di <code>layouts/app.blade.php</code> satu kali saja.</div>
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
                                    <strong>Kirim data selalu dari Controller via <code>compact()</code>!</strong>
                                    <div class="text-muted">Ambil data di controller (<code>$items = Item::all()</code>), lalu kirim: <code>return view('items.index', compact('items'));</code>.</div>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Selalu gunakan kurung kurawal ganda <code>@{{ $data }}</code>!</strong>
                                    <div class="text-muted">Laravel secara otomatis menjalankan <code>htmlspecialchars()</code> untuk menyaring tag HTML dan script jahat agar aman dari peretasan.</div>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check2-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong>Gunakan <code>&#64;forelse ... &#64;empty</code> untuk tabel!</strong>
                                    <div class="text-muted">Jika data di database kosong, kamu bisa menampilkan pesan ramah otomatis tanpa perlu menulis <code>&#64;if(count($items) == 0)</code> manual.</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. LIVE BLADE PLAYGROUND (EXISTING) -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-play-btn-fill me-2 text-danger"></i>Blade Interactive Playground (Coba-Coba Sintaks)</span>
            <span class="badge bg-danger">Uji Langsung</span>
        </div>
        <div class="card-body p-4">
            <div class="mb-3 d-flex flex-wrap gap-2">
                <span class="small fw-bold align-self-center me-2">Pilih Contoh:</span>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="loadBladeSnippet('var')">
                    1. Cetak Variabel @{{ $data }}
                </button>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="loadBladeSnippet('foreach')">
                    2. Perulangan &#64;foreach
                </button>
                <button type="button" class="btn btn-outline-warning btn-sm" onclick="loadBladeSnippet('if')">
                    3. Pengkondisian &#64;if ... &#64;else
                </button>
            </div>

            <div class="row g-4">
                <!-- EDITOR KIRI -->
                <div class="col-lg-6">
                    <label class="form-label fw-bold small text-dark"><i class="bi bi-code-slash me-1"></i> Editor Kode Blade (Silakan Diedit!):</label>
                    <textarea class="form-control font-monospace p-3 text-white" id="bladeInput" rows="12" style="background: #0f172a; font-size: 0.85rem; line-height: 1.6;"></textarea>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="text-muted small">Coba ubah teks atau tag di atas</span>
                        <button type="button" class="btn btn-danger btn-sm px-3" onclick="compileBladeSim()">
                            <i class="bi bi-lightning-fill me-1"></i> Render Tampilan
                        </button>
                    </div>
                </div>

                <!-- PREVIEW KANAN -->
                <div class="col-lg-6">
                    <label class="form-label fw-bold small text-dark"><i class="bi bi-eye-fill me-1"></i> Hasil Render di Layar Pengunjung:</label>
                    <div class="border rounded-3 p-3 bg-white shadow-sm" id="bladeOutput" style="min-height: 290px;">
                        <!-- Hasil Render -->
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
    function syncMasterLayout() {
        const title = document.getElementById('syncNavbarTitle').value || 'Lab SMK';
        document.querySelectorAll('.sync-title').forEach(el => el.textContent = title);
    }

    function setNavbarTheme(bgClass, label) {
        document.querySelectorAll('.sync-nav').forEach(el => {
            el.className = `p-2 text-white sync-nav text-center small fw-bold ${bgClass}`;
        });
        document.getElementById('currentThemeLabel').textContent = label;
    }

    const snippets = {
        var: `<div class="p-3 bg-light rounded border">
    <h4 class="fw-bold text-primary">{{ $nama_lab }}</h4>
    <p class="mb-1">Penanggung Jawab: <strong>{{ $guru }}</strong></p>
    <p class="text-muted small">Total Komputer: {{ $jumlah_pc }} Unit</p>
</div>`,
        foreach: `<ul class="list-group">
    @foreach ($daftar_barang as $barang)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><i class="bi bi-box-seam me-2"></i>{{ $barang }}</span>
            <span class="badge bg-success rounded-pill">Tersedia</span>
        </li>
    @endforeach
</ul>`,
        if: `<div class="card p-3 border">
    <h6>Status Kondisi Perangkat:</h6>
    @if ($kondisi == 'Baik')
        <div class="alert alert-success mb-0 py-2">
            <i class="bi bi-check-circle-fill me-2"></i>Barang dalam kondisi prima & siap pakai.
        </div>
    @elseif ($kondisi == 'Rusak Ringan')
        <div class="alert alert-warning mb-0 py-2">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Perlu sedikit perbaikan / kabel kendur.
        </div>
    @else
        <div class="alert alert-danger mb-0 py-2">
            <i class="bi bi-x-octagon-fill me-2"></i>Barang rusak berat, segera ganti unit baru!
        </div>
    @endif
</div>`
    };

    function loadBladeSnippet(type) {
        document.getElementById('bladeInput').value = snippets[type];
        compileBladeSim();
    }

    function compileBladeSim() {
        let code = document.getElementById('bladeInput').value;
        const output = document.getElementById('bladeOutput');

        const dataVars = {
            '$nama_lab': 'Lab Komputer & Jaringan SMK 1',
            '$guru': 'Pak Guru Damos',
            '$jumlah_pc': '36',
            '$kondisi': 'Baik'
        };

        let rendered = code;
        for (const [key, val] of Object.entries(dataVars)) {
            const regex = new RegExp(`{{\\s*\\${key}\\s*}}`, 'g');
            rendered = rendered.replace(regex, val);
        }

        if (rendered.includes('foreach')) {
            const dummyList = ['PC Core i5 LAB-001', 'Router MikroTik RB750Gr3', 'Switch D-Link 24P', 'Crimping Tool RJ45'];
            let itemsHtml = dummyList.map(item => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box-seam me-2"></i>${item}</span>
                    <span class="badge bg-success rounded-pill">Tersedia</span>
                </li>
            `).join('');
            rendered = `<ul class="list-group">${itemsHtml}</ul>`;
        }

        if (rendered.includes('if')) {
            rendered = `
                <div class="card p-3 border">
                    <h6 class="fw-bold">Status Kondisi Perangkat:</h6>
                    <div class="alert alert-success mb-0 py-2">
                        <i class="bi bi-check-circle-fill me-2"></i>Barang dalam kondisi prima & siap pakai (Kondisi: Baik).
                    </div>
                </div>
            `;
        }

        output.innerHTML = rendered;
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadBladeSnippet('var');
    });
</script>
@endverbatim
@endpush
