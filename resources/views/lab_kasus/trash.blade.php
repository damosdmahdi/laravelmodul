@extends('layouts.belajar')

@section('title', 'Tong Sampah Inventaris (Soft Deletes) - Lab SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Inventaris
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-trash3-fill text-danger me-2"></i>Tong Sampah (Recycle Bin - Soft Deletes)
            </h3>
            <span class="text-muted small">Proteksi data: Barang yang dihapus tidak langsung lenyap permanen, melainkan tersimpan di recycle bin</span>
        </div>
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-box-seam me-1"></i> Inventaris Aktif
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

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- PENJELASAN EDUKASI SOFT DELETES -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-shield-shaded text-danger fs-3 me-2"></i>
                <h5 class="fw-bold text-dark mb-0">Mengapa Industri Memakai Soft Deletes di Laravel?</h5>
            </div>
            <p class="text-secondary small mb-2">
                Di perusahaan dan aplikasi nyata, <strong>data penting tidak pernah dihapus langsung dengan perintah SQL <code>DELETE FROM ...</code></strong>. Jika seorang staf tidak sengaja menghapus barang atau riwayat inventaris sekolah, data tersebut masih dapat diselamatkan!
            </p>
            <div class="bg-white p-3 rounded-3 border border-danger-subtle small text-dark">
                <div class="row g-2">
                    <div class="col-md-4">
                        <strong>1. Migration:</strong> <code>$table-&gt;softDeletes();</code>
                        <div class="text-muted" style="font-size: 0.75rem;">Menambahkan kolom <code>deleted_at</code> (tipe TIMESTAMP NULL).</div>
                    </div>
                    <div class="col-md-4">
                        <strong>2. Model:</strong> <code>use SoftDeletes;</code>
                        <div class="text-muted" style="font-size: 0.75rem;">Saat <code>$item-&gt;delete()</code> dipanggil, Laravel hanya mengisi waktu penghapusan.</div>
                    </div>
                    <div class="col-md-4">
                        <strong>3. Restore:</strong> <code>$item-&gt;restore();</code>
                        <div class="text-muted" style="font-size: 0.75rem;">Mengembalikan nilai <code>deleted_at</code> menjadi NULL sehingga aktif kembali.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RECYCLE BIN -->
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark mb-0">
                <i class="bi bi-archive-fill text-danger me-2"></i>Daftar Barang yang Sedang Dihapus Sementara
            </h6>
            <span class="badge bg-danger">{{ $trashItems->count() }} Barang di Tong Sampah</span>
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
                            <th>Waktu Dihapus</th>
                            <th class="text-center" style="width: 220px;">Aksi Pemulihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trashItems as $index => $item)
                            <tr>
                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                <td><span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span></td>
                                <td>
                                    <span class="fw-bold text-dark text-decoration-line-through">{{ $item->nama_barang }}</span>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $item->kategori }}</span></td>
                                <td class="text-center">{{ $item->stok }} Unit</td>
                                <td class="small text-danger">
                                    <i class="bi bi-clock me-1"></i>{{ $item->deleted_at ? $item->deleted_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- TOMBOL RESTORE -->
                                        <form action="{{ route('lab-kasus.restore', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm px-2" title="Pulihkan Data (Restore)">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan
                                            </button>
                                        </form>

                                        <!-- TOMBOL FORCE DELETE -->
                                        <form action="{{ route('lab-kasus.force-delete', $item->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Barang {{ $item->nama_barang }} akan DIHAPUS PERMANEN dari database dan tidak bisa dikembalikan. Lanjutkan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="Hapus Permanen">
                                                <i class="bi bi-x-octagon me-1"></i> Permanen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-check-circle-fill text-success fs-1 d-block mb-2"></i>
                                    Tong sampah kosong! Tidak ada data barang yang terhapus saat ini.
                                    <br><a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-primary btn-sm mt-2">Kembali ke Daftar Inventaris</a>
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
