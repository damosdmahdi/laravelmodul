<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Portfolio;
use App\Models\PortfolioProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UkkController extends Controller
{
    // ==========================================
    // 1. PANDUAN MATERI & SIMULATOR UKK KELAS 12
    // ==========================================

    /**
     * Dashboard Panduan Utama UKK RPL 2026/2027
     */
    public function panduan()
    {
        $portfolios = Portfolio::with('products')->latest()->get();
        $logs = ActivityLog::latest('created_at')->take(5)->get();

        $stats = [
            'total_umkm' => Portfolio::count(),
            'aktif' => Portfolio::where('status', 'published')->count(),
            'draft' => Portfolio::where('status', 'draft')->count(),
            'total_logs' => ActivityLog::count(),
        ];

        return view('belajar.ukk.panduan', compact('portfolios', 'logs', 'stats'));
    }

    /**
     * Halaman Uji Kompetensi Interaktif (5 Skenario Uji Wajib UKK)
     */
    public function ujiKompetensi()
    {
        return view('belajar.ukk.uji_kompetensi');
    }

    /**
     * API Pemeriksa Ketersediaan Slug (Real-time AJAX Validator)
     * Sesuai syarat fitur: "Validasi ketersediaan slug/URL sebelum simpan"
     */
    public function checkSlug(Request $request): JsonResponse
    {
        $slug = Str::slug($request->query('slug', ''));
        $currentId = $request->query('current_id');

        if (empty($slug)) {
            return response()->json([
                'available' => false,
                'slug' => '',
                'message' => 'Slug tidak boleh kosong!',
                'status' => 'empty'
            ], 200);
        }

        // Cek apakah slug sudah ada di database
        $query = Portfolio::where('slug', $slug);
        if ($currentId) {
            $query->where('id', '!=', $currentId);
        }

        $exists = $query->exists();

        if ($exists) {
            return response()->json([
                'available' => false,
                'slug' => $slug,
                'message' => "❌ URL slug '{$slug}' SUDAH DIPAKAI oleh UMKM lain. Silakan buat variasi unik!",
                'status' => 'duplicate',
                'url_preview' => url("/umkm/{$slug}")
            ], 200);
        }

        return response()->json([
            'available' => true,
            'slug' => $slug,
            'message' => "✅ URL slug '{$slug}' TERSEDIA dan valid untuk diterbitkan!",
            'status' => 'available',
            'url_preview' => url("/umkm/{$slug}")
        ], 200);
    }

    // ==========================================
    // 2. DASHBOARD ADMIN UKK (SESUAI LAMPIRAN PAGE 5)
    // ==========================================

    /**
     * Tampilan Login Admin UKK
     */
    public function adminLogin()
    {
        if (session()->has('ukk_admin_id')) {
            return redirect()->route('ukk.admin.dashboard');
        }
        return view('ukk.admin.login');
    }

    /**
     * Proses Login Admin UKK
     */
    public function adminLoginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'ukk_admin_id' => $admin->id,
                'ukk_admin_name' => $admin->name,
                'ukk_admin_username' => $admin->username,
            ]);

            ActivityLog::create([
                'admin_name' => $admin->name,
                'action' => 'LOGIN',
                'description' => "Admin {$admin->name} ({$admin->username}) berhasil login ke Dashboard UMKM.",
            ]);

            return redirect()->route('ukk.admin.dashboard')
                ->with('success', "Selamat datang kembali, {$admin->name}! Anda berhasil masuk.");
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Username atau password yang dimasukkan salah! (Gunakan demo: admin / admin123)');
    }

    /**
     * Logout Admin UKK
     */
    public function adminLogout()
    {
        $adminName = session('ukk_admin_name', 'Admin');

        ActivityLog::create([
            'admin_name' => $adminName,
            'action' => 'LOGOUT',
            'description' => "Admin {$adminName} keluar (logout) dari sistem.",
        ]);

        session()->forget(['ukk_admin_id', 'ukk_admin_name', 'ukk_admin_username']);

        return redirect()->route('ukk.admin.login')
            ->with('info', 'Anda telah berhasil logout dari sistem.');
    }

    /**
     * Dashboard Utama Admin (Sesuai Lampiran Halaman 5 Soal UKK)
     */
    public function adminDashboard(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');

        $portfolios = Portfolio::filter(['q' => $q, 'status' => $status])
            ->latest()
            ->get();

        $stats = [
            'total_umkm' => Portfolio::count(),
            'aktif' => Portfolio::where('status', 'published')->count(),
            'permintaan_baru' => Portfolio::where('status', 'draft')->count(),
        ];

        $recentLogs = ActivityLog::latest('created_at')->take(6)->get();

        return view('ukk.admin.dashboard', compact('portfolios', 'stats', 'recentLogs', 'q', 'status'));
    }

    /**
     * Simpan Portofolio UMKM Baru (Dari Form Dashboard)
     */
    public function storePortfolio(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'slug' => 'required|string|max:100|unique:portfolios,slug|regex:/^[a-z0-9-]+$/',
            'bio' => 'required|string',
            'whatsapp' => 'required|string|max:30',
            'tagline' => 'nullable|string|max:200',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama_usaha.required' => 'Nama usaha UMKM wajib diisi!',
            'slug.required' => 'Slug URL wajib diisi!',
            'slug.unique' => 'Slug URL ini sudah dipakai oleh UMKM lain. Harap pilih slug lain.',
            'slug.regex' => 'Slug hanya boleh memuat huruf kecil, angka, dan tanda hubung (-).',
            'bio.required' => 'Deskripsi bio portofolio usaha wajib diisi!',
            'whatsapp.required' => 'Nomor WhatsApp bisnis UMKM wajib diisi!',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->nama_usaha) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/umkm'), $filename);
            $logoPath = 'uploads/umkm/' . $filename;
        }

        $portfolio = Portfolio::create([
            'admin_id' => session('ukk_admin_id'),
            'nama_usaha' => $request->nama_usaha,
            'tagline' => $request->tagline ?? "Layanan & Produk Terbaik dari {$request->nama_usaha}",
            'slug' => Str::slug($request->slug),
            'bio' => $request->bio,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'logo' => $logoPath,
            'status' => $request->status,
        ]);

        // Jika ada input produk unggulan awal
        if ($request->filled('produk_nama')) {
            PortfolioProduct::create([
                'portfolio_id' => $portfolio->id,
                'nama_produk' => $request->produk_nama,
                'harga' => $request->produk_harga ?? 0,
                'deskripsi' => $request->produk_deskripsi ?? 'Produk unggulan terfavorit',
            ]);
        }

        // Catat Log Aktivitas
        $adminName = session('ukk_admin_name', 'Admin UKK');
        ActivityLog::create([
            'admin_name' => $adminName,
            'portfolio_id' => $portfolio->id,
            'action' => $portfolio->status === 'published' ? 'PUBLISH' : 'CREATE',
            'description' => "Admin {$adminName} mendaftarkan UMKM baru '{$portfolio->nama_usaha}' (Slug: {$portfolio->slug}, Status: {$portfolio->status}).",
        ]);

        return redirect()->route('ukk.admin.dashboard')
            ->with('success', "🎉 Berhasil! Website portofolio '{$portfolio->nama_usaha}' berhasil disimpan dengan link /umkm/{$portfolio->slug}!");
    }

    /**
     * Halaman Edit Portofolio UMKM
     */
    public function editPortfolio($id)
    {
        $portfolio = Portfolio::with('products')->findOrFail($id);
        return view('ukk.admin.edit', compact('portfolio'));
    }

    /**
     * Update Portofolio UMKM
     */
    public function updatePortfolio(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'slug' => 'required|string|max:100|unique:portfolios,slug,' . $portfolio->id . '|regex:/^[a-z0-9-]+$/',
            'bio' => 'required|string',
            'whatsapp' => 'required|string|max:30',
            'tagline' => 'nullable|string|max:200',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'nama_usaha' => $request->nama_usaha,
            'tagline' => $request->tagline,
            'slug' => Str::slug($request->slug),
            'bio' => $request->bio,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->nama_usaha) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/umkm'), $filename);
            $data['logo'] = 'uploads/umkm/' . $filename;
        }

        $portfolio->update($data);

        // Tambah produk jika ada
        if ($request->filled('new_product_nama')) {
            PortfolioProduct::create([
                'portfolio_id' => $portfolio->id,
                'nama_produk' => $request->new_product_nama,
                'harga' => $request->new_product_harga ?? 0,
                'deskripsi' => $request->new_product_deskripsi ?? 'Pilihan produk terbaik',
            ]);
        }

        $adminName = session('ukk_admin_name', 'Admin UKK');
        ActivityLog::create([
            'admin_name' => $adminName,
            'portfolio_id' => $portfolio->id,
            'action' => 'UPDATE',
            'description' => "Admin {$adminName} memperbarui informasi portofolio '{$portfolio->nama_usaha}'.",
        ]);

        return redirect()->route('ukk.admin.dashboard')
            ->with('success', "✨ Portofolio UMKM '{$portfolio->nama_usaha}' berhasil diperbarui!");
    }

    /**
     * Hapus Portofolio UMKM
     */
    public function destroyPortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $nama = $portfolio->nama_usaha;
        $portfolio->delete();

        $adminName = session('ukk_admin_name', 'Admin UKK');
        ActivityLog::create([
            'admin_name' => $adminName,
            'portfolio_id' => null,
            'action' => 'DELETE',
            'description' => "Admin {$adminName} menghapus portofolio '{$nama}'.",
        ]);

        return redirect()->route('ukk.admin.dashboard')
            ->with('success', "🗑️ Portofolio UMKM '{$nama}' berhasil dihapus!");
    }

    /**
     * Toggle Status Terbit (Publish vs Draft)
     */
    public function togglePublish($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $newStatus = $portfolio->status === 'published' ? 'draft' : 'published';
        $portfolio->update(['status' => $newStatus]);

        $adminName = session('ukk_admin_name', 'Admin UKK');
        ActivityLog::create([
            'admin_name' => $adminName,
            'portfolio_id' => $portfolio->id,
            'action' => strtoupper($newStatus),
            'description' => "Admin {$adminName} mengubah status '{$portfolio->nama_usaha}' menjadi: " . strtoupper($newStatus),
        ]);

        return redirect()->back()
            ->with('info', "Status website '{$portfolio->nama_usaha}' kini: " . strtoupper($newStatus));
    }

    /**
     * Halaman Riwayat Audit Log Perubahan
     */
    public function activityLogs()
    {
        $logs = ActivityLog::with('portfolio')->latest('created_at')->paginate(20);
        return view('ukk.admin.logs', compact('logs'));
    }

    // ==========================================
    // 3. FRONT-END PUBLIK WEBSITE PORTOFOLIO UMKM
    // ==========================================

    /**
     * Mengakses Halaman Portofolio Publik via URL /umkm/{slug}
     * Sesuai Lampiran Halaman 5: Landing Page "Kue Enak Bu Sri"
     */
    public function showPublicPortfolio($slug, Request $request)
    {
        $portfolio = Portfolio::with('products')
            ->where('slug', $slug)
            ->first();

        // Butir Soal 9e: Akses halaman publik dengan slug tidak ditemukan (404)
        if (!$portfolio) {
            return response()->view('ukk.public.404', [
                'requestedSlug' => $slug,
                'reason' => 'not_found'
            ], 404);
        }

        // Jika status masih DRAFT dan bukan mode preview admin
        if ($portfolio->status === 'draft' && !$request->has('preview')) {
            return response()->view('ukk.public.404', [
                'requestedSlug' => $slug,
                'portfolio' => $portfolio,
                'reason' => 'draft'
            ], 404);
        }

        // Increment visitor view count
        $portfolio->increment('views');

        return view('ukk.public.portfolio', compact('portfolio'));
    }
}
