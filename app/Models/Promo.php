<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'nama_promo',
        'kode_promo',
        'tipe_promo',
        'diskon_persen',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'gambar',
    ];

    public function products()
    {
        return $this->belongsToMany(
            \App\Models\Produk::class,
            'promo_products',
            'promo_id',
            'product_id'
        );
    }

    public function treatments()
    {
        return $this->belongsToMany(
            \App\Models\Treatments::class,
            'promo_treatments',
            'promo_id',
            'treatment_id'
        );
    }
}
