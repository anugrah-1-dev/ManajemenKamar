<?php

namespace App\Helpers;

class RoomFront
{
    public static function getStatusClass($kapasitas, $terisi, $status = 'aktif')
    {
        if ($status === 'nonaktif') {
            return 'bg-secondary'; // Warna abu-abu (Bootstrap)
        }

        if ($terisi >= $kapasitas) {
            return 'bg-danger'; // Penuh
        } elseif ($terisi >= ($kapasitas / 2)) {
            return 'bg-warning'; // Setengah
        } else {
            return 'bg-success'; // Masih banyak
        }
    }


    public static function getRoomStatusText($kapasitas, $terisi, $status = 'aktif')
    {
        if ($status === 'nonaktif') {
            return 'Dalam Perbaikan';
        }

        if ($terisi >= $kapasitas) {
            return 'Penuh';
        } elseif ($terisi >= ($kapasitas / 2)) {
            return 'Hampir Penuh';
        } else {
            return 'Tersedia';
        }
    }


    // Kalau mau filter berdasarkan gender + kategori
    public static function filter($rooms, $gender, $kategori)
    {
        return $rooms->where('gender', $gender)->where('kategori', $kategori);
    }
}
