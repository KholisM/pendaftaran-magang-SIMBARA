<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    protected $guarded = [];

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}