<?php

use App\Models\PendaftaranProgramCamp;

if (!function_exists('getHargaDurasi')) {
    function getHargaDurasi($pendaftaran)
    {
        // Pastikan relasi programCamp tersedia
        if (!$pendaftaran->programCamp) {
            return 0; // Fallback jika data tidak ditemukan
        }

        $durasi = $pendaftaran->durasi_paket; // Pastikan nama kolom benar!
        $program = $pendaftaran->programCamp;

        switch ($durasi) {
            case 'satu_minggu':
                return $program->harga_satu_minggu;
            case 'dua_minggu':
                return $program->harga_dua_minggu;
            case 'tiga_minggu':
                return $program->harga_tiga_minggu;
            case 'satu_bulan':
                return $program->harga_satu_bulan;
            case 'dua_bulan':
                return $program->harga_dua_bulan;
            case 'tiga_bulan':
                return $program->harga_tiga_bulan;
            case 'enam_bulan':
                return $program->harga_enam_bulan;
            case 'satu_tahun':
                return $program->harga_satu_tahun;
            case 'perhari':
                return $program->harga_perhari;
            default:
                return $program->harga_perhari; // Fallback

        }
    }
}
