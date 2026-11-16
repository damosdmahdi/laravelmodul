@extends('layouts.belajar')

@section('title', 'Edit Portofolio: ' . $portfolio->nama_usaha . ' - Admin UKK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Admin
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Portofolio: {{ $portfolio->nama_usaha }}
            </h3>
            <span class="text-muted small">Ubah informasi usaha, status terbit, dan produk unggulan</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('umkm.show', $portfolio->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Publik
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- FORM EDIT UTAMA -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold text-dark mb-3">Informasi Pokok UMKM</h5>

                <form action="{{ route('ukk.admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Usaha <span class="text-danger">*</span></label>
                        <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha', $portfolio->nama_usaha) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Slug URL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text small bg-light">/umkm/</span>
                            <input type="text" name="slug" class="form-control font-monospace" value="{{ old('slug', $portfolio->slug) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tagline Headline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $portfolio->tagline) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bio/Portofolio <span class="text-danger">*</span></label>
                        <textarea name="bio" rows="4" class="form-control" required>{{ old('bio', $portfolio->bio) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $portfolio->whatsapp) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Alamat Usaha</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $portfolio->alamat) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ganti Logo UMKM</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Status Terbit</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="published" {{ $portfolio->status == 'published' ? 'selected' : '' }}>Published (Website Aktif Dapat Diakses Publik)</option>
                            <option value="draft" {{ $portfolio->status == 'draft' ? 'selected' : '' }}>Draft (Disimpan Sebagai Draf Sementara)</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <!-- TAMBAH PRODUK UNGGULAN -->
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-plus-circle text-success me-1"></i> Tambah Produk Unggulan Baru:</h6>
                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="row g-2 mb-2">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold">Nama Produk</label>
                                <input type="text" name="new_product_nama" class="form-control form-control-sm" placeholder="Contoh: Kue Lapis Spesial">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Harga (Rp)</label>
                                <input type="number" name="new_product_harga" class="form-control form-control-sm" placeholder="85000">
                            </div>
                        </div>
                        <div>
                            <label class="form-label small fw-bold">Deskripsi Produk</label>
                            <input type="text" name="new_product_deskripsi" class="form-control form-control-sm" placeholder="Keterangan singkat rasa atau ukuran">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- DAFTAR PRODUK UNGGULAN SAAT INI -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Produk Unggulan UMKM</h5>
                    <span class="badge bg-primary">{{ $portfolio->products->count() }} Produk</span>
                </div>

                <div class="list-group list-group-flush mb-3">
                    @forelse ($portfolio->products as $prd)
                        <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-dark d-block">{{ $prd->nama_produk }}</span>
                                <span class="text-muted small">{{ $prd->deskripsi ?? '-' }}</span>
                            </div>
                            <span class="badge bg-success font-monospace">Rp {{ number_format($prd->harga, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">
                            Belum ada produk unggulan yang didaftarkan. Gunakan form di sebelah kiri untuk menambah produk.
                        </div>
                    @endforelse
                </div>

                <div class="alert alert-info small border-0 mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Produk-produk ini akan ditampilkan dalam bentuk katalog grid di landing page publik UMKM dengan tombol pesanan via WhatsApp.
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
