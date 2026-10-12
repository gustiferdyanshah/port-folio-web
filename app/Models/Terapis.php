<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReservasiService;

class Terapis extends Model
{
    use HasFactory;

    protected $table = 'terapis';

    protected $fillable = [
        'nama_terapis', 'jenis_kelamin', 'no_wa', 'status'
    ];

    public function reservasi()
    {
        return $this->hasMany(ReservasiService::class, 'terapis_id');
    }
}

