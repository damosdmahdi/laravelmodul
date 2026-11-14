@extends('layouts.belajar')

@section('title', 'Sistem Pemeriksa Tugas Otomatis (Autochecker) - Belajar Laravel SMK')

@push('styles')
<style>
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border: 6px solid #3b82f6;
        background: #ffffff;
    }
    .check-item-card {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 12px 16px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .check-item-card.passed {
        border-left: 5px solid #10b981;
        background: #f0fdf4;
    }
    .check-item-card.failed {
        border-left: 5px solid #ef4444;
        background: #fef2f2;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <!-- WATERMARK TANDA IDENTITAS SISWA -->
    <div class="student-watermark mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-patch-check-fill fs-3"></i>
                </div>
                <div>
                    <span class="badge bg-success mb-1">AUTOMATED CODE EVALUATOR</span>
                    <h5 class="fw-bold mb-0 text-dark" id="tsStudentName">Memuat Identitas Siswa...</h5>
                    <div class="text-muted small mt-1">
                        <span id="tsStudentClass">11 RPL 1</span> &bull; 
                        <span id="tsStudentAbsen">No. Absen 01</span> &bull; 
                        <span class="badge bg-primary text-white" id="tsStudentRole">Pengerjaan Proyek Mandiri</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentIdentityModal">
                    <i class="bi bi-pencil-square me-1"></i> Ganti Identitas
                </button>
                <button class="btn btn-success btn-sm px-3 fw-semibold" onclick="copyAutoGraderReport()">
                    <i class="bi bi-clipboard-check me-1"></i> Salin Rapor Nilai ke Guru
                </button>
            </div>
        </div>
    </div>

    <!-- FLASH NOTIFIKASI -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- HERO HEADER: AUTOGRADER STATUS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-4">
        <div class="row align-items-center g-4">
            <!-- SKOR & NILAI -->
            <div class="col-md-4 text-center border-end">
                <div class="score-circle mb-2 shadow-sm border-{{ $evaluation['percentage'] >= 75 ? 'success' : ($evaluation['percentage'] >= 50 ? 'warning' : 'primary') }}">
                    <span class="fs-2 fw-extrabold text-dark mb-0">{{ $evaluation['total_score'] }}</span>
                    <span class="text-muted" style="font-size: 0.72rem;">DARI 100 POIN</span>
                </div>
                <h6 class="fw-bold mb-1 text-dark">Predikat: <span class="text-{{ $evaluation['percentage'] >= 75 ? 'success' : ($evaluation['percentage'] >= 50 ? 'warning' : 'danger') }}">{{ $evaluation['grade'] }}</span></h6>
                <span class="badge bg-light text-secondary border small">{{ $evaluation['summary_status'] }}</span>
            </div>

            <!-- KETERANGAN LOKASI FOLDER & SCANNER BUTTON -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Sistem Verifikasi File Proyek Siswa</h5>
                        <p class="text-muted small mb-0">
                            Folder yang dipindai: <code class="bg-light p-1 rounded font-monospace">{{ $evaluation['folder_path'] }}</code>
                        </p>
                    </div>
                    <div>
                        @if ($evaluation['folder_exists'])
                            <span class="badge bg-success"><i class="bi bi-folder-check me-1"></i>Folder Terdeteksi</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-folder-x me-1"></i>Folder Belum Ada</span>
                        @endif
                    </div>
                </div>

                <!-- PROGRESS BAR -->
                <div class="progress mb-3" style="height: 12px;">
                    <div class="progress-bar bg-{{ $evaluation['percentage'] >= 75 ? 'success' : ($evaluation['percentage'] >= 50 ? 'warning' : 'primary') }} progress-bar-striped progress-bar-animated" 
                         role="progressbar" 
                         style="width: {{ $evaluation['percentage'] }}%;">
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('tugas.index') }}" class="btn btn-primary btn-sm px-3 fw-bold" id="btnScanAgain">
                        <i class="bi bi-arrow-repeat me-1"></i> Pindai Ulang File Siswa (Re-scan)
                    </a>

                    @if (!$evaluation['folder_exists'])
                        <form action="{{ route('tugas.init') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold">
                                <i class="bi bi-magic me-1"></i> Siapkan Folder tugas-siswa/ (1-Klik)
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('belajar.modul1') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-journal-text me-1"></i> Buka Panduan Modul
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JIKA FOLDER BELUM DIBUAT OLEH SISWA -->
    @if (!$evaluation['folder_exists'])
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light border-warning p-4">
            <h5 class="fw-bold text-dark mb-2"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Instruksi Untuk Siswa yang Baru Mulai:</h5>
            <p class="text-muted small mb-3">
                Sistem belum mendeteksi adanya folder <code>tugas-siswa/</code> di dalam repositori ini. Siswa dapat membuatnya melalui dua cara:
            </p>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border">
                        <span class="badge bg-primary mb-2">Cara 1 (Otomatis & Cepat)</span>
                        <p class="small text-muted mb-2">Klik tombol di bawah ini untuk membuat kerangka dasar folder siswa secara otomatis:</p>
                        <form action="{{ route('tugas.init') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                                <i class="bi bi-play-fill me-1"></i> Buat Folder & Template Dasar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-3 rounded-3 border">
                        <span class="badge bg-secondary mb-2">Cara 2 (Manual lewat Terminal)</span>
                        <p class="small text-muted mb-2">Buka terminal di root proyek dan jalankan:</p>
                        <pre class="code-box p-2 mb-0 small"><code>mkdir tugas-siswa
