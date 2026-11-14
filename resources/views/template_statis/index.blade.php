<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang Lab Komputer & Jaringan</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-box-seam me-2"></i>Lab Inventaris SMK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/template-statis"><i class="bi bi-house-door me-1"></i> Data Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/template-statis/tambah"><i class="bi bi-plus-circle me-1"></i> Tambah Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <main class="container py-4">
        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Daftar Inventaris Barang Lab</h3>
                <p class="text-muted mb-0 small">Template Statis (Sebelum diubah menjadi Master Layout Blade & Eloquent CRUD)</p>
            </div>
            <a href="/template-statis/tambah" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang
            </a>
        </div>

        <!-- ALERT CONTOH -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Catatan untuk Siswa:</strong> Ini adalah template tampilan statis. Pada <strong>Modul 3</strong>, kalian akan memecah file ini menjadi <em>Master Layout</em> (<code>&#64;extends</code>, <code>&#64;yield</code>, <code>&#64;section</code>), dan pada <strong>Modul 5 & 6</strong> data tabel ini akan digantikan perulangan data dinamis dari Database!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- TABEL DATA INVENTARIS -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th class="text-center">Jumlah Stok</th>
                                <th>Kondisi</th>
                                <th class="text-center" style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DUMMY DATA 1 -->
                            <tr>
                                <td class="text-center">1</td>
                                <td><span class="badge bg-secondary font-monospace">LAB-001</span></td>
                                <td class="fw-semibold">PC All-in-One Core i5</td>
                                <td><span class="badge bg-light text-dark border">Komputer</span></td>
                                <td class="text-center"><span class="fw-bold">24</span> Unit</td>
                                <td><span class="badge bg-success">Baik</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/template-statis/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- DUMMY DATA 2 -->
                            <tr>
                                <td class="text-center">2</td>
                                <td><span class="badge bg-secondary font-monospace">LAB-002</span></td>
                                <td class="fw-semibold">Router MikroTik RB750Gr3</td>
                                <td><span class="badge bg-light text-dark border">Jaringan</span></td>
                                <td class="text-center"><span class="fw-bold">12</span> Unit</td>
                                <td><span class="badge bg-success">Baik</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/template-statis/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- DUMMY DATA 3 -->
                            <tr>
                                <td class="text-center">3</td>
                                <td><span class="badge bg-secondary font-monospace">LAB-003</span></td>
                                <td class="fw-semibold">Crimping Tool RJ-45 Cat5/Cat6</td>
                                <td><span class="badge bg-light text-dark border">Peralatan</span></td>
                                <td class="text-center"><span class="fw-bold">8</span> Pcs</td>
                                <td><span class="badge bg-warning text-dark">Rusak Ringan</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/template-statis/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- DUMMY DATA 4 -->
                            <tr>
                                <td class="text-center">4</td>
                                <td><span class="badge bg-secondary font-monospace">LAB-004</span></td>
                                <td class="fw-semibold">Switch Hub D-Link 24 Port</td>
                                <td><span class="badge bg-light text-dark border">Jaringan</span></td>
                                <td class="text-center"><span class="fw-bold">2</span> Unit</td>
                                <td><span class="badge bg-danger">Rusak Berat</span></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/template-statis/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-muted py-3 small d-flex justify-content-between align-items-center">
                <span>Menampilkan 4 data contoh</span>
                <span class="fst-italic">Lab Komputer & Jaringan SMK</span>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-3 mt-5">
        <div class="container text-center text-muted small">
            &copy; 2026 Lab Inventaris SMK — Praktik Pemrograman Web & Framework Laravel
        </div>
    </footer>

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
