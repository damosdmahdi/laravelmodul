@extends('layouts.belajar')

@section('title', 'Studi Kasus: Sistem Inventaris Lab SMK (Halaman Tantangan)')

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
                        <span class="badge bg-warning text-dark fw-bold" id="wmStudentRole">Role: Siswa A</span>
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

    <!-- PANEL MISI PERBAIKAN SISWA -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold"><i class="bi bi-cone-striped me-2"></i>Misi Perbaikan Halaman Ini (Checklist Tugas Praktikum)</span>
                <span class="d-block small text-muted">Halaman ini fungsional, tetapi terdapat bug & tantangan yang harus diselesaikan siswa</span>
            </div>
            <div class="text-end">
                <span class="badge bg-dark text-white px-3 py-2" id="missionScore">Progres: 0 / 3 Selesai (0%)</span>
            </div>
        </div>
        <div class="card-body p-4">
            <p class="text-muted small mb-3">
                Bapak/Ibu Guru dapat memeriksa daftar ceklist tugas yang dikerjakan oleh siswa di bawah ini:
            </p>

            <div class="row g-3">
                <!-- MISI 1 -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 h-100 bg-light">
                        <div class="form-check">
                            <input class="form-check-input mission-check" type="checkbox" id="m1" onchange="updateMissions()">
                            <label class="form-check-label fw-bold small text-dark" for="m1">
                                Misi 1: Pecah Master Layout Blade
                            </label>
                        </div>
                        <p class="text-muted small mt-2 mb-0" style="font-size: 0.78rem;">
                            Pastikan halaman ini menggunakan <code>&#64;extends('layouts.app')</code> dan <code>&#64;yield('content')</code> agar tidak copy-paste navbar.
                        </p>
                    </div>
                </div>

                <!-- MISI 2 -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 h-100 bg-light">
                        <div class="form-check">
                            <input class="form-check-input mission-check" type="checkbox" id="m2" onchange="updateMissions()">
                            <label class="form-check-label fw-bold small text-dark" for="m2">
                                Misi 2: Hubungkan ke Database Eloquent
                            </label>
                        </div>
                        <p class="text-muted small mt-2 mb-0" style="font-size: 0.78rem;">
                            Ganti data statis/dummy menjadi data dinamis asli dari database SQLite menggunakan <code>Item::all()</code>.
                        </p>
                    </div>
                </div>

                <!-- MISI 3 -->
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 h-100 bg-light">
                        <div class="form-check">
                            <input class="form-check-input mission-check" type="checkbox" id="m3" onchange="updateMissions()">
                            <label class="form-check-label fw-bold small text-dark" for="m3">
                                Misi 3: Validasi Form & Method DELETE
                            </label>
                        </div>
                        <p class="text-muted small mt-2 mb-0" style="font-size: 0.78rem;">
                            Lengkapi form tambah dengan <code>$request->validate()</code> dan tombol hapus dengan form <code>&#64;method('DELETE')</code>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER KONTEN TABEL -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-box-seam text-primary me-2"></i>Daftar Inventaris Barang Lab Komputer SMK
                </h5>
                <span class="text-muted small">
                    Mode Tampilan Saat Ini: 
                    @if($mode === 'dummy')
                        <span class="badge bg-warning text-dark">Data Dummy (Statis)</span>
                    @else
                        <span class="badge bg-success">Data Database SQLite (Real Time)</span>
                    @endif
                </span>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <!-- TOGGLE DUMMY VS REAL DB -->
                @if ($mode === 'dummy')
                    <a href="{{ route('lab-kasus.index', ['mode' => 'db']) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-database me-1"></i> Beralih ke Data Asli Database
                    </a>
                @else
                    <a href="{{ route('lab-kasus.index', ['mode' => 'dummy']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-layout-text-window me-1"></i> Uji Mode Data Dummy
                    </a>
                @endif

                <a href="{{ route('lab-kasus.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru
                </a>

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
                            <th class="text-center">Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center" style="width: 170px;">Aksi</th>
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
                                    <span class="fw-bold text-dark">{{ $item->nama_barang }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->kategori }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $item->stok }}</span> Unit
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
                                        <!-- TOMBOL EDIT -->
                                        <a href="{{ route('lab-kasus.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit Barang">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <!-- TOMBOL HAPUS DENGAN METHOD DELETE -->
                                        <form action="{{ route('lab-kasus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang {{ $item->nama_barang }} ({{ $item->kode_barang }})?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Barang">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada data barang di tabel. Silakan klik tombol <strong>Tambah Barang Baru</strong> di atas!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white text-muted py-3 small d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>Menampilkan <strong>{{ $items->count() }}</strong> barang inventaris</span>
            <span class="text-secondary fst-italic">Lab Komputer & Jaringan SMK &bull; Kurikulum Fundamental Laravel</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
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

        loadMissions();
    });

    function updateMissions() {
        const m1 = document.getElementById('m1').checked;
        const m2 = document.getElementById('m2').checked;
        const m3 = document.getElementById('m3').checked;

        localStorage.setItem('smk_mission_m1', m1);
        localStorage.setItem('smk_mission_m2', m2);
        localStorage.setItem('smk_mission_m3', m3);

        calculateMissionScore();
    }

    function loadMissions() {
        const m1 = localStorage.getItem('smk_mission_m1') === 'true';
        const m2 = localStorage.getItem('smk_mission_m2') === 'true';
        const m3 = localStorage.getItem('smk_mission_m3') === 'true';

        document.getElementById('m1').checked = m1;
        document.getElementById('m2').checked = m2;
        document.getElementById('m3').checked = m3;

        calculateMissionScore();
    }

    function calculateMissionScore() {
        const checks = document.querySelectorAll('.mission-check:checked').length;
        const total = 3;
        const percent = Math.round((checks / total) * 100);

        const scoreEl = document.getElementById('missionScore');
        if (scoreEl) {
            scoreEl.textContent = `Progres: ${checks} / ${total} Selesai (${percent}%)`;
            if (percent === 100) {
                scoreEl.className = 'badge bg-success text-white px-3 py-2';
            } else if (percent > 0) {
                scoreEl.className = 'badge bg-warning text-dark px-3 py-2';
            } else {
                scoreEl.className = 'badge bg-dark text-white px-3 py-2';
            }
        }
    }

    function copyStudentReport() {
        const name = localStorage.getItem('smk_student_name') || 'Siswa SMK';
        const kelas = localStorage.getItem('smk_student_class') || '11 RPL 1';
        const absen = localStorage.getItem('smk_student_absen') || '01';
        const role = localStorage.getItem('smk_student_role') || 'Siswa A';

        const m1 = localStorage.getItem('smk_mission_m1') === 'true' ? '[SELESAI]' : '[BELUM]';
        const m2 = localStorage.getItem('smk_mission_m2') === 'true' ? '[SELESAI]' : '[BELUM]';
        const m3 = localStorage.getItem('smk_mission_m3') === 'true' ? '[SELESAI]' : '[BELUM]';

        const text = `LAPORAN TUGAS PRAKTIKUM LARAVEL SMK\n` +
                     `Nama Siswa: ${name}\n` +
                     `Kelas: ${kelas} (No. Absen: ${absen})\n` +
                     `Peran Kerja: ${role}\n` +
                     `------------------------------------\n` +
                     `Status Misi:\n` +
                     `1. Master Layout Blade: ${m1}\n` +
                     `2. Hubungkan Database Eloquent: ${m2}\n` +
                     `3. Validasi Form & Method DELETE: ${m3}\n` +
                     `------------------------------------\n` +
                     `Status: Berhasil dijalankan di lingkungan Laravel lokal!`;

        navigator.clipboard.writeText(text).then(() => {
            alert('✅ Bukti laporan pengerjaan telah disalin ke clipboard! Silakan paste (Ctrl+V) ke chat guru atau Google Classroom.');
        });
    }
</script>
@endpush