cd tugas-siswa
composer create-project laravel/laravel .</code></pre>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TABEL EVALUASI 6 MODUL TUGAS SISWA -->
    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-card-checklist text-primary me-2"></i>Rincian Verifikasi 6 Modul Penugasan Siswa</h5>

    <div class="row g-3 mb-4">
        @foreach ($evaluation['modules'] as $modulKey => $m)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">{{ $m['title'] }}</span>
                        <div>
                            @if ($m['status'] === 'LULUS')
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>LULUS ({{ $m['score'] }}/{{ $m['max'] }})</span>
                            @elseif ($m['status'] === 'SEBAGIAN')
                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle-fill me-1"></i>SEBAGIAN ({{ $m['score'] }}/{{ $m['max'] }})</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-x-circle-fill me-1"></i>BELUM (0/{{ $m['max'] }})</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @foreach ($m['items'] as $item)
                            <div class="check-item-card {{ $item['passed'] ? 'passed' : 'failed' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($item['passed'])
                                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                        @endif
                                        <span class="fw-bold small {{ $item['passed'] ? 'text-dark' : 'text-danger' }}">{{ $item['title'] }}</span>
                                    </div>
                                    <span class="badge bg-light text-dark border small">+{{ $item['points'] }} Poin</span>
                                </div>
                                @if (!$item['passed'])
                                    <div class="small text-muted mt-1 ps-4" style="font-size: 0.78rem;">
                                        <i class="bi bi-info-circle text-primary me-1"></i><strong>Petunjuk Siswa:</strong> {{ $item['hint'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('studentIdentityLoaded', function(e) {
        const { name, kelas, absen, role } = e.detail;
        const nameEl = document.getElementById('tsStudentName');
        const classEl = document.getElementById('tsStudentClass');
        const absenEl = document.getElementById('tsStudentAbsen');
        const roleEl = document.getElementById('tsStudentRole');

        if (nameEl) nameEl.textContent = name;
        if (classEl) classEl.textContent = kelas;
        if (absenEl) absenEl.textContent = `No. Absen ${absen}`;
        if (roleEl) roleEl.textContent = role;
    });

    function copyAutoGraderReport() {
        const name = localStorage.getItem('smk_student_name') || 'Siswa SMK';
        const kelas = localStorage.getItem('smk_student_class') || '11 RPL 1';
        const absen = localStorage.getItem('smk_student_absen') || '01';
        const role = localStorage.getItem('smk_student_role') || 'Mandiri';

        const totalScore = '{{ $evaluation['total_score'] }}';
        const grade = '{{ $evaluation['grade'] }}';
        const date = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

        const report = `====================================\n` +
                       `RAPOR EVALUASI OTOMATIS TUGAS LARAVEL\n` +
                       `====================================\n` +
                       `Nama Siswa   : ${name}\n` +
                       `Kelas        : ${kelas} (No. Absen: ${absen})\n` +
                       `Peran Kerja  : ${role}\n` +
                       `Tanggal Cek  : ${date}\n` +
                       `------------------------------------\n` +
                       `SKOR AKHIR   : ${totalScore} / 100 POIN\n` +
                       `PREDIKAT     : ${grade}\n` +
                       `------------------------------------\n` +
                       `Status Evaluasi Modul:\n` +
                       @foreach ($evaluation['modules'] as $m)
                       `- {{ $m['title'] }}: {{ $m['status'] }} ({{ $m['score'] }}/{{ $m['max'] }} Poin)\n` +
                       @endforeach
                       `====================================\n` +
                       `Diverifikasi otomatis oleh Sistem Autochecker Laravel SMK.`;

        navigator.clipboard.writeText(report).then(() => {
            alert('✅ Rapor nilai evaluasi tugas berhasil disalin ke clipboard! Silakan paste (Ctrl+V) ke chat WhatsApp guru atau Google Classroom.');
        });
    }
</script>
@endpush
