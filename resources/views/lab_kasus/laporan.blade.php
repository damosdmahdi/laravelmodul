@extends('layouts.belajar')

@section('title', 'Cetak Rekapitulasi Inventaris Lab Komputer SMK')

@section('content')
<div class="container py-4">

    <!-- NAVIGASI KEMBALI & TOMBOL CETAK (DISEMBUNYIKAN SAAT PRINT) -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Inventaris
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-printer-fill text-success me-2"></i>Rekapitulasi Resmi Inventaris Lab SMK
            </h3>
            <span class="text-muted small">Format dokumen resmi Berita Acara siap cetak atau ekspor ke PDF (Ctrl + P)</span>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success fw-bold px-4 shadow-sm" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- LEMBAR DOKUMEN CETAK RESMI -->
    <div class="card border shadow-sm rounded-4 p-5 bg-white print-page" style="color: #000;">
        
        <!-- KOP SURAT SEKOLAH -->
        <div class="border-bottom border-dark border-3 pb-3 mb-4 text-center">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="fs-1 text-dark">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-uppercase tracking-wider">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA</h5>
                    <h4 class="fw-bold mb-0 text-uppercase">SEKOLAH MENENGAH KEJURUAN NEGERI</h4>
                    <h6 class="fw-bold mb-0 text-uppercase text-secondary">KONSENTRASI KEAHLIAN PENGEMBANGAN PERANGKAT LUNAK DAN GIM (PPLG)</h6>
                    <small class="text-muted">Jl. Pendidikan Teknologi No. 45 &bull; Telepon: (021) 555-0199 &bull; Website: www.smk-pplg.sch.id</small>
                </div>
            </div>
        </div>

        <!-- JUDUL BERITA ACARA -->
        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase text-decoration-underline mb-1">BERITA ACARA REKAPITULASI INVENTARIS LAB KOMPUTER</h5>
            <small class="text-muted font-monospace">Nomor: 421.5 / LAB-INV / {{ date('Y') }} / {{ date('m') }}</small>
        </div>

        <p class="small text-muted mb-3" style="text-align: justify;">
            Pada hari ini <strong>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</strong>, telah dilakukan pemeriksaan fisik dan pencatatan kondisi barang inventaris Laboratorium Komputer dan Jaringan SMK dengan rincian data sebagai berikut:
        </p>

        <!-- REKAPITULASI RINGKAS -->
        <div class="row g-2 mb-4 text-center small">
            <div class="col-3">
                <div class="p-2 border rounded">
                    <span class="d-block text-muted">Total Jenis Barang</span>
                    <strong class="fs-6">{{ $stats['total_barang'] }} Jenis</strong>
                </div>
            </div>
            <div class="col-3">
                <div class="p-2 border rounded">
                    <span class="d-block text-muted">Total Unit Fisik</span>
                    <strong class="fs-6">{{ $stats['total_stok'] }} Unit</strong>
                </div>
            </div>
            <div class="col-3">
                <div class="p-2 border rounded">
                    <span class="d-block text-muted">Kondisi Baik</span>
                    <strong class="fs-6 text-success">{{ $stats['kondisi_baik'] }} Jenis</strong>
                </div>
            </div>
            <div class="col-3">
                <div class="p-2 border rounded">
                    <span class="d-block text-muted">Perlu Perbaikan</span>
                    <strong class="fs-6 text-danger">{{ $stats['kondisi_rusak'] }} Jenis</strong>
                </div>
            </div>
        </div>

        <!-- TABEL RINCIAN BARANG -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-sm align-middle small mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th style="width: 100px;">Kode Barang</th>
                        <th>Nama Alat / Barang</th>
                        <th>Kategori</th>
                        <th style="width: 80px;">Stok Rak</th>
                        <th style="width: 90px;">Dipinjam</th>
                        <th style="width: 110px;">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $idx => $item)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="font-monospace text-center fw-bold">{{ $item->kode_barang }}</td>
                            <td class="fw-semibold">{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td class="text-center">{{ $item->stok }} Unit</td>
                            <td class="text-center">{{ $item->sedang_dipinjam ?? 0 }} Unit</td>
                            <td class="text-center">
                                @if ($item->kondisi == 'Baik')
                                    <span class="badge bg-success bg-opacity-75 text-white">Baik</span>
                                @elseif ($item->kondisi == 'Rusak Ringan')
                                    <span class="badge bg-warning bg-opacity-75 text-dark">Rusak Ringan</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-75 text-white">Rusak Berat</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- KOLOM TANDA TANGAN -->
        <div class="row text-center mt-4 small pt-3">
            <div class="col-4">
                <span>Mengetahui,</span><br>
                <strong>Kepala Sekolah</strong>
                <div style="height: 70px;"></div>
                <strong class="text-decoration-underline">Drs. H. Hendra Saputra, M.Pd</strong><br>
                <span class="text-muted">NIP. 19750812 200003 1 002</span>
            </div>
            <div class="col-4">
                <span>Diperiksa Oleh,</span><br>
                <strong>Guru Pengampu Laravel / PPLG</strong>
                <div style="height: 70px;"></div>
                <strong class="text-decoration-underline" id="reportTeacherSign">Guru Produktif RPL</strong><br>
                <span class="text-muted">NIP. 19881105 201402 1 001</span>
            </div>
            <div class="col-4">
                <span>Petugas Pelapor,</span><br>
                <strong>Laboran / Siswa Pengerja</strong>
                <div style="height: 70px;"></div>
                <strong class="text-decoration-underline" id="reportStudentSign">Siswa Praktik</strong><br>
                <span class="text-muted" id="reportStudentClassSign">Kelas 11 RPL</span>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    document.addEventListener('studentIdentityLoaded', function(e) {
        const { name, kelas } = e.detail;
        const studentSign = document.getElementById('reportStudentSign');
        const classSign = document.getElementById('reportStudentClassSign');

        if (studentSign) studentSign.textContent = name;
        if (classSign) classSign.textContent = kelas;
    });
</script>
@endverbatim
@endpush
