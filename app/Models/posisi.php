<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_posisi',
        'kuota',
        'deskripsi'
    ];

    public function lamarans()
{
    return $this->hasMany(Lamaran::class, 'posisi_id');
}
}