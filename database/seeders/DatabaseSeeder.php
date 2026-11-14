<?php

namespace Database\Seeders;

use App\Models\Item;
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
        Item::firstOrCreate(
            ['kode_barang' => 'LAB-001'],
            [
                'nama_barang' => 'PC All-in-One Core i5 16GB',
                'kategori' => 'Komputer',
                'stok' => 24,
                'kondisi' => 'Baik',
            ]
        );

        Item::firstOrCreate(
            ['kode_barang' => 'LAB-002'],
            [
                'nama_barang' => 'Router MikroTik RB750Gr3',
                'kategori' => 'Jaringan',
                'stok' => 12,
                'kondisi' => 'Baik',
            ]
        );

        Item::firstOrCreate(
            ['kode_barang' => 'LAB-003'],
            [
                'nama_barang' => 'Crimping Tool RJ-45 Cat6 Pro',
                'kategori' => 'Peralatan',
                'stok' => 8,
                'kondisi' => 'Rusak Ringan',
            ]
        );

        Item::firstOrCreate(
            ['kode_barang' => 'LAB-004'],
            [
                'nama_barang' => 'Switch D-Link 24 Port Gigabit',
                'kategori' => 'Jaringan',
                'stok' => 3,
                'kondisi' => 'Rusak Berat',
            ]
        );
    }
}
