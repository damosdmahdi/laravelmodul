<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->nama_usaha }} &mdash; {{ $portfolio->tagline ?? 'Website Portofolio Resmi' }}</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #7c2d12; /* Warm bakery terracotta */
            --brand-accent: #f59e0b;
            --brand-bg: #fffbeb;
            --brand-card: #ffffff;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--brand-bg);
            color: #292524;
        }
        .font-heading {
            font-family: 'Playfair Display', serif;
        }
        .header-logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #f59e0b;
        }
        .product-card {
            background: #ffffff;
            border: 1px solid #fed7aa;
            border-radius: 18px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(124, 45, 18, 0.12);
            border-color: #f97316;
        }
        .btn-whatsapp {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 14px 32px;
            font-weight: 700;
            font-size: 1.05rem;
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
            transition: all 0.3s ease;
        }
        .btn-whatsapp:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(34, 197, 94, 0.4);
        }
        .floating-wa-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1050;
            animation: bounceSoft 2s infinite;
        }
        @keyframes bounceSoft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
    </style>
</head>
<body>

    <!-- TOP NOTICE FOR ADMIN PREVIEW IF DRAFT -->
    @if ($portfolio->status === 'draft')
        <div class="bg-warning text-dark py-2 px-3 text-center small fw-bold shadow-sm">
            <i class="bi bi-eye-fill me-1"></i> MODE PRATINJAU ADMIN: Website ini saat ini berstatus DRAFT (Belum diterbitkan ke pengunjung umum).
            <a href="{{ route('ukk.admin.dashboard') }}" class="text-dark text-decoration-underline ms-2">Kembali ke Dashboard</a>
        </div>
    @endif

    <!-- MAIN CONTAINER (SESUAI GAMBAR LAMPIRAN HALAMAN 5) -->
    <div class="container py-5" style="max-width: 900px;">

        <!-- 1. HEADER LOGO & NAMA USAHA -->
        <div class="text-center mb-4">
            <div class="header-logo-icon mb-2 shadow-sm">
                @if ($portfolio->logo)
                    <img src="{{ asset($portfolio->logo) }}" alt="{{ $portfolio->nama_usaha }}" style="max-height: 50px; max-width: 50px; object-fit: contain;">
                @else
                    <i class="bi bi-cup-hot-fill fs-1 text-warning" style="color: #d97706 !important;"></i>
                @endif
            </div>
            <h1 class="font-heading fw-bold mb-0 text-dark" style="color: #7c2d12;">
                {{ $portfolio->nama_usaha }}
            </h1>
        </div>

        <!-- 2. TAGLINE & BIO USAHA -->
        <div class="row align-items-center g-4 mb-5">
            <div class="col-md-6 text-center text-md-start">
                <h2 class="font-heading fw-bold mb-3" style="color: #9a3412; font-size: 1.85rem; line-height: 1.25;">
                    {{ $portfolio->tagline ?? 'Kelezatan Asli Buatan Rumah dengan Kualitas Terbaik' }}
                </h2>
                <p class="text-secondary mb-4 lh-base" style="font-size: 0.95rem;">
                    {{ $portfolio->bio }}
                </p>
                <div class="d-none d-md-block">
                    <a href="{{ $portfolio->whatsapp_link }}" target="_blank" class="btn btn-whatsapp d-inline-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp fs-5"></i>
                        <span>Pesan Sekarang lewat WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- FOTO BANNER PRODUK -->
            <div class="col-md-6">
                <div class="p-2 bg-white rounded-4 shadow-sm border border-warning-subtle">
                    <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&auto=format&fit=crop&q=80" alt="Produk UMKM" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 280px; object-fit: cover;">
                </div>
            </div>
        </div>

        <!-- 3. SECTION PRODUK UNGGULAN (GRID 4 ITEMS) -->
        <div class="mb-5">
            <div class="text-center text-md-start mb-4">
                <h3 class="font-heading fw-bold mb-1" style="color: #7c2d12;">Produk Unggulan</h3>
                <span class="text-muted small">Pilihan favorit para pelanggan setia kami</span>
            </div>

            <div class="row g-3">
                @forelse ($portfolio->products as $item)
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 p-3 text-center d-flex flex-column justify-content-between">
                            <div>
                                <div class="rounded-3 overflow-hidden mb-2 bg-light d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <i class="bi bi-box2-heart-fill fs-1 text-warning text-opacity-50"></i>
                                </div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $item->nama_produk }}</h6>
                                @if($item->deskripsi)
                                    <p class="text-muted small mb-2" style="font-size: 0.72rem; line-height: 1.3;">{{ Str::limit($item->deskripsi, 45) }}</p>
                                @endif
                            </div>
                            <div>
                                <span class="badge bg-warning-subtle text-dark border border-warning font-monospace px-2 py-1" style="font-size: 0.78rem;">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- FALLBACK PRODUK PERSIS SEPERTI GAMBAR LAMPIRAN HALAMAN 5 -->
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 p-3 text-center">
                            <div class="rounded-3 overflow-hidden mb-2 bg-light p-2" style="height: 110px;">
                                <i class="bi bi-cake2-fill fs-1 text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Lapis Legit</h6>
                            <span class="badge bg-warning text-dark font-monospace">Rp 180.000</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 p-3 text-center">
                            <div class="rounded-3 overflow-hidden mb-2 bg-light p-2" style="height: 110px;">
                                <i class="bi bi-cookie fs-1 text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Kastengel</h6>
                            <span class="badge bg-warning text-dark font-monospace">Rp 95.000</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 p-3 text-center">
                            <div class="rounded-3 overflow-hidden mb-2 bg-light p-2" style="height: 110px;">
                                <i class="bi bi-snow fs-1 text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Putri Salju</h6>
                            <span class="badge bg-warning text-dark font-monospace">Rp 85.000</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 p-3 text-center">
                            <div class="rounded-3 overflow-hidden mb-2 bg-light p-2" style="height: 110px;">
                                <i class="bi bi-square-fill fs-1 text-warning"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Brownies</h6>
                            <span class="badge bg-warning text-dark font-monospace">Rp 75.000</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 4. TOMBOL UTAMA PESAN SEKARANG LEWAT WHATSAPP (SESUAI LAMPIRAN HALAMAN 5) -->
        <div class="text-center my-4">
            <a href="{{ $portfolio->whatsapp_link }}" target="_blank" class="btn btn-whatsapp btn-lg px-5 py-3 shadow">
                <i class="bi bi-whatsapp fs-4 me-2"></i>
                <span>Pesan Sekarang lewat WhatsApp</span>
            </a>
            <div class="text-muted small mt-2">
                <i class="bi bi-clock me-1"></i> Respon Cepat &bull; WhatsApp Resmi: {{ $portfolio->whatsapp }}
            </div>
        </div>

        <!-- FOOTER HALAMAN UMKM -->
        <footer class="text-center pt-5 mt-4 border-top border-warning-subtle small text-muted">
            <p class="mb-1">
                <strong>{{ $portfolio->nama_usaha }}</strong> &bull; {{ $portfolio->alamat ?? 'Indonesia' }}
            </p>
            <span class="text-secondary" style="font-size: 0.75rem;">
                Platform Portofolio Instan UMKM &bull; Soal Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak 2026/2027
            </span>
        </footer>

    </div>

    <!-- TOMBOL WHATSAPP MENGAPUNG (FLOATING ACTION BUTTON) -->
    <a href="{{ $portfolio->whatsapp_link }}" target="_blank" class="btn btn-whatsapp floating-wa-btn shadow-lg d-flex align-items-center gap-2 px-3 py-2">
        <i class="bi bi-whatsapp fs-3"></i>
        <span class="d-none d-sm-inline font-weight-bold">Chat WhatsApp</span>
    </a>

</body>
</html>
