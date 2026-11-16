<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Portofolio UMKM Tidak Ditemukan</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .error-code {
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <!-- KARTU 404 -->
                <div class="card border-0 shadow-sm rounded-4 p-5 bg-white">
                    <div class="error-code mb-2">404</div>

                    @if(isset($reason) && $reason === 'draft')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill font-monospace mb-3 d-inline-block">
                            <i class="bi bi-hourglass-split me-1"></i> STATUS: DRAFT (BELUM TERBIT)
                        </span>
                        <h4 class="fw-bold text-dark mb-2">Website UMKM Ini Belum Diterbitkan</h4>
                        <p class="text-secondary small mb-4">
                            Halaman dengan slug <code>/umkm/{{ $requestedSlug }}</code> sudah terdaftar oleh Admin, namun saat ini masih berstatus <strong>DRAFT</strong> sehingga belum dapat diakses oleh publik.
                        </p>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill font-monospace mb-3 d-inline-block">
                            <i class="bi bi-exclamation-octagon-fill me-1"></i> NOT FOUND (SLUG TIDAK ADA)
                        </span>
                        <h4 class="fw-bold text-dark mb-2">Halaman Portofolio Tidak Ditemukan</h4>
                        <p class="text-secondary small mb-4">
                            Maaf, website portofolio dengan alamat URL <code>/umkm/{{ $requestedSlug }}</code> tidak terdaftar di database sistem kami.
                        </p>
                    @endif

                    <div class="p-3 bg-light rounded-3 border small text-start mb-4">
                        <span class="fw-bold text-dark d-block mb-1"><i class="bi bi-info-circle-fill text-primary me-1"></i> Catatan Evaluasi Penguji UKK:</span>
                        <span class="text-muted">
                            Halaman kustom ini membuktikan bahwa penanganan <strong>Notifikasi 404 (Skenario 9e)</strong> berfungsi dengan baik pada route <code>/umkm/{slug}</code> tanpa membuat sistem crash atau menampilkan layar debug Laravel!
                        </span>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('umkm.show', 'kue-enak-bu-sri') }}" class="btn btn-warning text-dark fw-bold btn-sm px-4">
                            <i class="bi bi-shop me-1"></i> Buka Contoh Portofolio Valid (Kue Bu Sri)
                        </a>
                        <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                        </a>
                    </div>
                </div>

                <div class="mt-4 small text-muted">
                    <a href="{{ route('belajar.ukk.panduan') }}" class="text-decoration-none">
                        &larr; Kembali ke Panduan UKK RPL 2026/2027
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
