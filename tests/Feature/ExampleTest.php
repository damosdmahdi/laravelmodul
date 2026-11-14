<?php

namespace Tests\Feature;

use App\Models\Item;
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
            '/lab-kasus',
            '/lab-kasus?mode=dummy',
            '/lab-kasus/tambah',
            "/lab-kasus/edit/{$item->id}",
            '/lab-kasus/simulasi-kelompok',
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
}
