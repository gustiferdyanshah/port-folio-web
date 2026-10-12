<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentsDoctor;
use App\Models\Treatments;
use App\Models\ReservasiService;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'appointments_doctor_id',
        'treatments_id',
        'catatan',
        'jam_treatment',
        'periode_pelaksanaan',
        'jumlah_pelaksanaan',
        'jumlah_treatment'
    ];

    public function appointment()
    {
        return $this->belongsTo(AppointmentsDoctor::class, 'appointments_doctor_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatments::class, 'treatments_id');
    }

    public function reservasi()
    {
        return $this->hasMany(ReservasiService::class, 'services_id');
    }

    public function produk()
    {
        return $this->belongsToMany(
            Produk::class,
            'appointment_product', 
            'appointments_doctor_id',
            'product_id'
        );
    }

}
