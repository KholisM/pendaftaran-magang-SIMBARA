<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'asal_sekolah',
        'jurusan',
        'semester',
        'tanggal_mulai',
        'tanggal_selesai',
        'surat_pengantar_path',
        'cv_path',
        'status',
        'surat_diterima_path',
        'surat_ditolak_path',
        'catatan_revisi',
        'sertifikat_path'
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            'magang_berjalan' => 'Magang Berjalan',
            'magang_selesai' => 'Magang Selesai',
            default => ucwords(str_replace('_', ' ', $this->status))
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'diterima' => 'green',
            'ditolak' => 'red',
            'revisi' => 'red',
            'magang_berjalan' => 'blue',
            'magang_selesai' => 'gray',
            default => 'yellow'
        };
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function biodata()
    {
        return $this->hasOneThrough(Biodata::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}