<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;
use App\Models\Services;
use App\Models\Schedules;
use App\Models\ReservasiService;

class AppointmentsDoctor extends Model
{
    use HasFactory;

    protected $table = 'appointments_doctor';

    protected $fillable = [
        'status',
        'tanggal_berikutnya',
        'schedules_id',
        'customer_id',
        'hasil_konsultasi', 
    ];

    public function customer()
    {
        return $this->belongsTo(Pelanggan::class, 'customer_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedules::class, 'schedules_id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'appointments_doctor_id');
    }

    public function reservasiServices()
    {
        return $this->hasManyThrough(
            ReservasiService::class,
            Services::class,
            'appointments_doctor_id',
            'services_id',            
            'id',                     
            'id'                      
        );
    }
}
