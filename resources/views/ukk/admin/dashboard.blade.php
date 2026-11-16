@extends('layouts.belajar')

@section('title', 'Dashboard Admin - Platform Web Portofolio UMKM UKK')

@section('content')
<div class="container-fluid px-lg-4 py-4">

    <!-- TOP BAR GREETING (SESUAI LAMPIRAN HALAMAN 5) -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 pb-3 border-bottom">
        <div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('belajar.ukk.panduan') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-arrow-left me-1"></i> Panduan UKK
                </a>
                <h3 class="fw-bold mb-0 text-dark">Selamat Datang, Admin</h3>
            </div>
            <span class="text-muted small">Panel Kontrol Platform Web Portofolio Instan UMKM (Model Done-For-You)</span>
        </div>

        <!-- ADMIN PROFILE & LOGOUT -->
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('ukk.admin.logs') }}" class="btn btn-outline-secondary btn-sm position-relative">
                <i class="bi bi-bell-fill"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.85rem;">
                    AD
                </div>
                <div class="d-none d-sm-block text-start lh-1">
                    <span class="d-block fw-bold small text-dark">{{ session('ukk_admin_name', 'Administrator') }}</span>
                    <span class="text-muted" style="font-size: 0.72rem;">Admin Utama</span>
                </div>
            </div>
            <form action="{{ route('ukk.admin.logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
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
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 3 KARTU STATISTIK UTAMA (SESUAI GAMBAR LAMPIRAN HALAMAN 5) -->
    <div class="row g-3 mb-4">
        <!-- 1. TOTAL UMKM -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-4 fs-3">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Total UMKM</span>
                        <h2 class="fw-bold text-dark mb-0">({{ $stats['total_umkm'] ?? 0 }})</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. WEBSITE AKTIF -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 fs-3">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Website Aktif</span>
                        <h2 class="fw-bold text-primary mb-0">({{ $stats['aktif'] ?? 0 }})</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. PERMINTAAN BARU / DRAFT -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning bg-opacity-15 text-warning rounded-4 fs-3">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold">Permintaan Baru / Draf</span>
                        <h2 class="fw-bold text-warning mb-0">({{ $stats['permintaan_baru'] ?? 0 }})</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN TWO COLUMN: FORM BUAT PORTOFOLIO (KIRI) & TABEL AKTIVITAS TERBARU (KANAN) -->
    <div class="row g-4 mb-4">

        <!-- KIRI: FORM BUAT PORTOFOLIO UMKM BARU (SESUAI GAMBAR LAMPIRAN HALAMAN 5) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-3">Buat Portofolio UMKM Baru</h5>

                <form action="{{ route('ukk.admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- NAMA USAHA & SLUG URL -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Usaha <span class="text-danger">*</span></label>
                        <input type="text" name="nama_usaha" id="inputNamaUsaha" class="form-control @error('nama_usaha') is-invalid @enderror" placeholder="Contoh: Kopi Kita" value="{{ old('nama_usaha') }}" required oninput="generateSlug(this.value)">
                        @error('nama_usaha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold mb-0">Slug URL (contoh: kue-enak) <span class="text-danger">*</span></label>
                            <span id="slugCheckBadge" class="badge bg-secondary font-monospace" style="font-size: 0.7rem;">Cek Otomatis</span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text small bg-light text-muted">/umkm/</span>
                            <input type="text" name="slug" id="inputSlug" class="form-control font-monospace @error('slug') is-invalid @enderror" placeholder="kopi-kita" value="{{ old('slug') }}" required oninput="checkSlugLive(this.value)">
                        </div>
                        <div id="slugFeedback" class="small mt-1 text-muted" style="font-size: 0.78rem;">
                            URL publik: <code>http://127.0.0.1:8000/umkm/<span id="slugPreviewText">kopi-kita</span></code>
                        </div>
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- BIO / PORTOFOLIO -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bio/Portofolio <span class="text-danger">*</span></label>
                        <textarea name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" placeholder="Ceritakan tentang usaha Anda, produk unggulan..." required>{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- UPLOAD LOGO UMKM -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Logo UMKM</label>
                        <input type="file" name="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept="image/*">
                        <div class="form-text small" style="font-size: 0.75rem;">Format: PNG, JPG, JPEG (Maks. 2MB)</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NOMOR WHATSAPP -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="+62 812 3456 789" value="{{ old('whatsapp', '+62 ') }}" required>
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- STATUS PENERBITAN -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Status Publikasi</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusPublish" value="published" checked>
                                <label class="form-check-label small fw-bold text-success" for="statusPublish">
                                    <i class="bi bi-broadcast me-1"></i> Terbitkan Sekarang (Aktif)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft">
                                <label class="form-check-label small text-secondary" for="statusDraft">
                                    <i class="bi bi-file-earmark me-1"></i> Simpan Draf
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI UTAMA (SESUAI GAMBAR HALAMAN 5) -->
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" id="btnSubmitPortfolio">
                        <i class="bi bi-send-fill me-1"></i> Terbitkan Website Portofolio
                    </button>
                </form>
            </div>
        </div>

        <!-- KANAN: TABEL AKTIVITAS TERBARU (SESUAI GAMBAR LAMPIRAN HALAMAN 5) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Aktivitas Terbaru</h5>
                        <span class="text-muted small">Daftar portofolio UMKM yang terdaftar di platform</span>
                    </div>
                    <a href="{{ route('ukk.admin.logs') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-clock-history me-1"></i> Log Riwayat
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama UMKM</th>
                                    <th>Link URL</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($portfolios as $p)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark d-block">{{ $p->nama_usaha }}</span>
                                            <span class="text-muted" style="font-size: 0.72rem;">{{ $p->products->count() }} Produk &bull; {{ $p->views }} Views</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('umkm.show', $p->slug) }}" target="_blank" class="text-primary text-decoration-none font-monospace">
                                                /umkm/{{ $p->slug }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($p->status === 'published')
                                                <form action="{{ route('ukk.admin.portfolios.toggle', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success px-2 py-0 rounded-pill" style="font-size: 0.72rem;" title="Klik untuk ubah jadi Draf">
                                                        <i class="bi bi-check-circle me-1"></i> Aktif
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('ukk.admin.portfolios.toggle', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-secondary px-2 py-0 rounded-pill" style="font-size: 0.72rem;" title="Klik untuk terbitkan Aktif">
                                                        <i class="bi bi-file-earmark me-1"></i> Draft
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('ukk.admin.portfolios.edit', $p->id) }}" class="btn btn-outline-primary" title="Edit Portofolio">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('ukk.admin.portfolios.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus portofolio {{ $p->nama_usaha }}?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus Portofolio">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Belum ada portofolio UMKM yang didaftarkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light py-2 px-3 small text-muted d-flex justify-content-between align-items-center">
                    <span>Total <strong>{{ $portfolios->count() }}</strong> UMKM tercatat</span>
                    <a href="{{ route('umkm.show', 'kue-enak-bu-sri') }}" target="_blank" class="text-decoration-none">
                        Lihat Contoh Landing Page Bu Sri &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- LOG AKTIVITAS AUDIT TRAIL WIDGET (SESUAI SYARAT UKK POIN 7) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-dark mb-0">
                <i class="bi bi-clock-history text-secondary me-2"></i>Log Aktivitas Perubahan Data Portofolio (Audit Trail)
            </h6>
            <span class="badge bg-secondary">Syarat Wajib UKK</span>
        </div>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th style="width: 150px;">Waktu</th>
                        <th style="width: 130px;">Pelaku</th>
                        <th style="width: 100px;">Aksi</th>
                        <th>Deskripsi Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentLogs as $log)
                        <tr>
                            <td class="text-muted font-monospace">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $log->admin_name }}</span></td>
                            <td>
                                @if($log->action == 'PUBLISH')
                                    <span class="badge bg-success">PUBLISH</span>
                                @elseif($log->action == 'CREATE')
                                    <span class="badge bg-primary">CREATE</span>
                                @elseif($log->action == 'UPDATE')
                                    <span class="badge bg-warning text-dark">UPDATE</span>
                                @elseif($log->action == 'DELETE')
                                    <span class="badge bg-danger">DELETE</span>
                                @else
                                    <span class="badge bg-secondary">{{ $log->action }}</span>
                                @endif
                            </td>
                            <td>{{ $log->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    function generateSlug(nama) {
        const slug = nama.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('inputSlug').value = slug;
        document.getElementById('slugPreviewText').textContent = slug || 'kopi-kita';
        checkSlugLive(slug);
    }

    let liveSlugTimer = null;
    async function checkSlugLive(slug) {
        clearTimeout(liveSlugTimer);
        document.getElementById('slugPreviewText').textContent = slug || 'kopi-kita';
        const badge = document.getElementById('slugCheckBadge');
        const feedback = document.getElementById('slugFeedback');
        const submitBtn = document.getElementById('btnSubmitPortfolio');

        if (!slug || slug.trim() === '') {
            badge.textContent = 'KOSONG';
            badge.className = 'badge bg-secondary font-monospace';
            return;
        }

        badge.textContent = 'MEMERIKSA...';
        badge.className = 'badge bg-warning text-dark font-monospace';

        liveSlugTimer = setTimeout(async () => {
            try {
                const res = await fetch('/api/check-slug?slug=' + encodeURIComponent(slug));
                const data = await res.json();

                if (data.available) {
                    badge.textContent = 'TERSEDIA';
                    badge.className = 'badge bg-success font-monospace';
                    feedback.innerHTML = `<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>URL valid: <code>/umkm/${data.slug}</code></span>`;
                    submitBtn.disabled = false;
                } else {
                    badge.textContent = 'SUDAH DIPAKAI';
                    badge.className = 'badge bg-danger font-monospace';
                    feedback.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i>${data.message}</span>`;
                    submitBtn.disabled = true;
                }
            } catch (err) {
                badge.textContent = 'ERROR';
                badge.className = 'badge bg-danger font-monospace';
            }
        }, 300);
    }
</script>
@endverbatim
@endpush
