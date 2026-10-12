<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Services;
use App\Models\Terapis;

class ReservasiService extends Model
{
    use HasFactory;

    protected $table = 'reservasi_service';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_booking', 'jam_booking', 'services_id', 'terapis_id','status',
    ];

     public function appointment()
    {
        return $this->belongsTo(
            AppointmentsDoctor::class,
            'appointments_id',
            'id'
        );
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'services_id');
    }

    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'terapis_id');
    }
}
