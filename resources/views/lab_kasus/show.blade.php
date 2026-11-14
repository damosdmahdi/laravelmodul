@extends('layouts.belajar')

@section('title', 'Detail Barang: ' . $item->nama_barang . ' - Lab SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Inventaris
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>Detail Barang: {{ $item->nama_barang }}
            </h3>
            <span class="text-muted small">Rute: <code>GET /lab-kasus/detail/{{ $item->id }}</code> &bull; Controller: <code>LabKasusController@show</code></span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('lab-kasus.edit', $item->id) }}" class="btn btn-warning btn-sm text-dark fw-bold">
                <i class="bi bi-pencil-square me-1"></i> Edit Data
            </a>
            <a href="{{ route('lab-kasus.peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Pinjamkan Barang Ini
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- KARTU INFORMASI UTAMA -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-secondary font-monospace px-3 py-2 fs-6 mb-2">{{ $item->kode_barang }}</span>
                        <h4 class="fw-bold text-dark mb-1">{{ $item->nama_barang }}</h4>
                        <span class="badge bg-light text-dark border">{{ $item->kategori }}</span>
                    </div>
                    <div>
                        @if ($item->kondisi == 'Baik')
                            <span class="badge bg-success px-3 py-2">Kondisi Baik</span>
                        @elseif ($item->kondisi == 'Rusak Ringan')
                            <span class="badge bg-warning text-dark px-3 py-2">Rusak Ringan</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Rusak Berat</span>
                        @endif
                    </div>
                </div>

                <hr class="my-3">

                <!-- SIMULASI BARCODE / QR CODE LAB -->
                <div class="p-3 bg-light rounded-3 text-center mb-3">
                    <div class="font-monospace fs-1 tracking-widest text-dark" style="letter-spacing: 6px;">
                        ||| | |||| | ||| || |||
                    </div>
                    <span class="font-monospace text-muted small">* {{ $item->kode_barang }} - INVENTARIS SMK *</span>
                </div>

                <div class="row g-3 text-center mb-3">
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <span class="text-muted small d-block">Sisa Stok di Rak</span>
                            <span class="fs-3 fw-bold text-dark">{{ $item->stok }}</span>
                            <span class="text-secondary small d-block">Unit Tersedia</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <span class="text-muted small d-block">Sedang Dipinjam</span>
                            <span class="fs-3 fw-bold text-warning">
                                {{ $item->peminjamans->where('status', 'Dipinjam')->sum('jumlah') }}
                            </span>
                            <span class="text-secondary small d-block">Unit di Luar Lab</span>
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled small text-muted mb-0">
                    <li class="py-1 d-flex justify-content-between">
                        <span>Ditambahkan pada:</span>
                        <span class="fw-bold text-dark">{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</span>
                    </li>
                    <li class="py-1 d-flex justify-content-between">
                        <span>Terakhir diperbarui:</span>
                        <span class="fw-bold text-dark">{{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- RIWAYAT PEMINJAMAN BARANG OLEH SISWA -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="bi bi-clock-history text-primary me-2"></i>Riwayat Transaksi Peminjaman Barang Ini
                        </h6>
                        <span class="text-muted small">Data berelasi dari model <code>Peminjaman</code> (Eloquent HasMany)</span>
                    </div>
                    <span class="badge bg-primary">{{ $item->peminjamans->count() }} Transaksi</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Kelas</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($item->peminjamans as $pinjam)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $pinjam->nama_peminjam }}</span>
                                            @if($pinjam->catatan)
                                                <div class="text-muted" style="font-size: 0.72rem;">{{ Str::limit($pinjam->catatan, 35) }}</div>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $pinjam->kelas }}</span></td>
                                        <td class="text-center fw-bold">{{ $pinjam->jumlah }} unit</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($pinjam->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark">Dipinjam</span>
                                            @else
                                                <span class="badge bg-success">Kembali</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-clipboard-x fs-2 d-block mb-1 text-secondary"></i>
                                            Belum ada catatan peminjaman untuk barang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
