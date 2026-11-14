@extends('layouts.belajar')

@section('title', 'Tambah Barang Lab - Tantangan Praktikum Siswa')

@section('content')
<div class="container py-4">

    <!-- WATERMARK TANDA IDENTITAS SISWA -->
    <div class="student-watermark mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary mb-1">LEMBAR KERJA FORM TAMBAH (MODUL 5 & 6)</span>
                <h6 class="fw-bold mb-0 text-dark">
                    Pengerja: <span id="formStudentName" class="text-primary">Memuat...</span> &bull; 
                    <span id="formStudentClass" class="text-muted">11 RPL</span>
                </h6>
            </div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Tabel
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- KARTU FORM TAMBAH -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i>Form Tambah Barang Baru (Eloquent Store)</h5>
                    <span class="badge bg-white text-primary">Modul 5 & 6</span>
                </div>
                <div class="card-body p-4">

                    <!-- ALERT ERROR DARI VALIDASI LARAVEL -->
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm mb-4" role="alert">
                            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Form Ditolak oleh Validasi Laravel:</h6>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lab-kasus.store') }}" method="POST">
                        {{-- Tag Wajib Proteksi Token CSRF --}}
                        @csrf

                        <div class="row g-3">
                            <!-- KODE BARANG -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang') }}" placeholder="Contoh: LAB-005">
                                @error('kode_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                                <div class="form-text small">Harus unik & belum terdaftar.</div>
                            </div>

                            <!-- NAMA BARANG -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold small">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" placeholder="Contoh: Tang Crimping RJ45 Cat6">
                                @error('nama_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KATEGORI -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                    <option value="Komputer" {{ old('kategori') == 'Komputer' ? 'selected' : '' }}>Komputer</option>
                                    <option value="Jaringan" {{ old('kategori') == 'Jaringan' ? 'selected' : '' }}>Jaringan</option>
                                    <option value="Peralatan" {{ old('kategori') == 'Peralatan' ? 'selected' : '' }}>Peralatan Praktek</option>
                                    <option value="Furnitur" {{ old('kategori') == 'Furnitur' ? 'selected' : '' }}>Furnitur / Meja Kursi</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- JUMLAH STOK -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}" min="0">
                                @error('stok')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KONDISI -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror">
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- SAKLAR FITUR UJI COBA TANPA VALIDASI (UNTUK GURU & SISWA) -->
                        <div class="p-3 bg-light rounded-3 border mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="skip_validation" value="1" id="skipVal">
                                <label class="form-check-label small fw-semibold text-danger" for="skipVal">
                                    Mode Uji: Lewati Validasi Server (Coba kirim form kosong untuk melihat peringatan)
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('lab-kasus.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="bi bi-save me-1"></i> Simpan ke Database
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('studentIdentityLoaded', function(e) {
        const { name, kelas } = e.detail;
        document.getElementById('formStudentName').textContent = name;
        document.getElementById('formStudentClass').textContent = kelas;
    });
</script>
@endpush
