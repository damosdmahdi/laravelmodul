@extends('layouts.belajar')

@section('title', 'Log Aktivitas Perubahan Data Portofolio - Admin UKK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('ukk.admin.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Admin
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-clock-history text-secondary me-2"></i>Log Aktivitas Perubahan Data Portofolio
            </h3>
            <span class="text-muted small">Mencatat setiap tindakan admin (Login, Publish, Draft, Update, Delete) sebagai audit trail sistem</span>
        </div>
    </div>

    <!-- TABEL LOG AUDIT TRAIL -->
    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark mb-0">Riwayat Seluruh Perubahan</h6>
            <span class="badge bg-primary">{{ $logs->total() }} Catatan Aktivitas</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 170px;">Waktu Kejadian</th>
                            <th style="width: 140px;">Admin Pelaku</th>
                            <th style="width: 120px;">Tindakan</th>
                            <th>Deskripsi Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="text-muted font-monospace">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-person me-1"></i>{{ $log->admin_name }}</span>
                                </td>
                                <td>
                                    @if ($log->action === 'PUBLISH')
                                        <span class="badge bg-success">PUBLISH</span>
                                    @elseif ($log->action === 'CREATE')
                                        <span class="badge bg-primary">CREATE</span>
                                    @elseif ($log->action === 'UPDATE')
                                        <span class="badge bg-warning text-dark">UPDATE</span>
                                    @elseif ($log->action === 'DELETE')
                                        <span class="badge bg-danger">DELETE</span>
                                    @elseif ($log->action === 'DRAFT')
                                        <span class="badge bg-secondary">DRAFT</span>
                                    @else
                                        <span class="badge bg-dark">{{ $log->action }}</span>
                                    @endif
                                </td>
                                <td class="text-dark">{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada catatan aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            {{ $logs->links() }}
        </div>
    </div>

</div>
@endsection
