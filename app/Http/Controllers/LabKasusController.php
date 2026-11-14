<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class LabKasusController extends Controller
{
    /**
     * Dashboard Lab Studi Kasus Inventaris
     */
    public function index(Request $request)
    {
        $mode = $request->query('mode', 'db'); // 'db' atau 'dummy'
        
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
            $items = Item::latest()->get();
        }

        return view('lab_kasus.index', compact('items', 'mode'));
    }

    /**
     * Halaman Tambah Barang (Ada tantangan CSRF & Validasi)
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
            // Langsung coba simpan tanpa validasi (akan di-handle di view untuk edukasi)
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
     * Hapus Barang
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $nama = $item->nama_barang;
        $item->delete();

        return redirect()->route('lab-kasus.index')
            ->with('success', "🗑️ Barang \"{$nama}\" berhasil dihapus dari inventaris!");
    }

    /**
     * Reset database ke kondisi awal (4 barang default)
     */
    public function resetData()
    {
        Item::truncate();

        Item::create(['kode_barang' => 'LAB-001', 'nama_barang' => 'PC All-in-One Core i5 16GB', 'kategori' => 'Komputer', 'stok' => 24, 'kondisi' => 'Baik']);
        Item::create(['kode_barang' => 'LAB-002', 'nama_barang' => 'Router MikroTik RB750Gr3', 'kategori' => 'Jaringan', 'stok' => 12, 'kondisi' => 'Baik']);
        Item::create(['kode_barang' => 'LAB-003', 'nama_barang' => 'Crimping Tool RJ-45 Cat6 Pro', 'kategori' => 'Peralatan', 'stok' => 8, 'kondisi' => 'Rusak Ringan']);
        Item::create(['kode_barang' => 'LAB-004', 'nama_barang' => 'Switch D-Link 24 Port Gigabit', 'kategori' => 'Jaringan', 'stok' => 3, 'kondisi' => 'Rusak Berat']);

        return redirect()->route('lab-kasus.index')
            ->with('info', '🔄 Database inventaris telah di-reset ke data default awal!');
    }

    /**
     * Halaman Kolaborasi Tim & Simulator Merge Conflict
     */
    public function kelompok()
    {
        return view('lab_kasus.kelompok');
    }
}
