<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'portfolios';

    protected $fillable = [
        'admin_id',
        'nama_usaha',
        'tagline',
        'slug',
        'bio',
        'whatsapp',
        'alamat',
        'logo',
        'banner',
        'status',
        'views',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function products()
    {
        return $this->hasMany(PortfolioProduct::class);
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['q'] ?? false, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama_usaha', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        });

        $query->when($filters['status'] ?? false, function ($q, $status) {
            $q->where('status', $status);
        });
    }

    /**
     * Format nomor WhatsApp ke URL link wa.me resmi
     */
    public function getWhatsappLinkAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $pesan = urlencode("Halo {$this->nama_usaha}, saya tertarik untuk memesan produk Anda dari website portofolio.");
        return "https://wa.me/{$phone}?text={$pesan}";
    }
}
