<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'magang_dibuka',
        'informasi'
    ];

    protected $casts = [
        'magang_dibuka' => 'boolean',
    ];
}