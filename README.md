# 🚀 Starter Repo: Fundamental Laravel untuk SMK (Kelas 10 & 11)

Repositori starter pembelajaran pemrograman web dengan Framework Laravel tingkat pemula untuk siswa SMK (Rekayasa Perangkat Lunak / Pengembangan Perangkat Lunak dan Gim).

- **Studi Kasus:** Sistem Inventaris Barang Lab Komputer
- **Target Akhir:** Siswa mampu membuat aplikasi CRUD satu tabel mandiri berbasis arsitektur MVC dan mempraktikkan alur kerja Git/GitHub secara profesional (Pull Request, Branching, dan pencegahan merge conflict).

---

## 📋 Struktur Silabus Pembelajaran (6 Modul)

| Modul | Topik Pembelajaran | Fokus Materi (Ramah Pemula) | Target Output Siswa |
| :--- | :--- | :--- | :--- |
| **Modul 1** | **Pengenalan & Setup** | Analogi bangun rumah (PHP Native = cetak bata sendiri vs Laravel = bata & rangka siap pasang), Composer, struktur folder, `php artisan serve`. | Proyek berjalan di lokal dan terhubung ke GitHub. |
| **Modul 2** | **Routing & Controller** | Alur request MVC (Browser &rarr; Route `web.php` &rarr; Controller &rarr; View), `php artisan make:controller`, passing data. | Siswa paham alur data request & response. |
| **Modul 3** | **Blade Templating** | Syntax Blade (`{{ $data }}`, `@foreach`, `@if`), konsep layouting (`@extends`, `@yield`, `@section`) agar navbar/footer tidak di-copy-paste. | Template statis berubah dinamis & rapi. |
| **Modul 4** | **Database & Migration** | Konfigurasi `.env`, konsep Migration sebagai version control skema tabel di Git, `php artisan migrate`. | Tabel terbentuk tanpa buat manual di phpMyAdmin. |
| **Modul 5** | **Eloquent ORM (Read & Create)** | Model (`php artisan make:model`), `Model::all()`, form input, proteksi `@csrf`, dan `Model::create()`. | Data form tersimpan ke DB & tampil di tabel. |
| **Modul 6** | **Penyelesaian CRUD & Validasi** | Ambil data spesifik (`findOrFail`), update (`PUT`), hapus (`DELETE`), dan validasi input (`$request->validate()`). | CRUD 1 tabel utuh selesai dengan validasi. |

---

## 🛠️ Panduan Menghidupkan Proyek (Bagi Mahasiswa / Siswa Setelah Clone)

> [!IMPORTANT]
> **Mengapa Tidak Bisa Langsung `php artisan serve`?**
> Sesuai standar industri dunia kerja, file `.env` (berisi password/kredensial) dan folder `vendor/` (berisi ratusan megabyte library) **sengaja tidak dimasukkan ke dalam Git** (`.gitignore`).
> Oleh karena itu, setiap kali kalian clone repositori Laravel, jalankan langkah wajib berikut:

### Opsi A: Cara Cepat (Rekomendasi)
Buka terminal di dalam folder proyek hasil clone, lalu jalankan:

```bash
# 1. Unduh library vendor Laravel
composer install

# 2. Jalankan setup otomatis (membuat .env, APP_KEY, dan database SQLite + Seeder)
composer run setup

# 3. Nyalakan server lokal
php artisan serve
```

---

### Opsi B: Langkah Manual Step-by-Step

```bash
# 1. Clone repositori ke komputer kalian
git clone <URL_REPOSITORI_GITHUB>
cd <nama-folder-repo>

# 2. Unduh dependensi Laravel (folder vendor)
composer install

# 3. Salin file konfigurasi .env
cp .env.example .env          # Di Linux / macOS / Git Bash
copy .env.example .env        # Di Windows Command Prompt (CMD)

# 4. Generate Kunci Enkripsi Aplikasi (APP_KEY)
php artisan key:generate

# 5. Jalankan migrasi dan isi data awal inventaris
php artisan migrate --seed

# 6. Nyalakan server lokal
php artisan serve
```

Buka peramban di komputer kalian: **`http://127.0.0.1:8000`** 🎉

---

## 🌟 Fitur Utama di Dalam Repositori Ini:
1. **Pilar 1 - Portal Belajar & Simulator Interaktif:** Modul 1 s/d 6 mencakup analogi bangun rumah, simulator pohon folder VS Code mekar, master layout synchronizer, timeline migrasi, dan simulator hacker SQL Injection.
2. **Laboratorium Keamanan Web (Security Hub):** Uji coba interaktif 6 jenis proteksi keamanan siber industri (RBAC 403, Rate Limiter 429, Password Hash Bcrypt vs MD5, XSS Sanitizer, Mass Assignment, dan Soft Deletes).
3. **Pilar 2 - Autochecker Tugas Mandiri Siswa:** Sistem inspeksi file kode otomatis di folder `tugas-siswa/` yang memberikan skor 0–100 dan rapor otomatis.
4. **Pilar 3 - Sistem Inventaris Lab Lengkap:**
   - CRUD Barang Inventaris & Pencarian Cepat
   - Transaksi Peminjaman Alat Lab (Stok terpotong otomatis)
   - Tong Sampah (Recycle Bin - Soft Deletes & Restore)
   - Cetak Berita Acara Rekapitulasi Resmi (Format Print / PDF)
   - Dokumentasi & Playground RESTful API JSON (`/api/v1/items`)
