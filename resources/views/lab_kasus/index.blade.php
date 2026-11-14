@extends('layouts.belajar')

@section('title', 'Sistem Inventaris Lab SMK - Dashboard & Daftar Barang')

@section('content')
<div class="container py-4">

    <!-- WATERMARK TANDA IDENTITAS SISWA PENGERJA -->
    <div class="student-watermark mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-person-check-fill fs-4"></i>
                </div>
                <div>
                    <span class="badge bg-primary mb-1">LEMBAR PENGERJAAN SISWA</span>
                    <h5 class="fw-bold mb-0 text-dark" id="wmStudentName">Memuat Identitas Siswa...</h5>
                    <div class="text-muted small mt-1">
                        <span id="wmStudentClass">11 RPL 1</span> &bull; 
                        <span id="wmStudentAbsen">No. Absen 01</span> &bull; 
                        <span class="badge bg-warning text-dark fw-bold" id="wmStudentRole">Role: Siswa</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                    <i class="bi bi-pencil-square me-1"></i> Ganti Identitas
                </button>
                <button class="btn btn-success btn-sm" onclick="copyStudentReport()">
                    <i class="bi bi-clipboard-check me-1"></i> Salin Bukti Tugas ke Guru
                </button>
            </div>
        </div>
    </div>

    <!-- FLASH MESSAGES NOTIFIKASI -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 5 STAT WIDGETS ATAS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-muted small fw-bold"><i class="bi bi-box me-1"></i> Total Jenis</span>
                <h3 class="fw-bold text-dark mt-1 mb-0">{{ $stats['total_barang'] ?? 0 }}</h3>
                <span class="text-secondary small" style="font-size: 0.75rem;">Item di inventaris</span>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-primary small fw-bold"><i class="bi bi-layers me-1"></i> Total Unit Stok</span>
                <h3 class="fw-bold text-primary mt-1 mb-0">{{ $stats['total_stok'] ?? 0 }}</h3>
                <span class="text-secondary small" style="font-size: 0.75rem;">Seluruh kuantitas unit</span>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-warning small fw-bold"><i class="bi bi-arrow-left-right me-1"></i> Dipinjam Siswa</span>
                <h3 class="fw-bold text-warning mt-1 mb-0">{{ $stats['total_dipinjam'] ?? 0 }}</h3>
                <span class="text-secondary small" style="font-size: 0.75rem;">Sedang aktif dipinjam</span>
            </div>
        </div>
        <div class="col-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-danger small fw-bold"><i class="bi bi-exclamation-triangle me-1"></i> Perlu Servis</span>
                <h3 class="fw-bold text-danger mt-1 mb-0">{{ $stats['total_rusak'] ?? 0 }}</h3>
                <span class="text-secondary small" style="font-size: 0.75rem;">Kondisi rusak ringan/berat</span>
            </div>
        </div>
        <div class="col-12 col-lg">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <span class="text-secondary small fw-bold"><i class="bi bi-trash3 me-1"></i> Tong Sampah</span>
                <h3 class="fw-bold text-secondary mt-1 mb-0">{{ $stats['total_trash'] ?? 0 }}</h3>
                <span class="text-secondary small" style="font-size: 0.75rem;">Barang di-soft delete</span>
            </div>
        </div>
    </div>

    <!-- QUICK SUB-NAVIGASI MODUL KASUS LAB -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
        <div class="card-body p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('lab-kasus.index') }}" class="btn btn-primary btn-sm px-3 fw-bold">
                    <i class="bi bi-box-seam me-1"></i> Daftar Inventaris
                </a>
                <a href="{{ route('lab-kasus.peminjaman.index') }}" class="btn btn-outline-primary btn-sm px-3">
                    <i class="bi bi-arrow-left-right me-1"></i> Transaksi Peminjaman
                </a>
                <a href="{{ route('lab-kasus.trash') }}" class="btn btn-outline-danger btn-sm px-3 position-relative">
                    <i class="bi bi-trash3 me-1"></i> Tong Sampah
                    @if(!empty($stats['total_trash']) && $stats['total_trash'] > 0)
                        <span class="badge bg-danger rounded-pill ms-1">{{ $stats['total_trash'] }}</span>
                    @endif
                </a>
                <a href="{{ route('lab-kasus.laporan') }}" class="btn btn-outline-success btn-sm px-3">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan Resmi
                </a>
                <a href="{{ route('lab-kasus.api-docs') }}" class="btn btn-outline-info text-dark btn-sm px-3">
                    <i class="bi bi-code-slash me-1"></i> RESTful API Docs
                </a>
            </div>
            <div>
                <a href="{{ route('lab-kasus.create') }}" class="btn btn-warning btn-sm text-dark fw-bold px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru
                </a>
            </div>
        </div>
    </div>

    <!-- PENCARIAN & FILTER SECTION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('lab-kasus.index') }}" method="GET" class="row g-2 align-items-center">
                @if(request('mode'))
                    <input type="hidden" name="mode" value="{{ request('mode') }}">
                @endif
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Cari nama barang atau kode..." value="{{ $q ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select form-select-sm">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Komputer" {{ ($kategori ?? '') == 'Komputer' ? 'selected' : '' }}>Komputer</option>
                        <option value="Jaringan" {{ ($kategori ?? '') == 'Jaringan' ? 'selected' : '' }}>Jaringan</option>
                        <option value="Peralatan" {{ ($kategori ?? '') == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                        <option value="Elektronik" {{ ($kategori ?? '') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kondisi" class="form-select form-select-sm">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="Baik" {{ ($kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Filter</button>
                    @if(!empty($q) || !empty($kategori) || !empty($kondisi))
                        <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL DATA BARANG -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-boxes text-primary me-2"></i>Daftar Master Inventaris Lab Komputer SMK
                </h5>
                <span class="text-muted small">
                    Mode Tampilan: 
                    @if($mode === 'dummy')
                        <span class="badge bg-warning text-dark">Data Dummy (Statis)</span>
                    @else
                        <span class="badge bg-success">Data Database SQLite (Real Time)</span>
                    @endif
                    &bull; Total <strong>{{ $items->count() }}</strong> barang ditemukan
                </span>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if ($mode === 'dummy')
                    <a href="{{ route('lab-kasus.index', ['mode' => 'db']) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-database me-1"></i> Mode Database
                    </a>
                @else
                    <a href="{{ route('lab-kasus.index', ['mode' => 'dummy']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-layout-text-window me-1"></i> Uji Mode Dummy
                    </a>
                @endif

                <!-- RESET BUTTON -->
                <form action="{{ route('lab-kasus.reset') }}" method="POST" onsubmit="return confirm('Reset database kembali ke 4 data awal?');" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Reset Data Database">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset DB
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-center">Dipinjam</th>
                            <th>Kondisi</th>
                            <th class="text-center" style="width: 190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('lab-kasus.show', $item->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                        {{ $item->nama_barang }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->kategori }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold fs-6 {{ $item->stok == 0 ? 'text-danger' : 'text-dark' }}">
                                        {{ $item->stok }}
                                    </span>
                                    <span class="text-muted small">Unit</span>
                                </td>
                                <td class="text-center">
                                    @if(isset($item->sedang_dipinjam) && $item->sedang_dipinjam > 0)
                                        <span class="badge bg-warning text-dark">{{ $item->sedang_dipinjam }} dipinjam</span>
                                    @else
                                        <span class="badge bg-light text-secondary border">0</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif ($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <!-- TOMBOL DETAIL -->
                                        <a href="{{ route('lab-kasus.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail & Riwayat">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- TOMBOL EDIT -->
                                        <a href="{{ route('lab-kasus.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- TOMBOL HAPUS SOFT DELETE -->
                                        <form action="{{ route('lab-kasus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Pindahkan barang {{ $item->nama_barang }} ke Tong Sampah? (Soft Delete)');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Pindahkan ke Tong Sampah">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada data barang yang sesuai dengan filter pencarian.
                                    <br><a href="{{ route('lab-kasus.index') }}" class="btn btn-link btn-sm mt-2">Reset Filter Pencarian</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white text-muted py-3 small d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>Menampilkan <strong>{{ $items->count() }}</strong> barang inventaris</span>
            <span class="text-secondary fst-italic">Lab Komputer &amp; Jaringan SMK &bull; Proteksi Soft Deletes Aktif</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    document.addEventListener('studentIdentityLoaded', function(e) {
        const { name, kelas, absen, role } = e.detail;
        const wmName = document.getElementById('wmStudentName');
        const wmClass = document.getElementById('wmStudentClass');
        const wmAbsen = document.getElementById('wmStudentAbsen');
        const wmRole = document.getElementById('wmStudentRole');

        if (wmName) wmName.textContent = name;
        if (wmClass) wmClass.textContent = kelas;
        if (wmAbsen) wmAbsen.textContent = `No. Absen ${absen}`;
        if (wmRole) wmRole.textContent = `Role: ${role}`;
    });

    function copyStudentReport() {
        const name = localStorage.getItem('smk_student_name') || 'Siswa SMK';
        const kelas = localStorage.getItem('smk_student_class') || '11 RPL 1';
        const absen = localStorage.getItem('smk_student_absen') || '01';
        const role = localStorage.getItem('smk_student_role') || 'Siswa';

        const text = `LAPORAN TUGAS PRAKTIKUM LARAVEL SMK\n` +
                     `Nama Siswa: ${name}\n` +
                     `Kelas: ${kelas} (No. Absen: ${absen})\n` +
                     `Peran Kerja: ${role}\n` +
                     `------------------------------------\n` +
                     `Fitur yang Diselesaikan:\n` +
                     `- Master Layout & Blade Templating\n` +
                     `- CRUD Inventaris + Detail & Pencarian\n` +
                     `- Transaksi Peminjaman Alat Lab\n` +
                     `- Proteksi Soft Deletes & Recycle Bin\n` +
                     `- RESTful API Endpoints\n` +
                     `------------------------------------\n` +
                     `Status: Berhasil dijalankan di lingkungan Laravel lokal!`;

        navigator.clipboard.writeText(text).then(() => {
            alert('✅ Bukti laporan pengerjaan telah disalin ke clipboard! Silakan paste (Ctrl+V) ke chat guru atau Google Classroom.');
        });
    }
</script>
@endverbatim
@endpush
