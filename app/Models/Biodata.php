<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'asal_sekolah',
        'jurusan',
        'semester',
        'ipk',
        'profile_photo'
    ];

    protected $dates = [
        'tanggal_lahir'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getProfilePhotoAttribute($value)
    {
        if ($value && Storage::disk('public')->exists(str_replace('/storage/profile_photos/', '', $value))) {
            return $value;
        }
        // Return default image jika tidak ada foto
        return 'profile_photos/default-profile.png'; // Sesuaikan dengan path default image Anda
    }
}