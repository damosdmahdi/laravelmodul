<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder awal inventaris lab untuk praktikum siswa
        $item1 = Item::firstOrCreate(
            ['kode_barang' => 'LAB-001'],
            [
                'nama_barang' => 'PC All-in-One Core i5 16GB',
                'kategori' => 'Komputer',
                'stok' => 24,
                'kondisi' => 'Baik',
            ]
        );

        $item2 = Item::firstOrCreate(
            ['kode_barang' => 'LAB-002'],
            [
                'nama_barang' => 'Router MikroTik RB750Gr3',
                'kategori' => 'Jaringan',
                'stok' => 12,
                'kondisi' => 'Baik',
            ]
        );

        $item3 = Item::firstOrCreate(
            ['kode_barang' => 'LAB-003'],
            [
                'nama_barang' => 'Crimping Tool RJ-45 Cat6 Pro',
                'kategori' => 'Peralatan',
                'stok' => 8,
                'kondisi' => 'Rusak Ringan',
            ]
        );

        $item4 = Item::firstOrCreate(
            ['kode_barang' => 'LAB-004'],
            [
                'nama_barang' => 'Switch D-Link 24 Port Gigabit',
                'kategori' => 'Jaringan',
                'stok' => 3,
                'kondisi' => 'Rusak Berat',
            ]
        );

        // Seeder transaksi peminjaman barang lab
        if (Peminjaman::count() === 0) {
            Peminjaman::create([
                'item_id' => $item2->id,
                'nama_peminjam' => 'Budi Santoso',
                'kelas' => '11 RPL 1',
                'jumlah' => 2,
                'tanggal_pinjam' => now()->subDays(2)->format('Y-m-d'),
                'status' => 'Dipinjam',
                'catatan' => 'Praktik Konfigurasi Routing Dinamik Lab Jaringan 2',
            ]);

            Peminjaman::create([
                'item_id' => $item3->id,
                'nama_peminjam' => 'Siti Aisyah',
                'kelas' => '10 PPLG 2',
                'jumlah' => 1,
                'tanggal_pinjam' => now()->subDays(5)->format('Y-m-d'),
                'tanggal_kembali' => now()->subDays(1)->format('Y-m-d'),
                'status' => 'Dikembalikan',
                'catatan' => 'Ujian Praktik Pengkabelan UTP Straight & Cross',
            ]);
        }
    }
}
