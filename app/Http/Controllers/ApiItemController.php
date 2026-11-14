<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiItemController extends Controller
{
    /**
     * GET /api/v1/items
     * Mengambil daftar seluruh barang inventaris lab dalam format JSON
     */
    public function index(Request $request): JsonResponse
    {
        $items = Item::latest()->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data inventaris lab SMK berhasil diambil.',
            'total' => $items->count(),
            'data' => $items,
        ], 200);
    }

    /**
     * GET /api/v1/items/{id}
     * Detail spesifik satu barang beserta relasi peminjamannya
     */
    public function show($id): JsonResponse
    {
        $item = Item::with('peminjamans')->find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => "Barang dengan ID #{$id} tidak ditemukan di database inventaris.",
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => "Detail barang {$item->kode_barang} ditemukan.",
            'data' => $item,
        ], 200);
    }

    /**
     * POST /api/v1/items
     * Endpoint API pembuatan barang baru (cocok untuk dipanggil dari Flutter/React/Postman)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|string|max:50|unique:items,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => 'Validasi data payload gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $item = Item::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'Barang baru berhasil dibuat melalui RESTful API.',
            'data' => $item,
        ], 201);
    }

    /**
     * GET /api/v1/stats
     * Statistik ringkasan inventaris lab untuk dashboard API / Mobile Apps
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Statistik ringkasan inventaris lab SMK.',
            'data' => [
                'total_jenis_barang' => Item::count(),
                'total_unit_stok' => (int) Item::sum('stok'),
                'total_barang_rusak' => Item::where('kondisi', '!=', 'Baik')->count(),
                'total_transaksi_peminjaman' => Peminjaman::count(),
                'total_sedang_dipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
                'server_time' => now()->toIso8601String(),
            ],
        ], 200);
    }
}
