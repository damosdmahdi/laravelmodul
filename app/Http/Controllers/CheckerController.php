<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CheckerController extends Controller
{
    /**
     * Path folder tugas siswa
     */
    protected function getStudentPath()
    {
        return base_path('tugas-siswa');
    }

    /**
     * Halaman Dashboard Evaluator Tugas Siswa
     */
    public function index()
    {
        $evaluation = $this->runEvaluation();
        return view('tugas_siswa.index', compact('evaluation'));
    }

    /**
     * API Endpoint untuk pengecekan cepat secara AJAX
     */
    public function checkAjax()
    {
        $evaluation = $this->runEvaluation();
        return response()->json($evaluation);
    }

    /**
     * Inisialisasi awal folder tugas-siswa jika siswa ingin template kosong
     */
    public function initWorkspace(Request $request)
    {
        $path = $this->getStudentPath();

        // Buat folder-folder dasar
        $directories = [
            $path,
            $path . '/app/Http/Controllers',
            $path . '/app/Models',
            $path . '/bootstrap',
            $path . '/config',
            $path . '/database/migrations',
            $path . '/resources/views/layouts',
            $path . '/resources/views/items',
            $path . '/routes',
        ];

        foreach ($directories as $dir) {
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        // 1. File artisan starter
        if (!File::exists($path . '/artisan')) {
            File::put($path . '/artisan', "#!/usr/bin/env php\n<?php\n// Artisan CLI Siswa\n");
        }

        // 2. File composer.json starter
        if (!File::exists($path . '/composer.json')) {
            File::put($path . '/composer.json', json_encode([
                'name' => 'smk/tugas-inventaris-siswa',
                'description' => 'Proyek Tugas Laravel Siswa SMK',
                'require' => [
                    'php' => '^8.2|^8.5',
                    'laravel/framework' => '^11.0|^12.0|^13.0',
                ]
            ], JSON_PRETTY_PRINT));
        }

        // 3. File .env starter
        if (!File::exists($path . '/.env')) {
            File::put($path . '/.env', "APP_NAME=TugasSiswaLaravel\nAPP_ENV=local\nAPP_KEY=base64:SMK" . base64_encode('KUNCI_RAHASIA_SISWA_' . rand(100, 999)) . "=\nAPP_DEBUG=true\nAPP_URL=http://localhost:8000\nDB_CONNECTION=sqlite\n");
        }

        // 4. File routes/web.php starter minimal
        if (!File::exists($path . '/routes/web.php')) {
            File::put($path . '/routes/web.php', "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', function () {\n    return 'Selamat Datang di Proyek Siswa';\n});\n");
        }

        return redirect()->route('tugas.index')
            ->with('success', '✨ Folder tugas-siswa/ berhasil diinisialisasi! Siswa dapat mulai membuat Controller, Model, Migration, dan Blade.');
    }

    /**
     * Mesin Evaluasi Kriteria 6 Modul
     */
    public function runEvaluation()
    {
        $path = $this->getStudentPath();
        $folderExists = File::isDirectory($path);

        $results = [
            'folder_exists' => $folderExists,
            'folder_path' => $path,
            'modules' => [],
            'total_score' => 0,
            'max_score' => 100,
            'percentage' => 0,
            'grade' => 'D',
            'summary_status' => 'Belum Dimulai',
        ];

        if (!$folderExists) {
            $results['summary_status'] = 'Folder tugas-siswa belum dibuat';
            return $results;
        }

        // ==========================================
        // MODUL 1: SETUP & ENVIRONMENT (Bobot: 15 Poin)
        // ==========================================
        $m1Score = 0;
        $m1Items = [
            [
                'title' => 'File artisan CLI',
                'passed' => File::exists($path . '/artisan'),
                'points' => 5,
                'hint' => 'File artisan harus ada di root folder tugas-siswa.',
            ],
            [
                'title' => 'File composer.json',
                'passed' => File::exists($path . '/composer.json'),
                'points' => 5,
                'hint' => 'File composer.json diperlukan untuk konfigurasi dependensi.',
            ],
            [
                'title' => 'File .env & APP_KEY terkonfigurasi',
                'passed' => File::exists($path . '/.env') && str_contains(File::get($path . '/.env'), 'APP_KEY=base64:'),
                'points' => 5,
                'hint' => 'Pastikan file .env ada dan memiliki APP_KEY=base64:...',
            ],
        ];
        foreach ($m1Items as $item) {
            if ($item['passed']) $m1Score += $item['points'];
        }
        $results['modules']['modul1'] = [
            'title' => 'Modul 1: Setup & Environment',
            'score' => $m1Score,
            'max' => 15,
            'items' => $m1Items,
            'status' => $m1Score >= 15 ? 'LULUS' : ($m1Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // MODUL 2: ROUTING & CONTROLLER (Bobot: 20 Poin)
        // ==========================================
        $m2Score = 0;
        $webRoutePath = $path . '/routes/web.php';
        $hasWebRoute = File::exists($webRoutePath);
        $webRouteContent = $hasWebRoute ? File::get($webRoutePath) : '';

        // Cek apakah ada route untuk barang / items / buku / inventaris
        $hasItemRoute = (bool) preg_match('/Route::(get|resource|post)\([\'"]\/(barang|items|buku|inventaris)/i', $webRouteContent);

        // Cek apakah ada Controller
        $controllerFiles = File::exists($path . '/app/Http/Controllers') 
            ? File::glob($path . '/app/Http/Controllers/*Controller.php') 
            : [];
        $hasItemController = false;
        $hasIndexMethod = false;

        foreach ($controllerFiles as $cFile) {
            $baseName = basename($cFile);
            if ($baseName !== 'Controller.php') {
                $hasItemController = true;
                $cContent = File::get($cFile);
                if (str_contains($cContent, 'function index')) {
                    $hasIndexMethod = true;
                }
            }
        }

        $m2Items = [
            [
                'title' => 'File routes/web.php terkonfigurasi',
                'passed' => $hasWebRoute,
                'points' => 5,
                'hint' => 'File routes/web.php harus tersedia.',
            ],
            [
                'title' => 'Rute /barang atau /items terdaftar',
                'passed' => $hasItemRoute,
                'points' => 5,
                'hint' => 'Tambahkan Route::get(\'/barang\', [ItemController::class, \'index\']); di routes/web.php.',
            ],
            [
                'title' => 'Controller siswa dibuat (ItemController / BarangController)',
                'passed' => $hasItemController,
                'points' => 5,
                'hint' => 'Jalankan php artisan make:controller ItemController di terminal.',
            ],
            [
                'title' => 'Method index() tersedia di Controller',
                'passed' => $hasIndexMethod,
                'points' => 5,
                'hint' => 'Buat method public function index() { ... } di dalam controller.',
            ],
        ];
        foreach ($m2Items as $item) {
            if ($item['passed']) $m2Score += $item['points'];
        }
        $results['modules']['modul2'] = [
            'title' => 'Modul 2: Routing & Controller',
            'score' => $m2Score,
            'max' => 20,
            'items' => $m2Items,
            'status' => $m2Score >= 20 ? 'LULUS' : ($m2Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // MODUL 3: BLADE TEMPLATING & LAYOUT (Bobot: 15 Poin)
        // ==========================================
        $m3Score = 0;
        $layoutAppPath = $path . '/resources/views/layouts/app.blade.php';
        $layoutAltPath = $path . '/resources/views/layout.blade.php';
        $hasLayout = File::exists($layoutAppPath) || File::exists($layoutAltPath);
        $layoutContent = $hasLayout ? (File::exists($layoutAppPath) ? File::get($layoutAppPath) : File::get($layoutAltPath)) : '';
        $hasYield = str_contains($layoutContent, '@yield') || str_contains($layoutContent, '&#64;yield');

        $viewFiles = File::exists($path . '/resources/views') 
            ? File::allFiles($path . '/resources/views') 
            : [];
        $hasExtends = false;
        foreach ($viewFiles as $vFile) {
            if (str_ends_with($vFile->getFilename(), '.blade.php')) {
                $c = File::get($vFile->getRealPath());
                if (str_contains($c, '@extends') || str_contains($c, '&#64;extends')) {
                    $hasExtends = true;
                    break;
                }
            }
        }

        $m3Items = [
            [
                'title' => 'Master Layout Blade (layouts/app.blade.php)',
                'passed' => $hasLayout,
                'points' => 5,
                'hint' => 'Buat file resources/views/layouts/app.blade.php sebagai kerangka utama.',
            ],
            [
                'title' => 'Directive @yield(\'content\') di Master Layout',
                'passed' => $hasYield,
                'points' => 5,
                'hint' => 'Gunakan tag @yield(\'content\') sebagai wadah dinamis di master layout.',
            ],
            [
                'title' => 'Pewarisan template dengan @extends(\'layouts.app\')',
                'passed' => $hasExtends,
                'points' => 5,
                'hint' => 'Halaman anak harus mewarisi layout menggunakan tag @extends.',
            ],
        ];
        foreach ($m3Items as $item) {
            if ($item['passed']) $m3Score += $item['points'];
        }
        $results['modules']['modul3'] = [
            'title' => 'Modul 3: Blade Templating & Master Layout',
            'score' => $m3Score,
            'max' => 15,
            'items' => $m3Items,
            'status' => $m3Score >= 15 ? 'LULUS' : ($m3Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // MODUL 4: DATABASE & MIGRATION (Bobot: 15 Poin)
        // ==========================================
        $m4Score = 0;
        $migrationFiles = File::exists($path . '/database/migrations') 
            ? File::glob($path . '/database/migrations/*table.php') 
            : [];
        $hasMigration = count($migrationFiles) > 0;
        $hasCustomColumns = false;

        foreach ($migrationFiles as $mFile) {
            $content = File::get($mFile);
            if (str_contains($content, 'kode_barang') || str_contains($content, 'nama_barang') || str_contains($content, 'stok')) {
                $hasCustomColumns = true;
                break;
            }
        }

        $m4Items = [
            [
                'title' => 'Folder database/migrations & file migrasi',
                'passed' => $hasMigration,
                'points' => 7,
                'hint' => 'Jalankan php artisan make:migration create_items_table di folder proyek siswa.',
            ],
            [
                'title' => 'Skema kolom tabel (kode_barang, nama_barang, atau stok)',
                'passed' => $hasCustomColumns,
                'points' => 8,
                'hint' => 'Rancang kolom $table->string(\'kode_barang\'); dan $table->string(\'nama_barang\'); di file migrasi.',
            ],
        ];
        foreach ($m4Items as $item) {
            if ($item['passed']) $m4Score += $item['points'];
        }
        $results['modules']['modul4'] = [
            'title' => 'Modul 4: Database & Migrations',
            'score' => $m4Score,
            'max' => 15,
            'items' => $m4Items,
            'status' => $m4Score >= 15 ? 'LULUS' : ($m4Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // MODUL 5: ELOQUENT ORM & FORM CSRF (Bobot: 15 Poin)
        // ==========================================
        $m5Score = 0;
        $modelFiles = File::exists($path . '/app/Models') 
            ? File::glob($path . '/app/Models/*.php') 
            : [];
        $hasModel = false;
        $hasFillable = false;

        foreach ($modelFiles as $moFile) {
            if (basename($moFile) !== 'User.php') {
                $hasModel = true;
                $content = File::get($moFile);
                if (str_contains($content, '$fillable')) {
                    $hasFillable = true;
                }
            }
        }

        $hasCsrf = false;
        foreach ($viewFiles as $vFile) {
            $c = File::get($vFile->getRealPath());
            if (str_contains($c, '@csrf') || str_contains($c, '&#64;csrf')) {
                $hasCsrf = true;
                break;
            }
        }

        $m5Items = [
            [
                'title' => 'Model Eloquent dibuat (Item / Barang / Buku)',
                'passed' => $hasModel,
                'points' => 5,
                'hint' => 'Jalankan php artisan make:model Item di folder siswa.',
            ],
            [
                'title' => 'Properti protected $fillable terpasang di Model',
                'passed' => $hasFillable,
                'points' => 5,
                'hint' => 'Tambahkan protected $fillable = [\'kode_barang\', \'nama_barang\', \'stok\']; di dalam Model.',
            ],
            [
                'title' => 'Tag wajib keamanan @csrf di dalam form HTML',
                'passed' => $hasCsrf,
                'points' => 5,
                'hint' => 'Pastikan tag form menyertakan directive @csrf.',
            ],
        ];
        foreach ($m5Items as $item) {
            if ($item['passed']) $m5Score += $item['points'];
        }
        $results['modules']['modul5'] = [
            'title' => 'Modul 5: Eloquent ORM & Proteksi @csrf',
            'score' => $m5Score,
            'max' => 15,
            'items' => $m5Items,
            'status' => $m5Score >= 15 ? 'LULUS' : ($m5Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // MODUL 6: UPDATE, DELETE & VALIDASI FORM (Bobot: 20 Poin)
        // ==========================================
        $m6Score = 0;
        $hasPutMethod = false;
        $hasDeleteMethod = false;
        foreach ($viewFiles as $vFile) {
            $c = File::get($vFile->getRealPath());
            if (str_contains($c, "@method('PUT')") || str_contains($c, "@method('PATCH')") || str_contains($c, "&#64;method('PUT')")) {
                $hasPutMethod = true;
            }
            if (str_contains($c, "@method('DELETE')") || str_contains($c, "&#64;method('DELETE')")) {
                $hasDeleteMethod = true;
            }
        }

        $hasValidation = false;
        foreach ($controllerFiles as $cFile) {
            $cContent = File::get($cFile);
            if (str_contains($cContent, 'validate(') || str_contains($cContent, 'Validator::make')) {
                $hasValidation = true;
                break;
            }
        }

        $m6Items = [
            [
                'title' => 'Method Spoofing @method(\'PUT\') untuk Edit Data',
                'passed' => $hasPutMethod,
                'points' => 6,
                'hint' => 'Gunakan @method(\'PUT\') di form edit barang.',
            ],
            [
                'title' => 'Method Spoofing @method(\'DELETE\') untuk Hapus Data',
                'passed' => $hasDeleteMethod,
                'points' => 6,
                'hint' => 'Gunakan form dengan @method(\'DELETE\') pada tombol hapus data.',
            ],
            [
                'title' => 'Proteksi input form dengan $request->validate() di Controller',
                'passed' => $hasValidation,
                'points' => 8,
                'hint' => 'Terapkan $request->validate([\'nama_barang\' => \'required\']); di method store/update Controller.',
            ],
        ];
        foreach ($m6Items as $item) {
            if ($item['passed']) $m6Score += $item['points'];
        }
        $results['modules']['modul6'] = [
            'title' => 'Modul 6: CRUD Lengkap & Validasi Form',
            'score' => $m6Score,
            'max' => 20,
            'items' => $m6Items,
            'status' => $m6Score >= 20 ? 'LULUS' : ($m6Score > 0 ? 'SEBAGIAN' : 'BELUM'),
        ];

        // ==========================================
        // KALKULASI TOTAL SKOR & PREDIKAT
        // ==========================================
        $totalScore = $m1Score + $m2Score + $m3Score + $m4Score + $m5Score + $m6Score;
        $results['total_score'] = $totalScore;
        $results['percentage'] = round(($totalScore / 100) * 100);

        if ($totalScore >= 85) {
            $results['grade'] = 'A (Sangat Kompeten)';
            $results['summary_status'] = 'Lulus Sangat Memuaskan';
        } elseif ($totalScore >= 70) {
            $results['grade'] = 'B (Kompeten)';
            $results['summary_status'] = 'Lulus Standar Industri SMK';
        } elseif ($totalScore >= 50) {
            $results['grade'] = 'C (Cukup / Perlu Bimbingan)';
            $results['summary_status'] = 'Masih Ada Modul Belum Lengkap';
        } else {
            $results['grade'] = 'D (Belum Kompeten)';
            $results['summary_status'] = 'Baru Memulai Proyek';
        }

        return $results;
    }
}
