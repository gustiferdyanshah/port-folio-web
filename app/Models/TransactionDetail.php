<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transactions_details'; 

    public $timestamps = false;

    public function reservasi()
    {
        return $this->belongsTo(ReservasiService::class, 'reservasi_service_id');
    }

    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'terapis_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pelanggan::class, 'pasien_id'); 
    }
     public function treatment()
    {
        return $this->belongsTo(Treatments::class, 'treatment_id');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
    
}

