<?php

namespace App\Services;

use App\Models\Lamaran;

class LamaranService
{
    public function hasActiveLamaran($userId)
    {
        $lamaran = Lamaran::where('user_id', $userId)
            ->latest()
            ->first();

        // Mengembalikan true jika ada lamaran dengan status pending atau diterima
        return $lamaran && in_array($lamaran->status, ['pending', 'diterima','magang_berjalan']);
    }

    public function getLatestLamaranStatus($userId)
    {
        $lamaran = Lamaran::where('user_id', $userId)
            ->latest()
            ->first();

        return $lamaran ? $lamaran->status : null;
    }
}