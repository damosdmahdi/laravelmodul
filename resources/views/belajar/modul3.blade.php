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
            <p class="text-muted small mb-0">Uji coba sintaks cerdas Blade dan pelajari bagaimana memecah template HTML agar tidak copy-paste</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul2') }}" class="btn btn-outline-secondary btn-sm">Modul 2</a>
            <a href="{{ route('belajar.modul4') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 4 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- KONSEP MASTER LAYOUTING -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fdf4ff 0%, #fae8ff 100%);">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-2">
                <i class="bi bi-puzzle-fill text-danger me-2"></i>Kenapa Harus Pakai Master Layout (<code>&#64;extends</code> & <code>&#64;yield</code>)?
            </h5>
            <p class="text-muted small mb-3">
                Di PHP Native, saat kamu punya 10 halaman website, kamu sering kali copy-paste kode Navbar & Footer 10 kali. Jika ada menu baru di Navbar, kamu terpaksa mengedit 10 file satu per satu! Di Laravel Blade, kita hanya buat <strong>1 Master Layout</strong>, dan halaman lain hanya mengisi bagian tengahnya saja.
            </p>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border">
                        <span class="badge bg-secondary mb-2">File Master: layouts/app.blade.php</span>
                        <pre class="code-box p-2 mb-0 small"><code>&lt;!-- Kerangka Utama Website --&gt;
&lt;html&gt;
  &lt;body&gt;
    &lt;nav&gt;...NAVBAR KITA...&lt;/nav&gt;

    &lt;main class="container"&gt;
      <span class="token-keyword">&#64;yield</span>('content') <span class="token-comment">&lt;!-- Titik Kosong Dinamis --&gt;</span>
    &lt;/main&gt;

    &lt;footer&gt;...FOOTER KITA...&lt;/footer&gt;
  &lt;/body&gt;
&lt;/html&gt;</code></pre>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border border-danger">
                        <span class="badge bg-danger mb-2">File Anak: items/index.blade.php</span>
                        <pre class="code-box p-2 mb-0 small"><code><span class="token-keyword">&#64;extends</span>('layouts.app') <span class="token-comment">&lt;!-- Warisi Kerangka --&gt;</span>

<span class="token-keyword">&#64;section</span>('content')
  &lt;h3&gt;Daftar Inventaris Lab&lt;/h3&gt;
  &lt;table&gt;...Tabel Barang...&lt;/table&gt;
<span class="token-keyword">&#64;endsection</span></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LIVE BLADE PLAYGROUND -->
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

        // Simulasi compiler Blade sederhana untuk browser siswa
        // Variabel dummy
        const dataVars = {
            '$nama_lab': 'Lab Komputer & Jaringan SMK 1',
            '$guru': 'Pak Guru Damos',
            '$jumlah_pc': '36',
            '$kondisi': 'Baik'
        };

        // Ganti variabel {{ $var }}
        let rendered = code;
        for (const [key, val] of Object.entries(dataVars)) {
            const regex = new RegExp(`{{\\s*\\${key}\\s*}}`, 'g');
            rendered = rendered.replace(regex, val);
        }

        // Simulasi loop foreach
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

        // Simulasi kondisi if
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
