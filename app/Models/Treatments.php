<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Services;

class Treatments extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'nama_treatment',
        'deskripsi',
        'harga',
        'durasi',
        'kategori',
    ];

    public function services()
    {
        return $this->hasMany(Services::class, 'treatments_id');
    }
}
