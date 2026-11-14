<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class SecurityController extends Controller
{
    /**
     * Halaman Dashboard Laboratorium Keamanan Web Laravel
     */
    public function index()
    {
        return view('belajar.keamanan');
    }

    /**
     * Simulator 1: Role-Based Access Control (RBAC) & Middleware Gate
     */
    public function simulateRoleCheck(Request $request): JsonResponse
    {
        $role = $request->input('role', 'siswa'); // 'siswa' atau 'guru'
        $action = $request->input('action', 'view'); // 'view', 'edit', 'delete_all'

        if ($action === 'delete_all' && $role !== 'guru') {
            return response()->json([
                'status' => 'forbidden',
                'code' => 403,
                'title' => '403 Forbidden - Akses Ditolak!',
                'message' => "Middleware 'CheckRole:guru' memblokir permintaan! Akun dengan role '{$role}' tidak memiliki izin menghapus master database inventaris lab. Hanya role 'guru/admin' yang diizinkan.",
                'allowed' => false,
            ], 403);
        }

        return response()->json([
            'status' => 'authorized',
            'code' => 200,
            'title' => '200 OK - Izin Diterima',
            'message' => "Aksi '{$action}' diizinkan untuk role '{$role}'. Middleware meloloskan request ke Controller.",
            'allowed' => true,
        ], 200);
    }

    /**
     * Simulator 2: Rate Limiter (Throttle) / Anti-Brute Force (HTTP 429)
     */
    public function simulateRateLimit(Request $request): JsonResponse
    {
        $key = 'sim_rate_limit:' . ($request->ip() ?? '127.0.0.1');
        $maxAttempts = 5;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'status' => 'throttled',
                'code' => 429,
                'title' => '429 Too Many Requests (Anti-Brute Force Aktif!)',
                'message' => "Terlalu banyak percobaan dalam waktu singkat! Sistem Throttle Laravel memblokir permintaan Anda. Silakan coba lagi dalam {$seconds} detik.",
                'remaining' => 0,
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($key, $decaySeconds);
        $remaining = RateLimiter::remaining($key, $maxAttempts);

        return response()->json([
            'status' => 'allowed',
            'code' => 200,
            'title' => 'Request Diterima (Dalam Kuota Aman)',
            'message' => "Permintaan berhasil diproses. Sistem rate limiting mencatat akses Anda.",
            'remaining' => $remaining,
            'max' => $maxAttempts,
        ], 200);
    }

    /**
     * Reset rate limiter untuk simulator
     */
    public function resetRateLimit(Request $request): JsonResponse
    {
        $key = 'sim_rate_limit:' . ($request->ip() ?? '127.0.0.1');
        RateLimiter::clear($key);

        return response()->json([
            'status' => 'cleared',
            'message' => 'Rate limiter berhasil di-reset. Kuota kembali 5 request.',
        ]);
    }

    /**
     * Simulator 3: Password Hashing (Bcrypt vs MD5 vs Plaintext)
     */
    public function simulateHash(Request $request): JsonResponse
    {
        $password = $request->input('password', 'rahasia123');

        $plaintext = $password;
        $md5Hash = md5($password);
        $bcryptHash = Hash::make($password);

        return response()->json([
            'status' => 'success',
            'password_asli' => $plaintext,
            'md5' => [
                'hash' => $md5Hash,
                'keamanan' => 'Sangat Berbahaya (FATAL)',
                'alasan' => 'Dapat dibobol dalam 1 detik via Rainbow Table online tanpa salt. Industri TI sudah melarang keras penggunaan MD5!',
            ],
            'bcrypt' => [
                'hash' => $bcryptHash,
                'keamanan' => 'Standar Keamanan Tinggi (Laravel Default)',
                'alasan' => 'Menggunakan algoritma Blowfish dengan automatic salt unik dan work-factor cost (12 rounds). Menangkal serangan brute-force dan rainbow table!',
                'verifikasi_benar' => Hash::check($password, $bcryptHash),
                'verifikasi_salah' => Hash::check('password_salah', $bcryptHash),
            ],
        ]);
    }

    /**
     * Simulator 4: XSS (Cross-Site Scripting) & Blade Escaping
     */
    public function simulateXss(Request $request): JsonResponse
    {
        $rawInput = $request->input('payload', '<script>alert("Hacked by Hacker!")</script>');

        $bladeEscaped = e($rawInput); // setara {{ $input }}
        $stripped = strip_tags($rawInput);

        return response()->json([
            'status' => 'success',
            'input_asli' => $rawInput,
            'blade_safe' => [
                'syntax' => '{{ $input }} (Otomatis e() / htmlspecialchars)',
                'output' => $bladeEscaped,
                'efek' => 'Aman! Tag script diubah menjadi entitas HTML (&lt;script&gt;) sehingga hanya tampil sebagai teks biasa di browser tanpa dieksekusi.',
            ],
            'raw_danger' => [
                'syntax' => '{!! $input !!} (Unescaped Raw Output)',
                'output' => $rawInput,
                'efek' => 'BAHAYA! Browser akan mengeksekusi skrip JavaScript penyerang, memungkinkan pencurian Cookie, token sesi, atau pengalihan website palsu!',
            ],
            'stripped' => [
                'syntax' => 'strip_tags($input)',
                'output' => $stripped,
                'efek' => 'Semua tag HTML/JS dibersihkan total.',
            ],
        ]);
    }

    /**
     * Simulator 5: Mass Assignment Protection ($fillable vs $guarded)
     */
    public function simulateMassAssignment(Request $request): JsonResponse
    {
        $mode = $request->input('mode', 'guarded_vulnerable'); // 'safe_fillable' atau 'vulnerable'

        $incomingData = [
            'kode_barang' => 'LAB-888',
            'nama_barang' => 'Proyektor Epson Lab',
            'stok' => 5,
            'is_admin' => 1, // Kolom suntikan hacker
            'role' => 'superadmin', // Kolom suntikan hacker
        ];

        if ($mode === 'safe_fillable') {
            // Model dengan $fillable hanya menerima kolom yang terdaftar
            $fillable = ['kode_barang', 'nama_barang', 'stok'];
            $savedData = array_intersect_key($incomingData, array_flip($fillable));

            return response()->json([
                'status' => 'safe',
                'title' => 'Terlindungi dengan $fillable!',
                'incoming' => $incomingData,
                'saved' => $savedData,
                'injected_ignored' => ['is_admin' => 1, 'role' => 'superadmin'],
                'explanation' => 'Eloquent Model membuang kolom ilegal (is_admin, role) karena tidak terdaftar dalam properti protected $fillable. Database aman!',
            ]);
        } else {
            return response()->json([
                'status' => 'vulnerable',
                'title' => 'Celah Keamanan Terbuka (Mass Assignment Vulnerability)!',
                'incoming' => $incomingData,
                'saved' => $incomingData,
                'injected_saved' => ['is_admin' => 1, 'role' => 'superadmin'],
                'explanation' => 'Karena Model menggunakan $guarded = [] atau langsung Item::create($request->all()) tanpa validasi, kolom is_admin = 1 ikut tersimpan! Penyerang berhasil membobol hak akses admin!',
            ]);
        }
    }
}
