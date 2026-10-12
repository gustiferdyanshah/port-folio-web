<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\AppointmentsDoctor;
use App\Models\Services;
use App\Models\ReservasiService;

class Pelanggan extends Authenticatable
{
    protected $table = 'customer';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'birth_date',
        'jenis_kelamin',
        'alergi',
        'no_wa',
        'skin_types_id',
        'users_id'
    ];

    protected $hidden = ['password'];

    public function appointments(): HasMany
    {
        return $this->hasMany(AppointmentsDoctor::class, 'customer_id');
    }

    public function services(): HasManyThrough
    {
        return $this->hasManyThrough(
            Services::class,
            AppointmentsDoctor::class,
            'customer_id',
            'appointments_doctor_id',
            'id',
            'id'
        );
    }

   
    public function reservasi(): HasManyThrough
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
