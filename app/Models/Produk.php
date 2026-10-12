<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'products';
    protected $fillable = ['nama', 'deskripsi', 'harga', 'stok','image'];
    public $timestamps = false; 



        public function promos()
    {
        return $this->belongsToMany(
            Promo::class,
            'promo_product',
            'product_id',
            'promo_id'
        );
    }

}

