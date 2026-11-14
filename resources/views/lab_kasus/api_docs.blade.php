@extends('layouts.belajar')

@section('title', 'Dokumentasi RESTful API Inventaris Lab SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Inventaris
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-code-slash text-info me-2"></i>Dokumentasi &amp; Playground RESTful API Lab
            </h3>
            <span class="text-muted small">Mempelajari Web API JSON untuk integrasi aplikasi Android/Flutter, frontend Vue/React, atau Postman</span>
        </div>
        <div>
            <a href="{{ url('/api/v1/items') }}" target="_blank" class="btn btn-outline-info text-dark btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Raw JSON di Tab Baru
            </a>
        </div>
    </div>

    <!-- PENJELASAN KONSEP API UNTUK SISWA SMK -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-2">
                <i class="bi bi-cpu-fill text-teal me-2"></i>Apa Itu RESTful API di Laravel?
            </h5>
            <p class="text-secondary small mb-3">
                Jika selama ini Controller me-return tampilan HTML (Blade) untuk browser komputer, maka di era modern Controller juga sering me-return data murni dalam format <strong>JSON (JavaScript Object Notation)</strong> agar bisa dikonsumsi oleh aplikasi mobile (Android/iOS), perangkat IoT di lab, atau aplikasi frontend modern.
            </p>
            <div class="code-box p-3 small">
                <span class="text-secondary">// Di Controller cukup return response()->json([...]):</span><br>
                <span class="token-var">$items</span> = Item::<span class="token-class">all</span>();<br>
                <span class="token-keyword">return</span> <span class="token-func">response</span>()-><span class="token-func">json</span>([<br>
                &nbsp;&nbsp;<span class="token-string">'status'</span> => <span class="token-string">'success'</span>,<br>
                &nbsp;&nbsp;<span class="token-string">'data'</span> => <span class="token-var">$items</span><br>
                ], 200);
            </div>
        </div>
    </div>

    <!-- LIST ENDPOINT RESTFUL API -->
    <div class="row g-4 mb-4">
        
        <!-- ENDPOINT 1: GET ALL ITEMS -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success font-monospace px-3 py-2 fs-6">GET</span>
                    <span class="font-monospace small text-muted">/api/v1/items</span>
                </div>
                <h6 class="fw-bold text-dark mb-1">Ambil Seluruh Data Barang Inventaris</h6>
                <p class="text-muted small mb-3">Mengambil array data seluruh alat dan barang yang ada di inventaris lab.</p>
                <button class="btn btn-outline-success btn-sm w-100 fw-bold" onclick="testEndpoint('get', '/api/v1/items')">
                    <i class="bi bi-play-circle me-1"></i> Uji Request GET /api/v1/items
                </button>
            </div>
        </div>

        <!-- ENDPOINT 2: GET STATS -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success font-monospace px-3 py-2 fs-6">GET</span>
                    <span class="font-monospace small text-muted">/api/v1/stats</span>
                </div>
                <h6 class="fw-bold text-dark mb-1">Ambil Ringkasan Statistik Lab</h6>
                <p class="text-muted small mb-3">Mengambil rekap total stok, total barang rusak, dan total transaksi peminjaman.</p>
                <button class="btn btn-outline-success btn-sm w-100 fw-bold" onclick="testEndpoint('get', '/api/v1/stats')">
                    <i class="bi bi-play-circle me-1"></i> Uji Request GET /api/v1/stats
                </button>
            </div>
        </div>

        <!-- ENDPOINT 3: GET DETAIL ITEM -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success font-monospace px-3 py-2 fs-6">GET</span>
                    <span class="font-monospace small text-muted">/api/v1/items/{id}</span>
                </div>
                <h6 class="fw-bold text-dark mb-1">Ambil Detail 1 Barang Spesifik</h6>
                <p class="text-muted small mb-2">Mengambil objek data spesifik beserta riwayat peminjamannya.</p>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">ID Barang</span>
                    <input type="number" id="testDetailId" class="form-control" value="1" min="1">
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 fw-bold" onclick="testDetailEndpoint()">
                    <i class="bi bi-play-circle me-1"></i> Uji Request GET /api/v1/items/{id}
                </button>
            </div>
        </div>

        <!-- ENDPOINT 4: POST CREATE ITEM -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary font-monospace px-3 py-2 fs-6">POST</span>
                    <span class="font-monospace small text-muted">/api/v1/items</span>
                </div>
                <h6 class="fw-bold text-dark mb-1">Tambah Barang Baru via JSON Payload</h6>
                <p class="text-muted small mb-3">Mengirim data JSON baru dengan validasi otomatis (Status 201 Created atau 422 Unprocessable).</p>
                <button class="btn btn-outline-primary btn-sm w-100 fw-bold" onclick="testPostEndpoint()">
                    <i class="bi bi-send me-1"></i> Uji Request POST (Payload Dummy)
                </button>
            </div>
        </div>

    </div>

    <!-- LIVE CONSOLE RESPONS JSON -->
    <div class="card border-0 shadow-sm rounded-4 bg-dark text-light">
        <div class="card-header bg-black bg-opacity-50 py-3 px-4 d-flex justify-content-between align-items-center border-bottom border-secondary">
            <div>
                <span class="fw-bold text-info"><i class="bi bi-terminal-fill me-2"></i>Live API Response Console</span>
                <span class="badge bg-secondary ms-2" id="apiStatusBadge">MENUNGGU UJI COBA</span>
            </div>
            <span class="text-secondary small font-monospace" id="apiTimeBadge">- ms</span>
        </div>
        <div class="card-body p-4">
            <pre class="mb-0 text-white font-monospace small" style="max-height: 350px; overflow-y: auto;" id="apiConsoleOutput">
// Klik salah satu tombol "Uji Request" di atas untuk melihat respon JSON nyata dari server Laravel...</pre>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    async function testEndpoint(method, url, body = null) {
        const consoleEl = document.getElementById('apiConsoleOutput');
        const badgeEl = document.getElementById('apiStatusBadge');
        const timeEl = document.getElementById('apiTimeBadge');

        consoleEl.textContent = `// Mengirim HTTP ${method.toUpperCase()} ${url}...\n// Menunggu respon server...`;
        badgeEl.textContent = 'CONNECTING...';
        badgeEl.className = 'badge bg-warning text-dark ms-2';

        const startTime = performance.now();

        try {
            const options = {
                method: method.toUpperCase(),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };
            if (body) {
                options.body = JSON.stringify(body);
            }

            const response = await fetch(url, options);
            const endTime = performance.now();
            const elapsed = Math.round(endTime - startTime);

            const json = await response.json();

            timeEl.textContent = `${elapsed} ms`;
            badgeEl.textContent = `STATUS: ${response.status} ${response.statusText}`;
            if (response.ok) {
                badgeEl.className = 'badge bg-success ms-2';
            } else {
                badgeEl.className = 'badge bg-danger ms-2';
            }

            consoleEl.textContent = JSON.stringify(json, null, 2);
        } catch (err) {
            badgeEl.textContent = 'FETCH ERROR';
            badgeEl.className = 'badge bg-danger ms-2';
            consoleEl.textContent = `Error: ${err.message}`;
        }
    }

    function testDetailEndpoint() {
        const id = document.getElementById('testDetailId').value || 1;
        testEndpoint('get', `/api/v1/items/${id}`);
    }

    function testPostEndpoint() {
        const randomId = Math.floor(Math.random() * 900) + 100;
        const dummyPayload = {
            kode_barang: `LAB-API-${randomId}`,
            nama_barang: `Tester Alat API #${randomId}`,
            kategori: 'Jaringan',
            stok: 10,
            kondisi: 'Baik'
        };
        testEndpoint('post', '/api/v1/items', dummyPayload);
    }
</script>
@endverbatim
@endpush
