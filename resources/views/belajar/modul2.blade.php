@extends('layouts.belajar')

@section('title', 'Modul 2: Simulator Alur MVC & Route - Belajar Laravel SMK')

@push('styles')
<style>
    /* Styling Garis Konektor Pipeline */
    .pipeline-connector {
        flex: 1;
        height: 4px;
        background: #cbd5e1;
        position: relative;
        margin-top: 40px;
        transition: background 0.3s ease;
    }
    .pipeline-connector.active {
        background: #3b82f6;
    }
    .pipeline-connector .pulse-dot {
        position: absolute;
        top: -6px;
        left: 0%;
        width: 16px;
        height: 16px;
        background: #38bdf8;
        border-radius: 50%;
        box-shadow: 0 0 10px #0284c7;
        opacity: 0;
        transition: left 0.8s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s;
    }
    .pipeline-node-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 10px;
        transition: all 0.3s ease;
    }
    .step-badge-mini {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <!-- HEADER & BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 2: Simulator Alur MVC & Alur Request Laravel</h3>
            <p class="text-muted small mb-0">Ubah kode secara langsung dan lacak file/folder mana saja yang di-<em>hit</em> dengan animasi visual</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul1') }}" class="btn btn-outline-secondary btn-sm">Modul 1</a>
            <a href="{{ route('belajar.modul3') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 3 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- AREA VISUALISASI PIPELINE (ALUR REQUEST-RESPONSE) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-4">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1 text-primary">
                    <i class="bi bi-diagram-3-fill me-2"></i>Peta Jalur Eksekusi Framework (Request Pipeline)
                </h5>
                <span class="text-muted small">Perhatikan kotak yang menyala dan jalur data saat kamu menekan tombol kirim di bawah</span>
            </div>
            <div id="statusBadge" class="badge bg-secondary px-3 py-2 fs-6">
                Menunggu Input Request...
            </div>
        </div>

        <!-- DIAGRAM 4 NODE -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 px-lg-3">
            <!-- NODE 1: BROWSER -->
            <div class="pipeline-node text-center position-relative w-100" id="nodeBrowser" style="max-width: 170px;">
                <span class="step-badge-mini bg-dark text-white">1</span>
                <div class="pipeline-node-icon bg-light text-primary">
                    <i class="bi bi-browser-chrome"></i>
                </div>
                <h6 class="fw-bold mb-1 small">1. Web Browser</h6>
                <span class="text-muted" style="font-size: 0.72rem;">User mengetik URL</span>
                <div class="badge bg-light text-dark border mt-2 small font-monospace" id="labelRequestUrl">GET /barang</div>
            </div>

            <!-- CONNECTOR 1 -->
            <div class="pipeline-connector d-none d-md-block" id="conn1">
                <div class="pulse-dot" id="dot1"></div>
            </div>

            <!-- NODE 2: ROUTES/WEB.PHP -->
            <div class="pipeline-node text-center position-relative w-100" id="nodeRoute" style="max-width: 190px;">
                <span class="step-badge-mini bg-warning text-dark">2</span>
                <div class="pipeline-node-icon bg-light text-warning">
                    <i class="bi bi-signpost-2-fill"></i>
                </div>
                <h6 class="fw-bold mb-1 small text-dark">2. routes/web.php</h6>
                <span class="text-muted" style="font-size: 0.72rem;">Pencocokan Rute URL</span>
                <div class="badge bg-light text-muted border mt-2 small" id="labelRouteStatus">Checking...</div>
            </div>

            <!-- CONNECTOR 2 -->
            <div class="pipeline-connector d-none d-md-block" id="conn2">
                <div class="pulse-dot" id="dot2"></div>
            </div>

            <!-- NODE 3: CONTROLLER -->
            <div class="pipeline-node text-center position-relative w-100" id="nodeController" style="max-width: 210px;">
                <span class="step-badge-mini bg-success text-white">3</span>
                <div class="pipeline-node-icon bg-light text-success">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <h6 class="fw-bold mb-1 small text-dark">3. ItemController.php</h6>
                <span class="text-muted" style="font-size: 0.72rem;">Eksekusi Logika & Data</span>
                <div class="badge bg-light text-muted border mt-2 small" id="labelControllerMethod">index()</div>
            </div>

            <!-- CONNECTOR 3 -->
            <div class="pipeline-connector d-none d-md-block" id="conn3">
                <div class="pulse-dot" id="dot3"></div>
            </div>

            <!-- NODE 4: VIEW BLADE -->
            <div class="pipeline-node text-center position-relative w-100" id="nodeView" style="max-width: 190px;">
                <span class="step-badge-mini bg-danger text-white">4</span>
                <div class="pipeline-node-icon bg-light text-danger">
                    <i class="bi bi-window-sidebar"></i>
                </div>
                <h6 class="fw-bold mb-1 small text-dark">4. resources/views/</h6>
                <span class="text-muted" style="font-size: 0.72rem;">Render Blade & HTML</span>
                <div class="badge bg-light text-muted border mt-2 small" id="labelViewFile">items.index</div>
            </div>
        </div>

        <!-- INSPEKTOR FILE & FOLDER YANG DI-HIT -->
        <div class="p-3 rounded-3 bg-light border">
            <h6 class="fw-bold text-dark small mb-2">
                <i class="bi bi-activity text-primary me-1"></i> Live Trace Log: File & Folder yang Di-HIT oleh Framework
            </h6>
            <div class="code-box p-3" id="traceLog" style="height: 120px; font-size: 0.8rem; overflow-y: auto;">
                <span class="text-secondary">// Riwayat file yang dieksekusi akan muncul di sini secara berurutan...</span>
            </div>
        </div>
    </div>

    <!-- PLAYGROUND CODING: COBA-COBA UBAH KODE -->
    <div class="row g-4">
        <!-- FORM SIMULASI INPUT REQUEST -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-sliders me-2 text-warning"></i>Pusat Kendali Uji Coba</span>
                    <span class="badge bg-primary">Uji Request</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small">
                        Pilih atau ketik URL yang ingin kamu uji, lalu tekan tombol <strong>Jalankan Alur</strong> untuk melihat animasi perjalanannya!
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Skenario Cepat:</label>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm text-start" onclick="setScenario('/barang', 'GET', 'Tampil Data')">
                                <i class="bi bi-check2-circle text-success me-1"></i> <strong>GET /barang</strong> (Alur Normal: Route &rarr; Controller &rarr; View)
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm text-start" onclick="setScenario('/barang/tambah', 'GET', 'Form Tambah')">
                                <i class="bi bi-check2-circle text-success me-1"></i> <strong>GET /barang/tambah</strong> (Membuka Form Tambah Barang)
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm text-start" onclick="setScenario('/tidak-ada', 'GET', '404 Not Found')">
                                <i class="bi bi-x-circle text-danger me-1"></i> <strong>GET /tidak-ada</strong> (Uji Coba Rute Salah &rarr; Muncul 404!)
                            </button>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Ketik URL Manual:</label>
                        <div class="input-group">
                            <select class="form-select flex-grow-0" style="width: 90px;" id="inputMethod">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                            </select>
                            <input type="text" class="form-control font-monospace" id="inputUrl" value="/barang">
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" onclick="runPipelineSimulation()">
                        <i class="bi bi-play-circle-fill me-2"></i> ▶️ Kirim Request & Lacak Jalur
                    </button>
                </div>
            </div>
        </div>

        <!-- PREVIEW RESPONSE BROWSER HASIL AKHIR -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-laptop me-2 text-primary"></i>Simulasi Layar Browser Siswa</span>
                    <span class="badge bg-success" id="browserStatusBadge">Status: Siap</span>
                </div>
                <div class="card-body p-4 bg-light" id="browserViewport">
                    <div class="bg-white border rounded-3 p-4 shadow-sm text-center" style="min-height: 250px;">
                        <i class="bi bi-cursor-fill text-muted fs-1 mb-2 d-block"></i>
                        <h6 class="fw-bold text-dark">Belum ada request yang dikirim</h6>
                        <p class="text-muted small">
                            Tekan tombol <strong>"▶️ Kirim Request & Lacak Jalur"</strong> di sebelah kiri untuk melihat halaman ini merender hasil tampilan dari View Blade.
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
    function setScenario(url, method, desc) {
        document.getElementById('inputUrl').value = url;
        document.getElementById('inputMethod').value = method;
        runPipelineSimulation();
    }

    function runPipelineSimulation() {
        const url = document.getElementById('inputUrl').value.trim();
        const method = document.getElementById('inputMethod').value;
        const statusBadge = document.getElementById('statusBadge');
        const traceLog = document.getElementById('traceLog');
        const viewport = document.getElementById('browserViewport');
        const browserBadge = document.getElementById('browserStatusBadge');

        // Reset All Nodes & Connectors
        const nodes = ['nodeBrowser', 'nodeRoute', 'nodeController', 'nodeView'];
        nodes.forEach(id => {
            const el = document.getElementById(id);
            el.className = 'pipeline-node text-center position-relative w-100';
        });
        ['conn1', 'conn2', 'conn3'].forEach(id => document.getElementById(id).classList.remove('active'));
        ['dot1', 'dot2', 'dot3'].forEach(id => {
            const dot = document.getElementById(id);
            dot.style.left = '0%';
            dot.style.opacity = '0';
        });

        traceLog.innerHTML = `<span class="text-info">[${new Date().toLocaleTimeString()}] Memulai request baru...</span><br>`;
        document.getElementById('labelRequestUrl').textContent = `${method} ${url}`;

        // STEP 1: BROWSER REQUEST
        const nodeBrowser = document.getElementById('nodeBrowser');
        nodeBrowser.classList.add('active-hit');
        statusBadge.className = 'badge bg-primary px-3 py-2 fs-6';
        statusBadge.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Mengirim ${method} ${url}`;
        traceLog.innerHTML += `<span class="text-light">[1. BROWSER] Mengirimkan HTTP Request ke server web: <strong>${method} ${url}</strong></span><br>`;

        // STEP 2: ANIMASI KE ROUTE (DELAY 600ms)
        setTimeout(() => {
            const conn1 = document.getElementById('conn1');
            const dot1 = document.getElementById('dot1');
            conn1.classList.add('active');
            dot1.style.opacity = '1';
            dot1.style.left = '100%';

            setTimeout(() => {
                const nodeRoute = document.getElementById('nodeRoute');
                
                if (url === '/tidak-ada' || (!url.startsWith('/barang') && url !== '/')) {
                    // SKENARIO 404 NOT FOUND
                    nodeRoute.classList.add('error-hit');
                    statusBadge.className = 'badge bg-danger px-3 py-2 fs-6';
                    statusBadge.textContent = '❌ 404 NOT FOUND';
                    document.getElementById('labelRouteStatus').textContent = '404 (Tidak Ada)';
                    document.getElementById('labelRouteStatus').className = 'badge bg-danger text-white border mt-2 small';

                    traceLog.innerHTML += `<span class="text-danger fw-bold">[2. HIT: routes/web.php] Rute "${url}" TIDAK DITEMUKAN di file routes/web.php!</span><br>`;
                    traceLog.innerHTML += `<span class="text-secondary">&rarr; Eksekusi berhenti. Browser menampilkan layar 404 Not Found.</span><br>`;
                    traceLog.scrollTop = traceLog.scrollHeight;

                    browserBadge.className = 'badge bg-danger';
                    browserBadge.textContent = 'HTTP 404';
                    viewport.innerHTML = `
                        <div class="bg-white border border-danger rounded-3 p-4 shadow-sm text-center">
                            <h1 class="text-danger display-4 fw-bold">404</h1>
                            <h5 class="fw-bold text-dark">Halaman Tidak Ditemukan (Route Not Found)</h5>
                            <p class="text-muted small">
                                Rute <code>${url}</code> belum didaftarkan di dalam file <code>routes/web.php</code>.
                                <br>Buka file <strong>routes/web.php</strong> dan tambahkan:
                                <br><code class="text-primary">Route::get('${url}', [ItemController::class, 'index']);</code>
                            </p>
                        </div>
                    `;
                    return;
                }

                // ROUTE COCOK
                nodeRoute.classList.add('success-hit');
                document.getElementById('labelRouteStatus').textContent = 'Match (Baris 18)';
                document.getElementById('labelRouteStatus').className = 'badge bg-success text-white border mt-2 small';
                traceLog.innerHTML += `<span class="text-success">[2. HIT: routes/web.php] Rute "${url}" COCOK! Mengarahkan request ke ItemController.</span><br>`;
                traceLog.scrollTop = traceLog.scrollHeight;

                // STEP 3: ANIMASI KE CONTROLLER (DELAY 600ms)
                setTimeout(() => {
                    const conn2 = document.getElementById('conn2');
                    const dot2 = document.getElementById('dot2');
                    conn2.classList.add('active');
                    dot2.style.opacity = '1';
                    dot2.style.left = '100%';

                    setTimeout(() => {
                        const nodeController = document.getElementById('nodeController');
                        nodeController.classList.add('success-hit');

                        const methodExec = url.includes('/tambah') ? 'create()' : 'index()';
                        document.getElementById('labelControllerMethod').textContent = methodExec;

                        traceLog.innerHTML += `<span class="text-info">[3. HIT: app/Http/Controllers/ItemController.php] Menjalankan method <strong>${methodExec}</strong>.</span><br>`;
                        if (methodExec === 'index()') {
                            traceLog.innerHTML += `<span class="text-warning">[3b. HIT: app/Models/Item.php] Memanggil <code>Item::all()</code> untuk mengambil data tabel SQLite.</span><br>`;
                        }
                        traceLog.scrollTop = traceLog.scrollHeight;

                        // STEP 4: ANIMASI KE VIEW (DELAY 600ms)
                        setTimeout(() => {
                            const conn3 = document.getElementById('conn3');
                            const dot3 = document.getElementById('dot3');
                            conn3.classList.add('active');
                            dot3.style.opacity = '1';
                            dot3.style.left = '100%';

                            setTimeout(() => {
                                const nodeView = document.getElementById('nodeView');
                                nodeView.classList.add('success-hit');

                                const viewName = url.includes('/tambah') ? 'items.create' : 'items.index';
                                document.getElementById('labelViewFile').textContent = viewName;

                                traceLog.innerHTML += `<span class="text-primary">[4. HIT: resources/views/${viewName}.blade.php] Merender template Blade menjadi HTML akhir.</span><br>`;
                                traceLog.innerHTML += `<span class="text-success fw-bold">[RESPONSE 200 OK] Halaman sukses ditampilkan di browser siswa!</span><br>`;
                                traceLog.scrollTop = traceLog.scrollHeight;

                                statusBadge.className = 'badge bg-success px-3 py-2 fs-6';
                                statusBadge.textContent = '✅ Alur Sukses (200 OK)';

                                browserBadge.className = 'badge bg-success';
                                browserBadge.textContent = 'HTTP 200 OK';

                                // RENDER PREVIEW HTML BROWSER
                                if (url.includes('/tambah')) {
                                    viewport.innerHTML = `
                                        <div class="bg-white border rounded-3 p-3 shadow-sm">
                                            <div class="border-bottom pb-2 mb-3 d-flex justify-content-between align-items-center">
                                                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-file-earmark-plus"></i> Form Tambah Barang Lab</h6>
                                                <span class="badge bg-light text-dark border">items.create</span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold">Kode Barang</label>
                                                <input type="text" class="form-control form-control-sm" value="LAB-005" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold">Nama Barang</label>
                                                <input type="text" class="form-control form-control-sm" value="Kabel LAN Cat6" readonly>
                                            </div>
                                            <button class="btn btn-primary btn-sm mt-2"><i class="bi bi-save"></i> Simpan Barang</button>
                                        </div>
                                    `;
                                } else {
                                    viewport.innerHTML = `
                                        <div class="bg-white border rounded-3 p-3 shadow-sm">
                                            <div class="border-bottom pb-2 mb-3 d-flex justify-content-between align-items-center">
                                                <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-box-seam"></i> Daftar Inventaris Lab SMK</h6>
                                                <span class="badge bg-light text-dark border">items.index</span>
                                            </div>
                                            <table class="table table-sm table-bordered align-middle small mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama Barang</th>
                                                        <th>Stok</th>
                                                        <th>Kondisi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="badge bg-secondary font-monospace">LAB-001</span></td>
                                                        <td>PC All-in-One Core i5</td>
                                                        <td>24 Unit</td>
                                                        <td><span class="badge bg-success">Baik</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-secondary font-monospace">LAB-002</span></td>
                                                        <td>Router MikroTik RB750Gr3</td>
                                                        <td>12 Unit</td>
                                                        <td><span class="badge bg-success">Baik</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    `;
                                }
                            }, 500);
                        }, 500);

                    }, 500);
                }, 500);

            }, 500);
        }, 500);
    }
</script>
@endpush
