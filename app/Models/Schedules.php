<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentsDoctor;
use App\Models\Doctors;

class Schedules extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'tanggal',
        'jam',
        'doctors_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctors_id');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentsDoctor::class, 'schedules_id');
    }
}
