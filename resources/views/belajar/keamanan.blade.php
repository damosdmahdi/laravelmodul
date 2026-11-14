@extends('layouts.belajar')

@section('title', 'Laboratorium Keamanan Web Laravel (6 Tipe Keamanan) - SMK')

@section('content')
<div class="container py-4">

    <!-- BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('belajar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i> Dashboard Modul
            </a>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="bi bi-shield-lock-fill text-danger me-2"></i>Laboratorium Keamanan Web Laravel
            </h3>
            <span class="text-muted small">Mempelajari &amp; menguji 6 teknik keamanan standar industri yang wajib dikuasai programmer web SMK</span>
        </div>
        <div>
            <a href="{{ route('lab-kasus.index') }}" class="btn btn-warning text-dark fw-bold btn-sm px-3 shadow-sm">
                <i class="bi bi-tools me-1"></i> Kembali ke Kasus Lab
            </a>
        </div>
    </div>

    <!-- 6 KARTU INTERAKTIF KEAMANAN SIBER -->
    <div class="row g-4 mb-4">

        <!-- 1. ROLE-BASED ACCESS CONTROL (RBAC) & MIDDLEWARE 403 -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-danger p-2 me-3 fs-5"><i class="bi bi-person-lock"></i></span>
                    <div>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-1">Keamanan 1: RBAC Middleware</span>
                        <h5 class="fw-bold text-dark mb-0">Role &amp; Hak Akses (HTTP 403 Forbidden)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Tidak semua pengguna boleh mengakses seluruh menu. Siswa hanya boleh melihat &amp; meminjam, sedangkan aksi krusial (seperti menghapus seluruh database master) dicegat oleh <strong>Middleware Role Gate</strong>.
                </p>

                <!-- INTERAKTIF ROLE CHECK -->
                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Pilih Role Pengguna:</label>
                            <select id="simRoleSelect" class="form-select form-select-sm">
                                <option value="siswa" selected>Siswa (Tamu / Hak Terbatas)</option>
                                <option value="guru">Guru Lab / Admin (Hak Penuh)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Aksi yang Dicoba:</label>
                            <select id="simActionSelect" class="form-select form-select-sm">
                                <option value="view">Melihat Inventaris (Aman)</option>
                                <option value="delete_all" selected>Hapus Master Database (Krusial)</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm w-100 mt-3 fw-bold" onclick="testRoleSecurity()">
                        <i class="bi bi-shield-shaded me-1"></i> Uji Proteksi Middleware
                    </button>
                </div>

                <div id="roleResultBox" class="small p-3 rounded-3 bg-dark text-light font-monospace" style="min-height: 100px;">
                    <span class="text-secondary">// Pilih role lalu klik "Uji Proteksi Middleware"...</span>
                </div>
            </div>
        </div>

        <!-- 2. RATE LIMITING / THROTTLE (ANTI-BRUTE FORCE 429) -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-warning text-dark p-2 me-3 fs-5"><i class="bi bi-stopwatch-fill"></i></span>
                    <div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle mb-1">Keamanan 2: Rate Limiting</span>
                        <h5 class="fw-bold text-dark mb-0">Anti-DDoS &amp; Brute Force (HTTP 429)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Laravel melindungi rute login &amp; transaksi sensitif dengan sistem pembatas kecepatan (<em>Rate Limiter</em>). Batas wajar: <strong>maksimal 5 request per 60 detik</strong>.
                </p>

                <!-- INTERAKTIF SPAM RATE LIMIT -->
                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold">Sisa Kuota Request:</span>
                        <span class="badge bg-success font-monospace" id="rateLimitBadge">5 / 5 Tersisa</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-warning text-dark btn-sm flex-grow-1 fw-bold" id="btnSpamRequest" onclick="testRateLimitSecurity()">
                            <i class="bi bi-lightning-fill me-1"></i> Spam Request Cepat (Klik Berkali-kali!)
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="resetRateLimitSecurity()" title="Reset Kuota">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>

                <div id="rateLimitResultBox" class="small p-3 rounded-3 bg-dark text-light font-monospace" style="min-height: 100px;">
                    <span class="text-secondary">// Klik tombol kuning di atas lebih dari 5 kali berturut-turut untuk memicu Error 429 Too Many Requests...</span>
                </div>
            </div>
        </div>

        <!-- 3. PASSWORD HASHING (BCRYPT VS MD5 & RAINBOW TABLE) -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-success p-2 me-3 fs-5"><i class="bi bi-key-fill"></i></span>
                    <div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle mb-1">Keamanan 3: Kriptografi</span>
                        <h5 class="fw-bold text-dark mb-0">Password Hashing (Hash::make vs MD5)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Mengapa industri TI <strong>melarang keras menyimpan password dalam format Plaintext atau MD5</strong>? Karena MD5 tidak memiliki *salt* dan bisa dibongkar dalam 1 detik lewat situs Rainbow Table!
                </p>

                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <label class="form-label small fw-bold">Ketik Password untuk Dihash:</label>
                    <div class="input-group input-group-sm mb-2">
                        <input type="text" id="simPasswordInput" class="form-control" value="rahasia123" placeholder="Ketik kata sandi...">
                        <button class="btn btn-success" onclick="testHashSecurity()">
                            <i class="bi bi-cpu me-1"></i> Generate Hash
                        </button>
                    </div>
                </div>

                <div id="hashResultBox" class="small p-3 rounded-3 bg-dark text-light font-monospace" style="min-height: 140px;">
                    <span class="text-secondary">// Klik tombol "Generate Hash" untuk membandingkan output MD5 vs Bcrypt...</span>
                </div>
            </div>
        </div>

        <!-- 4. XSS (CROSS-SITE SCRIPTING) & BLADE ESCAPING -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-info text-white p-2 me-3 fs-5"><i class="bi bi-file-earmark-code"></i></span>
                    <div>
                        <span class="badge bg-info-subtle text-info border border-info-subtle mb-1">Keamanan 4: Sanitasi Output</span>
                        <h5 class="fw-bold text-dark mb-0">XSS Protection &amp; Blade Escaping</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Jika penyerang menyisipkan kode JavaScript berbahaya ke dalam kolom catatan barang, Blade secara otomatis mengubah karakter <code>&lt; &gt;</code> menjadi entitas HTML melalui <code>&#123;&#123; $var &#125;&#125;</code>.
                </p>

                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <label class="form-label small fw-bold">Payload Skrip Hacker (XSS):</label>
                    <div class="input-group input-group-sm mb-2">
                        <input type="text" id="simXssInput" class="form-control font-monospace" value="<script>alert('Akun Kamu Dibobol!')</script>">
                        <button class="btn btn-info text-white" onclick="testXssSecurity()">
                            <i class="bi bi-shield-check me-1"></i> Uji Filter XSS
                        </button>
                    </div>
                </div>

                <div id="xssResultBox" class="small p-3 rounded-3 bg-dark text-light font-monospace" style="min-height: 140px;">
                    <span class="text-secondary">// Klik tombol "Uji Filter XSS" untuk melihat perbedaan &#123;&#123; &#125;&#125; vs &#123;!! !!&#125;...</span>
                </div>
            </div>
        </div>

        <!-- 5. MASS ASSIGNMENT VULNERABILITY ($fillable VS $guarded) -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-primary p-2 me-3 fs-5"><i class="bi bi-database-lock"></i></span>
                    <div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-1">Keamanan 5: Model Eloquent</span>
                        <h5 class="fw-bold text-dark mb-0">Proteksi Mass Assignment ($fillable)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Tanpa properti <code>protected $fillable</code>, penyerang bisa menyusupkan kolom tersembunyi seperti <code>is_admin = 1</code> di dalam request POST form.
                </p>

                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <label class="form-label small fw-bold">Konfigurasi Model Eloquent:</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger btn-sm flex-grow-1" onclick="testMassAssignmentSecurity('guarded_vulnerable')">
                            Mode Celah ($guarded = [])
                        </button>
                        <button class="btn btn-success btn-sm flex-grow-1" onclick="testMassAssignmentSecurity('safe_fillable')">
                            Mode Aman ($fillable)
                        </button>
                    </div>
                </div>

                <div id="massAssignmentResultBox" class="small p-3 rounded-3 bg-dark text-light font-monospace" style="min-height: 140px;">
                    <span class="text-secondary">// Pilih mode di atas untuk melihat bagaimana Laravel menyaring kolom liar...</span>
                </div>
            </div>
        </div>

        <!-- 6. DATA INTEGRITY & SOFT DELETES -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-secondary p-2 me-3 fs-5"><i class="bi bi-recycle"></i></span>
                    <div>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle mb-1">Keamanan 6: Integritas Data</span>
                        <h5 class="fw-bold text-dark mb-0">Pencegahan Kehilangan Data (Soft Deletes)</h5>
                    </div>
                </div>
                <p class="text-secondary small mb-3">
                    Kesalahan manusia (*human error*) sering terjadi ketika staf lab tidak sengaja menekan tombol hapus. Dengan mengaktifkan <code>use SoftDeletes</code>, data diberi cap waktu <code>deleted_at</code> dan dipindahkan ke tong sampah tanpa merusak relasi database.
                </p>

                <div class="alert alert-light border small mb-3">
                    <ul class="mb-0 ps-3">
                        <li><strong>Hard Delete (Bahaya):</strong> <code>DELETE FROM items WHERE id = 1</code> &rarr; Data musnah selamanya.</li>
                        <li><strong>Soft Delete (Aman):</strong> <code>UPDATE items SET deleted_at = NOW()</code> &rarr; Data disembunyikan tapi bisa di-restore!</li>
                    </ul>
                </div>

                <a href="{{ route('lab-kasus.trash') }}" class="btn btn-outline-danger btn-sm w-100 fw-bold">
                    <i class="bi bi-trash3 me-1"></i> Buka Tong Sampah (Recycle Bin) Inventaris Lab &rarr;
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
@verbatim
<script>
    // 1. RBAC SECURITY
    async function testRoleSecurity() {
        const role = document.getElementById('simRoleSelect').value;
        const action = document.getElementById('simActionSelect').value;
        const box = document.getElementById('roleResultBox');

        box.innerHTML = '<span class="text-secondary">// Memeriksa izin hak akses ke server...</span>';

        try {
            const res = await fetch('/belajar/keamanan/role-check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ role, action })
            });

            const data = await res.json();

            if (res.status === 403) {
                box.innerHTML = `
<span class="text-danger fw-bold">[HTTP 403 FORBIDDEN] DITOLAK MIDDLEWARE!</span>
<span class="text-white">&rarr; ${data.message}</span>
<span class="text-warning">&rarr; Solusi: Hanya akun dengan role "guru" yang memiliki izin ke Controller ini.</span>
                `;
            } else {
                box.innerHTML = `
<span class="text-success fw-bold">[HTTP 200 OK] IZIN DITERIMA!</span>
<span class="text-white">&rarr; ${data.message}</span>
<span class="text-info">&rarr; Controller mengeksekusi method dengan aman.</span>
                `;
            }
        } catch (err) {
            box.textContent = 'Error: ' + err.message;
        }
    }

    // 2. RATE LIMIT SECURITY
    async function testRateLimitSecurity() {
        const box = document.getElementById('rateLimitResultBox');
        const badge = document.getElementById('rateLimitBadge');

        try {
            const res = await fetch('/belajar/keamanan/rate-limit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await res.json();

            if (res.status === 429) {
                badge.textContent = '0 / 5 (DIBLOKIR)';
                badge.className = 'badge bg-danger font-monospace';
                box.innerHTML = `
<span class="text-danger fw-bold">[HTTP 429 TOO MANY REQUESTS] ANTI-BRUTE FORCE AKTIF!</span>
<span class="text-white">&rarr; ${data.message}</span>
<span class="text-warning">&rarr; Header X-RateLimit-Reset: Coba lagi dalam ${data.retry_after} detik!</span>
                `;
            } else {
                badge.textContent = `${data.remaining} / ${data.max} Tersisa`;
                badge.className = data.remaining <= 1 ? 'badge bg-warning text-dark font-monospace' : 'badge bg-success font-monospace';
                box.innerHTML = `
<span class="text-success fw-bold">[HTTP 200 OK] Permintaan Diterima</span>
<span class="text-white">&rarr; Sisa kuota aman: ${data.remaining} request.</span>
                `;
            }
        } catch (err) {
            box.textContent = 'Error: ' + err.message;
        }
    }

    async function resetRateLimitSecurity() {
        const box = document.getElementById('rateLimitResultBox');
        const badge = document.getElementById('rateLimitBadge');

        await fetch('/belajar/keamanan/rate-limit-reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        badge.textContent = '5 / 5 Tersisa';
        badge.className = 'badge bg-success font-monospace';
        box.innerHTML = '<span class="text-success">// Rate limiter di-reset. Kuota kembali penuh 5 request!</span>';
    }

    // 3. HASH SECURITY
    async function testHashSecurity() {
        const password = document.getElementById('simPasswordInput').value || 'rahasia123';
        const box = document.getElementById('hashResultBox');

        box.innerHTML = '<span class="text-secondary">// Menghitung hash kriptografi...</span>';

        const res = await fetch('/belajar/keamanan/hash', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ password })
        });

        const data = await res.json();

        box.innerHTML = `
<span class="text-white fw-bold">Password Input: "${data.password_asli}"</span><br>
<span class="text-danger fw-bold">[MD5] ${data.md5.hash}</span>
<span class="text-secondary">&rarr; Kelemahan: ${data.md5.alasan}</span><br><br>
<span class="text-success fw-bold">[BCRYPT] ${data.bcrypt.hash}</span>
<span class="text-white">&rarr; Keunggulan: ${data.bcrypt.alasan}</span>
<span class="text-info">&rarr; Hash::check('${data.password_asli}'): true (Cocok)</span>
        `;
    }

    // 4. XSS SECURITY
    async function testXssSecurity() {
        const payload = document.getElementById('simXssInput').value;
        const box = document.getElementById('xssResultBox');

        const res = await fetch('/belajar/keamanan/xss', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ payload })
        });

        const data = await res.json();

        box.innerHTML = `
<span class="text-success fw-bold">1. Sintaks Blade Aman: {{ $input }}</span>
<span class="text-white">&rarr; Output HTML: ${data.blade_safe.output}</span>
<span class="text-secondary">&rarr; ${data.blade_safe.efek}</span><br><br>
<span class="text-danger fw-bold">2. Sintaks Unescaped Berbahaya: {!! $input !!}</span>
<span class="text-danger">&rarr; ${data.raw_danger.efek}</span>
        `;
    }

    // 5. MASS ASSIGNMENT SECURITY
    async function testMassAssignmentSecurity(mode) {
        const box = document.getElementById('massAssignmentResultBox');

        const res = await fetch('/belajar/keamanan/mass-assignment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ mode })
        });

        const data = await res.json();

        if (mode === 'safe_fillable') {
            box.innerHTML = `
<span class="text-success fw-bold">[AMAN] ${data.title}</span>
<span class="text-white">&rarr; Kolom Diterima: ${JSON.stringify(data.saved)}</span>
<span class="text-success">&rarr; Kolom Liar Dibuang: ${JSON.stringify(data.injected_ignored)}</span>
<span class="text-secondary">&rarr; ${data.explanation}</span>
            `;
        } else {
            box.innerHTML = `
<span class="text-danger fw-bold">[BAHAYA] ${data.title}</span>
<span class="text-danger">&rarr; Kolom Ilegal Ikut Tersimpan ke DB: ${JSON.stringify(data.injected_saved)}</span>
<span class="text-white">&rarr; ${data.explanation}</span>
            `;
        }
    }
</script>
@endverbatim
@endpush
