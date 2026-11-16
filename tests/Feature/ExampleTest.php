<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Item;
use App\Models\Peminjaman;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all educational and case study routes return 200 OK.
     */
    public function test_all_modul_and_lab_routes_are_accessible(): void
    {
        $item = Item::create([
            'kode_barang' => 'TEST-001',
            'nama_barang' => 'Barang Uji Coba',
            'kategori' => 'Komputer',
            'stok' => 5,
            'kondisi' => 'Baik',
        ]);

        $routes = [
            '/',
            '/belajar',
            '/belajar/modul-1',
            '/belajar/modul-2',
            '/belajar/modul-3',
            '/belajar/modul-4',
            '/belajar/modul-5',
            '/belajar/modul-6',
            '/belajar/materi-lanjutan',
            '/belajar/keamanan',
            '/lab-kasus',
            '/lab-kasus?mode=dummy',
            '/lab-kasus/tambah',
            "/lab-kasus/detail/{$item->id}",
            "/lab-kasus/edit/{$item->id}",
            '/lab-kasus/trash',
            '/lab-kasus/laporan',
            '/lab-kasus/peminjaman',
            '/lab-kasus/peminjaman/tambah',
            '/lab-kasus/api-docs',
            '/api/v1/items',
            "/api/v1/items/{$item->id}",
            '/api/v1/stats',
            '/tugas-siswa',
            '/tugas-siswa/api/check',
            '/template-statis',
            '/template-statis/tambah',
            '/template-statis/edit',
            '/belajar/ukk',
            '/belajar/ukk/uji-kompetensi',
            '/ukk/admin/login',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Test storing an item via lab-kasus.store.
     */
    public function test_store_item_works_in_lab_kasus(): void
    {
        $response = $this->post('/lab-kasus/simpan', [
            'kode_barang' => 'LAB-NEW',
            'nama_barang' => 'Mouse Gaming Optik',
            'kategori' => 'Peralatan',
            'stok' => 10,
            'kondisi' => 'Baik',
        ]);

        $response->assertRedirect('/lab-kasus');
        $this->assertDatabaseHas('items', ['kode_barang' => 'LAB-NEW']);
    }

    /**
     * Test loan transaction: borrow item, decrement stock, and return item.
     */
    public function test_peminjaman_and_pengembalian_works(): void
    {
        $item = Item::create([
            'kode_barang' => 'LOAN-001',
            'nama_barang' => 'Crimping Tool UTP',
            'kategori' => 'Peralatan',
            'stok' => 10,
            'kondisi' => 'Baik',
        ]);

        // 1. Catat peminjaman 3 unit
        $response = $this->post('/lab-kasus/peminjaman/simpan', [
            'item_id' => $item->id,
            'nama_peminjam' => 'Ahmad Fajar',
            'kelas' => '11 RPL 1',
            'jumlah' => 3,
            'tanggal_pinjam' => now()->format('Y-m-d'),
            'catatan' => 'Praktik Jaringan',
        ]);

        $response->assertRedirect('/lab-kasus/peminjaman');
        $this->assertEquals(7, $item->fresh()->stok);

        $loan = Peminjaman::first();
        $this->assertNotNull($loan);
        $this->assertEquals('Dipinjam', $loan->status);

        // 2. Kembalikan barang
        $returnResponse = $this->post("/lab-kasus/peminjaman/{$loan->id}/kembali");
        $returnResponse->assertRedirect('/lab-kasus/peminjaman');
        $this->assertEquals(10, $item->fresh()->stok);
        $this->assertEquals('Dikembalikan', $loan->fresh()->status);
    }

    /**
     * Test soft delete and restore.
     */
    public function test_soft_delete_and_restore_works(): void
    {
        $item = Item::create([
            'kode_barang' => 'DEL-001',
            'nama_barang' => 'Switch Hub Rusak',
            'kategori' => 'Jaringan',
            'stok' => 1,
            'kondisi' => 'Rusak Berat',
        ]);

        // Soft delete
        $delResponse = $this->delete("/lab-kasus/hapus/{$item->id}");
        $delResponse->assertRedirect('/lab-kasus');
        $this->assertSoftDeleted('items', ['id' => $item->id]);

        // Restore
        $restoreResponse = $this->post("/lab-kasus/trash/{$item->id}/restore");
        $restoreResponse->assertRedirect('/lab-kasus/trash');
        $this->assertNull($item->fresh()->deleted_at);
    }

    /**
     * Test API endpoints.
     */
    public function test_rest_api_endpoints_work(): void
    {
        $response = $this->postJson('/api/v1/items', [
            'kode_barang' => 'API-001',
            'nama_barang' => 'Raspberry Pi 4 Model B',
            'kategori' => 'Elektronik',
            'stok' => 6,
            'kondisi' => 'Baik',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('items', ['kode_barang' => 'API-001']);
    }

    /**
     * Test security hub simulation endpoints.
     */
    public function test_security_simulation_endpoints(): void
    {
        // 1. RBAC: Role Siswa accessing delete_all returns 403
        $rbacResponse = $this->postJson('/belajar/keamanan/role-check', [
            'role' => 'siswa',
            'action' => 'delete_all',
        ]);
        $rbacResponse->assertStatus(403);

        // 2. RBAC: Role Guru accessing delete_all returns 200
        $rbacGuruResponse = $this->postJson('/belajar/keamanan/role-check', [
            'role' => 'guru',
            'action' => 'delete_all',
        ]);
        $rbacGuruResponse->assertStatus(200);

        // 3. Password Hashing Endpoint
        $hashResponse = $this->postJson('/belajar/keamanan/hash', [
            'password' => 'smkhebat123',
        ]);
        $hashResponse->assertStatus(200)
                     ->assertJsonStructure(['status', 'password_asli', 'md5', 'bcrypt']);
    }

    /**
     * Test autochecker initialization.
     */
    public function test_init_tugas_siswa_workspace_works(): void
    {
        $response = $this->post('/tugas-siswa/init');
        $response->assertRedirect('/tugas-siswa');
        $this->assertDirectoryExists(base_path('tugas-siswa'));
    }

    /**
     * Test UKK slug check API endpoint.
     */
    public function test_ukk_check_slug_api(): void
    {
        Portfolio::create([
            'nama_usaha' => 'Kue Enak Bu Sri',
            'slug' => 'kue-enak-bu-sri',
            'bio' => 'Aneka kue basah dan kering rumahan berkualitas.',
            'whatsapp' => '081234567890',
            'status' => 'published',
        ]);

        // 1. Existing slug should return available: false
        $dupResponse = $this->getJson('/api/check-slug?slug=kue-enak-bu-sri');
        $dupResponse->assertStatus(200)
                    ->assertJson(['available' => false]);

        // 2. New unique slug should return available: true
        $uniqueResponse = $this->getJson('/api/check-slug?slug=bengkel-jaya-motor');
        $uniqueResponse->assertStatus(200)
                       ->assertJson(['available' => true]);
    }

    /**
     * Test UKK Admin authentication, Portfolio CRUD and toggle publish.
     */
    public function test_ukk_admin_workflow_and_portfolio_crud(): void
    {
        $admin = Admin::create([
            'name' => 'Admin Test',
            'username' => 'admintest',
            'email' => 'admintest@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        // 1. Login
        $loginRes = $this->post('/ukk/admin/login', [
            'username' => 'admintest',
            'password' => 'secret123',
        ]);
        $loginRes->assertRedirect('/ukk/admin');

        // 2. Access dashboard with session
        $dashRes = $this->withSession(['ukk_admin_id' => $admin->id])->get('/ukk/admin');
        $dashRes->assertStatus(200);

        // 3. Create portfolio
        $createRes = $this->withSession(['ukk_admin_id' => $admin->id])->post('/ukk/admin/portfolios', [
            'nama_usaha' => 'Warung Kopi Senja',
            'tagline' => 'Kopi nikmat harga bersahabat',
            'slug' => 'warung-kopi-senja',
            'whatsapp' => '08987654321',
            'alamat' => 'Jl. Pahlawan No. 45',
            'bio' => 'Menyediakan aneka seduhan kopi nusantara.',
            'status' => 'published',
        ]);
        $createRes->assertRedirect('/ukk/admin');
        $this->assertDatabaseHas('portfolios', ['slug' => 'warung-kopi-senja']);

        // 4. Verify public page works
        $publicRes = $this->get('/umkm/warung-kopi-senja');
        $publicRes->assertStatus(200)
                  ->assertSee('Warung Kopi Senja')
                  ->assertSee('Kopi nikmat harga bersahabat');

        // 5. Toggle publish status to draft
        $portfolio = Portfolio::where('slug', 'warung-kopi-senja')->first();
        $toggleRes = $this->withSession(['ukk_admin_id' => $admin->id])
            ->from('/ukk/admin')
            ->post("/ukk/admin/portfolios/{$portfolio->id}/toggle");
        $toggleRes->assertRedirect('/ukk/admin');
        $this->assertEquals('draft', $portfolio->fresh()->status);

        // 6. Draft status returns 404 for public
        $draftPublicRes = $this->get('/umkm/warung-kopi-senja');
        $draftPublicRes->assertStatus(404);
    }

    /**
     * Test UKK 404 handler for nonexistent slug.
     */
    public function test_ukk_nonexistent_slug_returns_custom_404(): void
    {
        $response = $this->get('/umkm/slug-yang-tidak-ada-sama-sekali');
        $response->assertStatus(404)
                 ->assertSee('Portofolio Tidak Ditemukan');
    }

    /**
     * Test Materi Lanjutan page loads correctly with all 7 architecture topics.
     */
    public function test_materi_lanjutan_page_loads_with_all_simulators(): void
    {
        $response = $this->get('/belajar/materi-lanjutan');
        $response->assertStatus(200)
                 ->assertSee('7 Konsep Inti Arsitektur Laravel Modern')
                 ->assertSee('Route Model Binding & Custom Key')
                 ->assertSee('N+1 Query Problem')
                 ->assertSee('File Storage, Validasi Upload')
                 ->assertSee('Database Transactions')
                 ->assertSee('Eloquent Accessors, Mutators')
                 ->assertSee('Model Observers & Lifecycle Events')
                 ->assertSee('Pipeline Middleware');
    }
}
