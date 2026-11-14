<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'stok',
        'kondisi',
    ];

    /**
     * Relasi ke transaksi peminjaman
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Scope filter pencarian barang
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['q'] ?? false, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        });

        $query->when($filters['kategori'] ?? false, function ($q, $kategori) {
            $q->where('kategori', $kategori);
        });

        $query->when($filters['kondisi'] ?? false, function ($q, $kondisi) {
            $q->where('kondisi', $kondisi);
        });
    }
}
