<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Item;
use App\Models\Peminjaman;
use App\Models\Portfolio;
use App\Models\PortfolioProduct;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. DATA DASAR INVENTARIS LAB (KELAS 10 & 11)
        // ==========================================
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

        // ==========================================
        // 2. DATA UKK KELAS 12: PLATFORM PORTOFOLIO UMKM
        // ==========================================
        $admin = Admin::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator UKK',
                'email' => 'admin@ukk.sch.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Sample Portfolio 1: Kue Enak Bu Sri (Published)
        $p1 = Portfolio::firstOrCreate(
            ['slug' => 'kue-enak-bu-sri'],
            [
                'admin_id' => $admin->id,
                'nama_usaha' => 'Kue Enak Bu Sri',
                'tagline' => 'Spesialis Kue Basah & Kering di Jakarta',
                'bio' => 'Kami menyediakan aneka kue lezat buatan rumah dengan bahan berkualitas terbaik. Sejak 2020. Terima pesanan untuk acara pernikahan, rapat kantor, dan syukuran!',
                'whatsapp' => '+62 812 3456 7890',
                'alamat' => 'Jl. Tebet Barat Raya No. 45, Jakarta Selatan',
                'status' => 'published',
                'views' => 156,
            ]
        );

        if ($p1->wasRecentlyCreated || PortfolioProduct::where('portfolio_id', $p1->id)->count() === 0) {
            PortfolioProduct::create([
                'portfolio_id' => $p1->id,
                'nama_produk' => 'Lapis Legit Original Wisman',
                'harga' => 180000,
                'deskripsi' => 'Resep turun-temurun dengan 100% mentega Wisman harum dan legit.',
            ]);
            PortfolioProduct::create([
                'portfolio_id' => $p1->id,
                'nama_produk' => 'Kastengel Keju Edam Gurih',
                'harga' => 95000,
                'deskripsi' => 'Renyah bertabur keju Edam tua impor asli Belanda.',
            ]);
            PortfolioProduct::create([
                'portfolio_id' => $p1->id,
                'nama_produk' => 'Putri Salju Pandan Lumer',
                'harga' => 85000,
                'deskripsi' => 'Sensasi dingin lumer di lidah dengan wangi sari pandan segar.',
            ]);
            PortfolioProduct::create([
                'portfolio_id' => $p1->id,
                'nama_produk' => 'Fudgy Brownies Shiny Crust',
                'harga' => 75000,
                'deskripsi' => 'Cokelat Belgia leleh pekat dengan tekstur fudgy nikmat.',
            ]);
        }

        // Sample Portfolio 2: Kopi Kita (Published)
        $p2 = Portfolio::firstOrCreate(
            ['slug' => 'kopi-kita'],
            [
                'admin_id' => $admin->id,
                'nama_usaha' => 'Kopi Kita',
                'tagline' => 'Biji Kopi Nusantara Pilihan Roasting Segar',
                'bio' => 'Menghadirkan kenikmatan seduhan kopi Arabika & Robusta asli dari petani lokal di Gayo, Toraja, dan Kintamani.',
                'whatsapp' => '+62 813 9988 7766',
                'alamat' => 'Jl. Riau No. 22, Bandung',
                'status' => 'published',
                'views' => 89,
            ]
        );

        if ($p2->wasRecentlyCreated || PortfolioProduct::where('portfolio_id', $p2->id)->count() === 0) {
            PortfolioProduct::create([
                'portfolio_id' => $p2->id,
                'nama_produk' => 'Kopi Susu Gula Aren 1 Liter',
                'harga' => 65000,
                'deskripsi' => 'Espresso ganda dipadu gula aren murni organik.',
            ]);
            PortfolioProduct::create([
                'portfolio_id' => $p2->id,
                'nama_produk' => 'Arabica Gayo Single Origin 250g',
                'harga' => 75000,
                'deskripsi' => 'Medium roast dengan aroma fruity floral alami.',
            ]);
        }

        // Sample Portfolio 3: Batik Indah (Published)
        $p3 = Portfolio::firstOrCreate(
            ['slug' => 'batik-indah'],
            [
                'admin_id' => $admin->id,
                'nama_usaha' => 'Batik Indah',
                'tagline' => 'Koleksi Batik Tulis & Cap Warisan Nusantara',
                'bio' => 'Pilihan busana batik modern elegan untuk keperluan kantor, pesta wisuda, dan seragam keluarga berkualitas primisima.',
                'whatsapp' => '+62 857 1122 3344',
                'alamat' => 'Kawasan Pasar Klewer Kios B-12, Solo',
                'status' => 'published',
                'views' => 112,
            ]
        );

        // Sample Portfolio 4: Kue Lezat (Draft)
        $p4 = Portfolio::firstOrCreate(
            ['slug' => 'kue-lezat'],
            [
                'admin_id' => $admin->id,
                'nama_usaha' => 'Kue Lezat',
                'tagline' => 'Aneka Roti & Bolu Fresh Tiap Pagi',
                'bio' => 'Roti manis empuk isi cokelat, keju, dan srikaya tanpa bahan pengawet.',
                'whatsapp' => '+62 821 5566 7788',
                'alamat' => 'Jl. Diponegoro No. 8, Semarang',
                'status' => 'draft',
                'views' => 14,
            ]
        );

        // Seed Activity Logs
        if (ActivityLog::count() === 0) {
            ActivityLog::create([
                'admin_name' => 'Administrator UKK',
                'portfolio_id' => $p1->id,
                'action' => 'PUBLISH',
                'description' => 'Menerbitkan website portofolio UMKM: Kue Enak Bu Sri (/umkm/kue-enak-bu-sri)',
                'created_at' => now()->subHours(5),
            ]);
            ActivityLog::create([
                'admin_name' => 'Administrator UKK',
                'portfolio_id' => $p2->id,
                'action' => 'CREATE',
                'description' => 'Menambahkan data portofolio baru: Kopi Kita (/umkm/kopi-kita)',
                'created_at' => now()->subHours(3),
            ]);
            ActivityLog::create([
                'admin_name' => 'Administrator UKK',
                'portfolio_id' => $p4->id,
                'action' => 'DRAFT',
                'description' => 'Menyimpan draf portofolio: Kue Lezat (Belum diterbitkan ke publik)',
                'created_at' => now()->subHour(),
            ]);
        }
    }
}
