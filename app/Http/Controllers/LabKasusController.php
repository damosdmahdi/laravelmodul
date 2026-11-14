<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LabKasusController extends Controller
{
    /**
     * Dashboard Lab Studi Kasus Inventaris (dengan Pencarian & Filter Kategori/Kondisi)
     */
    public function index(Request $request)
    {
        $mode = $request->query('mode', 'db'); // 'db' atau 'dummy'
        $q = $request->query('q');
        $kategori = $request->query('kategori');
        $kondisi = $request->query('kondisi');

        if ($mode === 'dummy') {
            // Data statis contoh sebelum siswa menghubungkan ke DB
            $items = collect([
                (object)[
                    'id' => 1,
                    'kode_barang' => 'LAB-001',
                    'nama_barang' => 'PC All-in-One Core i5 (Contoh Dummy)',
                    'kategori' => 'Komputer',
                    'stok' => 24,
                    'kondisi' => 'Baik',
                ],
                (object)[
                    'id' => 2,
                    'kode_barang' => 'LAB-002',
                    'nama_barang' => 'Router MikroTik RB750Gr3 (Contoh Dummy)',
                    'kategori' => 'Jaringan',
                    'stok' => 12,
                    'kondisi' => 'Baik',
                ],
            ]);
        } else {
            // Query Eloquent dengan filter dinamis
            $items = Item::withCount(['peminjamans as sedang_dipinjam' => function ($query) {
                $query->where('status', 'Dipinjam');
            }])
            ->filter(['q' => $q, 'kategori' => $kategori, 'kondisi' => $kondisi])
            ->latest()
            ->get();
        }

        // Statistik ringkas untuk widget atas
        $stats = [
            'total_barang' => Item::count(),
            'total_stok' => (int) Item::sum('stok'),
            'total_rusak' => Item::where('kondisi', '!=', 'Baik')->count(),
            'total_dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
            'total_trash' => Item::onlyTrashed()->count(),
        ];

        return view('lab_kasus.index', compact('items', 'mode', 'stats', 'q', 'kategori', 'kondisi'));
    }

    /**
     * Halaman Detail Barang (Show Route) & Riwayat Peminjaman
     */
    public function show($id)
    {
        $item = Item::with(['peminjamans' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('lab_kasus.show', compact('item'));
    }

    /**
     * Halaman Tambah Barang
     */
    public function create()
    {
        return view('lab_kasus.create');
    }

    /**
     * Simpan Barang Baru
     */
    public function store(Request $request)
    {
        // Fitur simulasi: Jika siswa mematikan validasi untuk menguji form kosong
        if ($request->has('skip_validation') && $request->skip_validation == '1') {
            if (empty($request->kode_barang) || empty($request->nama_barang)) {
                return redirect()->back()
                    ->withInput()
                    ->with('warning', '⚠️ PERINGATAN EDUKASI: Data berhasil dikirim tanpa validasi! Di dunia nyata, ini bisa menyebabkan data kosong atau crash database. Selalu gunakan $request->validate()!');
            }
        } else {
            // Validasi standar yang benar
            $request->validate([
                'kode_barang' => 'required|string|max:50|unique:items,kode_barang',
                'nama_barang' => 'required|string|max:255',
                'kategori' => 'required|string',
                'stok' => 'required|numeric|min:0',
                'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            ], [
                'kode_barang.required' => 'Kode barang wajib diisi!',
                'kode_barang.unique' => 'Kode barang ini sudah ada di inventaris lab.',
                'nama_barang.required' => 'Nama barang tidak boleh kosong!',
                'kategori.required' => 'Silakan pilih kategori barang.',
                'stok.required' => 'Jumlah stok harus diisi berupa angka.',
                'kondisi.required' => 'Pilih kondisi barang saat ini.',
            ]);
        }

        Item::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'stok' => $request->stok ?? 0,
            'kondisi' => $request->kondisi ?? 'Baik',
        ]);

        return redirect()->route('lab-kasus.index')
            ->with('success', "🎉 Berhasil! Barang {$request->nama_barang} ({$request->kode_barang}) telah tersimpan ke database SQLite!");
    }

    /**
     * Halaman Edit Barang
     */
    public function edit($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return redirect()->route('lab-kasus.index')
                ->with('error', "❌ Data barang ID #{$id} tidak ditemukan (simulasi penanganan findOrFail)!");
        }

        return view('lab_kasus.edit', compact('item'));
    }

    /**
     * Update Barang
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:items,kode_barang,' . $item->id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $item->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('lab-kasus.index')
            ->with('success', "✨ Data barang {$item->kode_barang} berhasil diperbarui!");
    }

    /**
     * Hapus Barang (Menggunakan Soft Delete demi Keamanan Data)
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $nama = $item->nama_barang;
        $item->delete(); // Soft delete (mengisi kolom deleted_at)

        return redirect()->route('lab-kasus.index')
            ->with('success', "🗑️ Barang \"{$nama}\" dipindahkan ke Tong Sampah (Soft Delete)! Data masih bisa dipulihkan kembali.");
    }

    /**
     * Halaman Tong Sampah (Recycle Bin - Soft Deleted Items)
     */
    public function trash()
    {
        $trashItems = Item::onlyTrashed()->latest('deleted_at')->get();
        return view('lab_kasus.trash', compact('trashItems'));
    }

    /**
     * Pulihkan Barang dari Tong Sampah (Restore)
     */
    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $nama = $item->nama_barang;
        $item->restore();

        return redirect()->route('lab-kasus.trash')
            ->with('success', "♻️ Barang \"{$nama}\" berhasil dipulihkan kembali ke daftar inventaris aktif!");
    }

    /**
     * Hapus Permanen dari Database (Force Delete)
     */
    public function forceDelete($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $nama = $item->nama_barang;
        $item->forceDelete();

        return redirect()->route('lab-kasus.trash')
            ->with('warning', "💥 Barang \"{$nama}\" telah DIHAPUS PERMANEN dari database dan tidak dapat dipulihkan!");
    }

    /**
     * Cetak Laporan Resmi Rekapitulasi Inventaris Lab (Print Ready)
     */
    public function laporan()
    {
        $items = Item::withCount(['peminjamans as sedang_dipinjam' => function ($q) {
            $q->where('status', 'Dipinjam');
        }])->orderBy('kategori')->orderBy('nama_barang')->get();

        $stats = [
            'total_barang' => Item::count(),
            'total_stok' => (int) Item::sum('stok'),
            'kondisi_baik' => Item::where('kondisi', 'Baik')->count(),
            'kondisi_rusak' => Item::where('kondisi', '!=', 'Baik')->count(),
            'total_dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
        ];

        return view('lab_kasus.laporan', compact('items', 'stats'));
    }

    /**
     * Halaman Dokumentasi RESTful API & Live Playground Tester
     */
    public function apiDocs()
    {
        return view('lab_kasus.api_docs');
    }

    /**
     * Reset database ke kondisi awal (4 barang default)
     */
    public function resetData()
    {
        // Force delete atau truncate
        Item::withTrashed()->forceDelete();

        Item::create(['kode_barang' => 'LAB-001', 'nama_barang' => 'PC All-in-One Core i5 16GB', 'kategori' => 'Komputer', 'stok' => 24, 'kondisi' => 'Baik']);
        Item::create(['kode_barang' => 'LAB-002', 'nama_barang' => 'Router MikroTik RB750Gr3', 'kategori' => 'Jaringan', 'stok' => 12, 'kondisi' => 'Baik']);
        Item::create(['kode_barang' => 'LAB-003', 'nama_barang' => 'Crimping Tool RJ-45 Cat6 Pro', 'kategori' => 'Peralatan', 'stok' => 8, 'kondisi' => 'Rusak Ringan']);
        Item::create(['kode_barang' => 'LAB-004', 'nama_barang' => 'Switch D-Link 24 Port Gigabit', 'kategori' => 'Jaringan', 'stok' => 3, 'kondisi' => 'Rusak Berat']);

        return redirect()->route('lab-kasus.index')
            ->with('info', '🔄 Database inventaris telah di-reset ke 4 data awal!');
    }
}
