@extends('layouts.belajar')

@section('title', 'Login Administrator - Platform Web Portofolio UMKM UKK')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <!-- KARTU LOGIN ADMIN -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="d-inline-flex p-3 bg-primary bg-opacity-25 rounded-circle mb-2">
                        <i class="bi bi-shield-lock-fill fs-2 text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Login Admin UMKM</h4>
                    <span class="text-white text-opacity-75 small">Satu Pintu Akses Pengelolaan Portofolio UKK RPL</span>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show small" role="alert">
                            <i class="bi bi-info-circle-fill me-1"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('ukk.admin.login.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Username / Email Admin</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-fill text-muted"></i></span>
                                <input type="text" name="username" id="loginUsername" class="form-control" placeholder="admin" value="{{ old('username', 'admin') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key-fill text-muted"></i></span>
                                <input type="password" name="password" id="loginPassword" class="form-control" placeholder="admin123" value="admin123" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm mb-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard Admin
                        </button>

                        <div class="p-3 bg-light rounded-3 border small">
                            <span class="d-block fw-bold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i> Akun Demo untuk Penguji UKK:</span>
                            <div class="d-flex justify-content-between text-muted">
                                <span>Username: <strong>admin</strong></span>
                                <span>Password: <strong>admin123</strong></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3 small text-muted">
                <a href="{{ route('belajar.ukk.panduan') }}" class="text-decoration-none">
                    &larr; Kembali ke Panduan UKK
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
