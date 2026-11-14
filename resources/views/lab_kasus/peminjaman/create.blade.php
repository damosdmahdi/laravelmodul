@extends('layouts.belajar')

@section('title', 'Form Peminjaman Alat Lab - Lab SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('lab-kasus.peminjaman.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Ke Riwayat Peminjaman
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-clipboard-plus text-primary me-2"></i>Formulir Peminjaman Alat Lab
            </h3>
            <span class="text-muted small">Catat peminjaman barang lab untuk praktikum siswa SMK &bull; Logika stok berkurang</span>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- FORM INPUT -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-2"></i>Data Transaksi Peminjaman</h5>

                <form action="{{ route('lab-kasus.peminjaman.store') }}" method="POST">
                    @csrf

                    <!-- PILIH BARANG -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Barang yang Dipinjam <span class="text-danger">*</span></label>
                        <select name="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Barang (Hanya yang memiliki stok) --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    [{{ $item->kode_barang }}] {{ $item->nama_barang }} &mdash; Sisa Stok: {{ $item->stok }} Unit ({{ $item->kondisi }})
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- NAMA SISWA -->
                        <div class="col-md-7">
                            <label class="form-label fw-bold small">Nama Lengkap Siswa Peminjam <span class="text-danger">*</span></label>
                            <input type="text" name="nama_peminjam" class="form-control @error('nama_peminjam') is-invalid @enderror" placeholder="Contoh: Muhammad Farhan" value="{{ old('nama_peminjam') }}" required>
                            @error('nama_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- KELAS -->
                        <div class="col-md-5">
                            <label class="form-label fw-bold small">Kelas / Jurusan <span class="text-danger">*</span></label>
                            <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="10 PPLG 1" {{ old('kelas') == '10 PPLG 1' ? 'selected' : '' }}>10 PPLG 1</option>
                                <option value="10 PPLG 2" {{ old('kelas') == '10 PPLG 2' ? 'selected' : '' }}>10 PPLG 2</option>
                                <option value="11 RPL 1" {{ old('kelas', '11 RPL 1') == '11 RPL 1' ? 'selected' : '' }}>11 RPL 1</option>
                                <option value="11 RPL 2" {{ old('kelas') == '11 RPL 2' ? 'selected' : '' }}>11 RPL 2</option>
                                <option value="10 TKJ" {{ old('kelas') == '10 TKJ' ? 'selected' : '' }}>10 TKJ</option>
                                <option value="11 TKJ" {{ old('kelas') == '11 TKJ' ? 'selected' : '' }}>11 TKJ</option>
                            </select>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- JUMLAH PINJAM -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jumlah Unit Dipinjam <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" max="50" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Stok di rak akan terpotong sejumlah angka ini.</div>
                        </div>

                        <!-- TANGGAL PINJAM -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tanggal Peminjaman <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- CATATAN KEPERLUAN -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Catatan / Keperluan Praktikum</label>
                        <textarea name="catatan" rows="2" class="form-control @error('catatan') is-invalid @enderror" placeholder="Contoh: Praktik Pengkabelan Jaringan UTP atau Ujian Kompetensi Keahlian (UKK)">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-check-lg me-1"></i> Simpan Transaksi Peminjaman
                        </button>
                        <a href="{{ route('lab-kasus.peminjaman.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- INSIGHT LOGIKA LARAVEL SISWA -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light h-100">
                <h6 class="fw-bold text-dark mb-2">
                    <i class="bi bi-lightbulb-fill text-warning me-2"></i>Logika Bisnis di Balik Layar:
                </h6>
                <p class="text-secondary small mb-3">
                    Saat form ini dikirim, Controller mengeksekusi operasi relasi data dan manipulasi stok di tabel <code>items</code>:
                </p>

                <div class="p-3 bg-dark text-light rounded-3 font-monospace small mb-3">
                    <span class="text-secondary">// 1. Cek ketersediaan stok</span><br>
                    <span class="text-warning">if</span> ($item-&gt;stok &lt; $request-&gt;jumlah) {<br>
                    &nbsp;&nbsp;<span class="text-danger">return</span> back()-&gt;with(<span class="text-info">'error'</span>, <span class="text-info">'Stok kurang!'</span>);<br>
                    }<br><br>
                    <span class="text-secondary">// 2. Simpan transaksi</span><br>
                    Peminjaman::create([...]);<br><br>
                    <span class="text-secondary">// 3. Kurangi stok otomatis</span><br>
                    <span class="text-success">$item-&gt;decrement('stok', $request-&gt;jumlah);</span>
                </div>

                <div class="alert alert-info small border-0 mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    <strong>Penting untuk Siswa:</strong> Penggunaan fungsi bawaan <code>decrement()</code> di Laravel lebih aman dari *race condition* dibandingkan menghitung <code>$stok = $stok - 1</code> manual!
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
