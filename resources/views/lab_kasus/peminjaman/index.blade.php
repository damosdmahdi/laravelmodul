@extends('layouts.belajar')

@section('title', 'Sistem Peminjaman Alat Lab Komputer SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Ke Daftar Inventaris
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-arrow-left-right text-primary me-2"></i>Transaksi Peminjaman Alat Lab
            </h3>
            <span class="text-muted small">Mencatat peminjaman alat lab oleh siswa SMK &bull; Stok barang terpotong otomatis</span>
        </div>
        <div>
            <a href="{{ route('lab-kasus.peminjaman.create') }}" class="btn btn-primary btn-sm px-3 fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Catat Peminjaman Baru
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- STAT WIDGETS -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <span class="text-muted small fw-bold">Total Seluruh Transaksi</span>
                <h3 class="fw-bold text-dark mt-1 mb-0">{{ $stats['total'] ?? 0 }}</h3>
                <span class="text-secondary small">Riwayat keluar masuk alat</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                <span class="text-warning small fw-bold">Sedang Dipinjam Siswa</span>
                <h3 class="fw-bold text-warning mt-1 mb-0">{{ $stats['dipinjam'] ?? 0 }}</h3>
                <span class="text-secondary small">Alat belum dikembalikan</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
                <span class="text-success small fw-bold">Sudah Dikembalikan</span>
                <h3 class="fw-bold text-success mt-1 mb-0">{{ $stats['dikembalikan'] ?? 0 }}</h3>
                <span class="text-secondary small">Alat sudah kembali ke rak</span>
            </div>
        </div>
    </div>

    <!-- FILTER STATUS TABS -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link {{ empty($status) ? 'active' : '' }} btn-sm" href="{{ route('lab-kasus.peminjaman.index') }}">
                        Semua Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'Dipinjam' ? 'active' : '' }} btn-sm" href="{{ route('lab-kasus.peminjaman.index', ['status' => 'Dipinjam']) }}">
                        Sedang Dipinjam
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status == 'Dikembalikan' ? 'active' : '' }} btn-sm" href="{{ route('lab-kasus.peminjaman.index', ['status' => 'Dikembalikan']) }}">
                        Sudah Kembali
                    </a>
                </li>
            </ul>

            <span class="text-muted small">Total <strong>{{ $peminjamans->count() }}</strong> catatan peminjaman</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Siswa Peminjam</th>
                            <th>Kelas</th>
                            <th>Alat / Barang yang Dipinjam</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $index => $pinjam)
                            <tr>
                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $pinjam->nama_peminjam }}</span>
                                    @if($pinjam->catatan)
                                        <div class="text-muted small" style="font-size: 0.75rem;">
                                            <i class="bi bi-chat-left-text me-1"></i>{{ $pinjam->catatan }}
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $pinjam->kelas }}</span></td>
                                <td>
                                    @if($pinjam->item)
                                        <a href="{{ route('lab-kasus.show', $pinjam->item->id) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $pinjam->item->nama_barang }}
                                        </a>
                                        <div class="text-secondary font-monospace small" style="font-size: 0.72rem;">{{ $pinjam->item->kode_barang }}</div>
                                    @else
                                        <span class="text-danger fst-italic">[Barang Dihapus]</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold text-primary">{{ $pinjam->jumlah }} Unit</td>
                                <td class="small">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="small text-muted">
                                    {{ $pinjam->tanggal_kembali ? \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    @if ($pinjam->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark px-2 py-1">
                                            <i class="bi bi-hourglass-split me-1"></i>Dipinjam
                                        </span>
                                    @else
                                        <span class="badge bg-success px-2 py-1">
                                            <i class="bi bi-check-circle me-1"></i>Kembali
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($pinjam->status == 'Dipinjam')
                                        <form action="{{ route('lab-kasus.peminjaman.kembali', $pinjam->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian barang {{ $pinjam->item->nama_barang ?? '' }} oleh {{ $pinjam->nama_peminjam }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-box-arrow-in-left me-1"></i> Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success small fw-semibold">
                                            <i class="bi bi-check2-all me-1"></i>Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-clipboard-x fs-1 d-block mb-2 text-secondary"></i>
                                    Tidak ada catatan transaksi peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
