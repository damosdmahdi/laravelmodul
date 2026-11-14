<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
