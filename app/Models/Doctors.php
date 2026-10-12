<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Doctors extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'doctors';
    public $timestamps = false;

    protected $fillable = [
        'nama_dokter',
        'spesialisasi',
        'no_wa',
        'status',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'doctors_id');
    }
}
