<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan riwayat & daftar peminjaman barang lab
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $peminjamans = Peminjaman::with('item')
            ->when($status, function ($q, $st) {
                $q->where('status', $st);
            })
            ->latest()
            ->get();

        $stats = [
            'total' => Peminjaman::count(),
            'dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'Dikembalikan')->count(),
        ];

        return view('lab_kasus.peminjaman.index', compact('peminjamans', 'stats', 'status'));
    }

    /**
     * Form peminjaman alat lab baru
     */
    public function create()
    {
        // Hanya barang dengan stok > 0 dan kondisi Baik/Rusak Ringan yang bisa dipinjam
        $items = Item::where('stok', '>', 0)
            ->where('kondisi', '!=', 'Rusak Berat')
            ->orderBy('nama_barang')
            ->get();

        return view('lab_kasus.peminjaman.create', compact('items'));
    }

    /**
     * Simpan peminjaman & otomatis potong stok barang
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'nama_peminjam' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'catatan' => 'nullable|string|max:255',
        ], [
            'item_id.required' => 'Pilih barang yang ingin dipinjam!',
            'item_id.exists' => 'Barang tidak ditemukan dalam database!',
            'nama_peminjam.required' => 'Nama siswa peminjam wajib diisi!',
            'kelas.required' => 'Kelas siswa wajib diisi!',
            'jumlah.min' => 'Jumlah pinjam minimal 1 unit!',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib ditentukan!',
        ]);

        $item = Item::findOrFail($request->item_id);

        // Validasi ketersediaan stok
        if ($item->stok < $request->jumlah) {
            return redirect()->back()
                ->withInput()
                ->with('error', "❌ Stok tidak mencukupi! Sisa stok untuk '{$item->nama_barang}' hanya {$item->stok} unit.");
        }

        // 1. Buat catatan transaksi peminjaman
        $peminjaman = Peminjaman::create([
            'item_id' => $item->id,
            'nama_peminjam' => $request->nama_peminjam,
            'kelas' => $request->kelas,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'Dipinjam',
            'catatan' => $request->catatan,
        ]);

        // 2. Kurangi stok barang di tabel items (Logika Bisnis Nyata)
        $item->decrement('stok', $request->jumlah);

        return redirect()->route('lab-kasus.peminjaman.index')
            ->with('success', "✅ Peminjaman berhasil dicatat! {$request->nama_peminjam} ({$request->kelas}) meminjam {$request->jumlah} unit '{$item->nama_barang}'. Sisa stok berkurang menjadi {$item->stok}.");
    }

    /**
     * Proses pengembalian barang & pulihkan stok barang
     */
    public function kembali($id)
    {
        $peminjaman = Peminjaman::with('item')->findOrFail($id);

        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->route('lab-kasus.peminjaman.index')
                ->with('info', "ℹ️ Peminjaman ini sudah tercatat dikembalikan sebelumnya.");
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->format('Y-m-d'),
        ]);

        // Pulihkan stok barang kembali
        if ($peminjaman->item) {
            $peminjaman->item->increment('stok', $peminjaman->jumlah);
        }

        return redirect()->route('lab-kasus.peminjaman.index')
            ->with('success', "🎉 Barang '{$peminjaman->item->nama_barang}' telah dikembalikan oleh {$peminjaman->nama_peminjam}! Stok bertambah {$peminjaman->jumlah} unit.");
    }
}
