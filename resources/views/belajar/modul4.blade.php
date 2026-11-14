@extends('layouts.belajar')

@section('title', 'Modul 4: Database & Migration - Belajar Laravel SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <h3 class="fw-bold mb-0 text-dark">Modul 4: Database & Migrations (Version Control Skema Tabel)</h3>
            <p class="text-muted small mb-0">Rancang tabel database melalui kode tanpa perlu klik manual di phpMyAdmin</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('belajar.modul3') }}" class="btn btn-outline-secondary btn-sm">Modul 3</a>
            <a href="{{ route('belajar.modul5') }}" class="btn btn-primary btn-sm px-3">Lanjut ke Modul 5 <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>

    <!-- KONSEP MIGRATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fefce8 0%, #fef08a 100%);">
        <div class="card-body p-4 text-dark">
            <h5 class="fw-bold mb-2">
                <i class="bi bi-question-circle-fill text-warning me-2"></i>Kenapa Tidak Buat Tabel Manual Lewat phpMyAdmin?
            </h5>
            <p class="small mb-3">
                Bayangkan kamu bekerja dalam tim 5 orang. Jika kamu membuat tabel di phpMyAdmin komputermu sendiri, 4 temanmu tidak akan punya tabel tersebut kecuali kamu ekspor file <code>.sql</code> lalu kirim lewat flashdisk/WA. Jika kamu menambah 1 kolom baru esok hari, teman-temanmu akan bingung!
            </p>
            <div class="p-3 bg-white rounded-3 border small">
                <strong class="text-primary"><i class="bi bi-check-circle-fill me-1"></i>Solusi Laravel Migration:</strong>
                Skema tabel ditulis sebagai <strong>kode PHP (Blueprint)</strong>. Kode ini di-<em>commit</em> ke GitHub. Teman timmu cukup menarik kode (<code>git pull</code>) lalu mengetik satu perintah sakti:
                <br><code class="fw-bold text-dark fs-6 bg-light p-1 rounded mt-1 d-inline-block">php artisan migrate</code> &rarr; Maka seluruh tabel otomatis terbentuk di komputernya!
            </div>
        </div>
    </div>

    <!-- ARSITEK MIGRATION INTERAKTIF -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="bi bi-tools text-warning me-2"></i>Rancang Tabel Inventaris Barang (Migration Generator)</span>
            <span class="badge bg-warning text-dark">Tabel: items</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- FORM RANCANG KOLOM -->
                <div class="col-lg-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-table me-1"></i> Kolom Tabel Yang Dirancang:</h6>
                    
                    <div class="list-group mb-3 small" id="columnList">
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span><code>id()</code> (Primary Key Auto Increment)</span>
                            <span class="badge bg-secondary">Bawaan</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><code>string('kode_barang')->unique()</code></span>
                            <span class="badge bg-primary">Varchar Unique</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><code>string('nama_barang')</code></span>
                            <span class="badge bg-primary">Varchar</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><code>string('kategori')</code></span>
                            <span class="badge bg-primary">Varchar</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><code>integer('stok')</code></span>
                            <span class="badge bg-info text-dark">Integer</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><code>enum('kondisi', ['Baik', 'Rusak'])</code></span>
                            <span class="badge bg-warning text-dark">Enum</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span><code>timestamps()</code> (created_at & updated_at)</span>
                            <span class="badge bg-secondary">Bawaan</span>
                        </div>
                    </div>

                    <div class="alert alert-secondary small mb-0">
                        <i class="bi bi-info-circle-fill me-1"></i> File migrasi ini sudah otomatis dibuat dan di-migrate di database SQLite proyek kita pada file: <code>database/migrations/*_create_items_table.php</code>.
                    </div>
                </div>

                <!-- PREVIEW KODE PHP MIGRATION -->
                <div class="col-lg-6">
                    <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-code me-1"></i> File Migrasi Laravel yang Terbentuk:</h6>
                    <div class="code-box p-3 small">
                        <pre class="mb-0"><code><span class="token-keyword">&lt;?php</span>

<span class="token-keyword">use</span> Illuminate\Database\Migrations\Migration;
<span class="token-keyword">use</span> Illuminate\Database\Schema\Blueprint;
<span class="token-keyword">use</span> Illuminate\Support\Facades\Schema;

<span class="token-keyword">return new class extends</span> Migration {
    <span class="token-keyword">public function</span> <span class="token-class">up</span>(): <span class="token-keyword">void</span>
    {
        Schema::<span class="token-class">create</span>(<span class="token-string">'items'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-var">$table</span>) {
            <span class="token-var">$table</span>-><span class="token-class">id</span>();
            <span class="token-var">$table</span>-><span class="token-class">string</span>(<span class="token-string">'kode_barang'</span>)-><span class="token-class">unique</span>();
            <span class="token-var">$table</span>-><span class="token-class">string</span>(<span class="token-string">'nama_barang'</span>);
            <span class="token-var">$table</span>-><span class="token-class">string</span>(<span class="token-string">'kategori'</span>);
            <span class="token-var">$table</span>-><span class="token-class">integer</span>(<span class="token-string">'stok'</span>)-><span class="token-class">default</span>(0);
            <span class="token-var">$table</span>-><span class="token-class">enum</span>(<span class="token-string">'kondisi'</span>, [<span class="token-string">'Baik'</span>, <span class="token-string">'Rusak Ringan'</span>, <span class="token-string">'Rusak Berat'</span>]);
            <span class="token-var">$table</span>-><span class="token-class">timestamps</span>();
        });
    }
};</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DATA TABEL REAL SAAT INI DI DATABASE -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark"><i class="bi bi-hdd-network text-success me-2"></i>Status Nyata Database SQLite Saat Ini</span>
            <span class="badge bg-success">Tabel items ({{ $items->count() }} Data)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th>Waktu Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><span class="badge bg-secondary font-monospace">{{ $item->kode_barang }}</span></td>
                                <td class="fw-bold">{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->stok }} Unit</td>
                                <td>
                                    @if ($item->kondisi == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif ($item->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak Berat</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
