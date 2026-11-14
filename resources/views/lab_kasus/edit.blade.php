@extends('layouts.belajar')

@section('title', 'Edit Barang Lab - Tantangan Praktikum Siswa')

@section('content')
<div class="container py-4">

    <!-- WATERMARK TANDA IDENTITAS SISWA -->
    <div class="student-watermark mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-warning text-dark mb-1">LEMBAR KERJA FORM EDIT (MODUL 6: UPDATE METHOD PUT)</span>
                <h6 class="fw-bold mb-0 text-dark">
                    Pengerja: <span id="editStudentName" class="text-primary">Memuat...</span> &bull; 
                    <span id="editStudentClass" class="text-muted">11 RPL</span>
                </h6>
            </div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Tabel
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2"></i>Perbarui Data Barang (ID: #{{ $item->id }})</h5>
                    <span class="badge bg-dark text-white">&#64;method('PUT')</span>
                </div>
                <div class="card-body p-4">

                    <!-- ALERT ERROR DARI VALIDASI LARAVEL -->
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm mb-4" role="alert">
                            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Periksa Kembali Input Anda:</h6>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lab-kasus.update', $item->id) }}" method="POST">
                        {{-- Tag Wajib CSRF --}}
                        @csrf
                        {{-- Directive Method Spoofing untuk UPDATE --}}
                        @method('PUT')

                        <div class="row g-3">
                            <!-- KODE BARANG -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang', $item->kode_barang) }}" required>
                                @error('kode_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NAMA BARANG -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold small">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang', $item->nama_barang) }}" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KATEGORI -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                    <option value="Komputer" {{ old('kategori', $item->kategori) == 'Komputer' ? 'selected' : '' }}>Komputer</option>
                                    <option value="Jaringan" {{ old('kategori', $item->kategori) == 'Jaringan' ? 'selected' : '' }}>Jaringan</option>
                                    <option value="Peralatan" {{ old('kategori', $item->kategori) == 'Peralatan' ? 'selected' : '' }}>Peralatan Praktek</option>
                                    <option value="Furnitur" {{ old('kategori', $item->kategori) == 'Furnitur' ? 'selected' : '' }}>Furnitur / Meja Kursi</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- JUMLAH STOK -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $item->stok) }}" min="0" required>
                                @error('stok')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KONDISI -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('lab-kasus.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-semibold text-dark">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Data (PUT)
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
        document.getElementById('editStudentName').textContent = name;
        document.getElementById('editStudentClass').textContent = kelas;
    });
</script>
@endpush
