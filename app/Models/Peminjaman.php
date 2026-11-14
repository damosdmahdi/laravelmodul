<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjamans';

    protected $fillable = [
        'item_id',
        'nama_peminjam',
        'kelas',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Relasi balik ke Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
