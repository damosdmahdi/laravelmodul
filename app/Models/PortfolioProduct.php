<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProduct extends Model
{
    use HasFactory;

    protected $table = 'portfolio_products';

    protected $fillable = [
        'portfolio_id',
        'nama_produk',
        'harga',
        'foto',
        'deskripsi',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
