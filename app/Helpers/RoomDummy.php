<?php

namespace App\Helpers;

use App\Models\Rooms;
use App\Models\PendaftaranProgramCamp;

class RoomDummy
{
    public static function getRooms()
    {
        // Ambil semua data kamar dari DB, index berdasarkan nomor_kamar
        $roomsFromDB = Rooms::all()->keyBy('nomor_kamar');

        $rooms = [];

        // Helper buat merge data DB dengan template
        $merge = function ($nomor, $kategori) use ($roomsFromDB) {
            if (isset($roomsFromDB[$nomor])) {
                return $roomsFromDB[$nomor]; // pakai data asli dari DB
            }

            // Kalau belum ada di DB, buat object dummy
            return (object)[
                'nomor_kamar' => $nomor,
                'kategori'    => $kategori,
                'penghuni'    => 0,
                'kapasitas'   => 0,
                'status'      => 'aktif',
                'gender'      => null,
            ];
        };



        // VVIP
        foreach (range(19, 28) as $i) {
            $rooms[] = $merge("A-{$i}", 'vvip');
        }

        // VIP - A blok 1-18
        foreach (range(1, 18) as $i) {
            $rooms[] = $merge(sprintf("A-%02d", $i), 'vip');
        }

        // VIP - A blok 29-46
        foreach (range(29, 46) as $i) {
            $rooms[] = $merge("A-{$i}", 'vip');
        }

        // VIP - B blok 1-50 + B-12B
        foreach (range(1, 50) as $i) {
            $rooms[] = $merge("B-{$i}", 'vip');
        }
        $rooms[] = $merge('B-12B', 'vip');

        // VIP - C blok 1-50 + C-12C
        foreach (range(1, 50) as $i) {
            $rooms[] = $merge("C-{$i}", 'vip');
        }
        $rooms[] = $merge('C-12C', 'vip');

        // BARACK
        $rooms[] = $merge('A-12A', 'barack');
        $rooms[] = $merge('A-35',  'barack');

        return collect($rooms);
    }


    public static function filter($rooms, $prefix, $start, $end, $gender = null)
    {
        return collect($rooms)->filter(function ($room) use ($prefix, $start, $end, $gender) {
            // Ambil nomor kamar tanpa prefix
            $roomNumber = intval(str_replace($prefix . '-', '', $room->nomor_kamar));
            $matchesPrefix = str_starts_with($room->nomor_kamar, $prefix . '-');
            $matchesRange = $roomNumber >= $start && $roomNumber <= $end;
            $matchesGender = $gender ? $room->gender === $gender : true;

            return $matchesPrefix && $matchesRange && $matchesGender;
        });
    }

    // public static function getStatusClass($room)
    // {
    //     if ($room->status === 'nonaktif') {
    //         return 'room-nonaktif'; // Misal ini warna abu-abu di CSS-mu
    //     }

    //     $penghuni = $room->penghuni ?? 0;
    //     $kapasitas = $room->kapasitas ?? 1;

    //     return match (true) {
    //         $penghuni >= $kapasitas => 'room-full',
    //         $penghuni > 0 => 'room-partial',
    //         default => 'room-empty'
    //     };
    // }

    //new
    // public static function getStatusClass($room, $penghuniAktif = 0)
    // {
    //     if ($room->status === 'nonaktif') {
    //         return 'room-nonaktif'; // Warna abu-abu
    //     }

    //     $kapasitas = $room->kapasitas ?? 1;

    //     return match (true) {
    //         $penghuniAktif >= $kapasitas => 'room-full',
    //         $penghuniAktif > 0 => 'room-partial',
    //         default => 'room-empty'
    //     };
    // }


    // public static function getStatusText($room)
    // {
    //     if ($room->status === 'nonaktif') {
    //         return 'Dalam Perbaikan';
    //     }

    //     $penghuni = $room->penghuni ?? 0;
    //     $kapasitas = $room->kapasitas ?? 1;

    //     return match (true) {
    //         $penghuni >= $kapasitas => 'Penuh',
    //         $penghuni > 0 => 'Hampir Penuh',
    //         default => 'Kosong'
    //     };
    // }

    //new
    // public static function getStatusText($room, $penghuniAktif = 0)
    // {
    //     if ($room->status === 'nonaktif') {
    //         return 'Dalam Perbaikan';
    //     }

    //     $kapasitas = $room->kapasitas ?? 1;

    //     return match (true) {
    //         $penghuniAktif >= $kapasitas => 'Penuh',
    //         $penghuniAktif > 0 => 'Hampir Penuh',
    //         default => 'Kosong'
    //     };
    // }


    // public static function getStatusClass($room, $penghuniAktif = null)
    // {
    //     if ($room->status === 'nonaktif') {
    //         return 'room-nonaktif'; // Warna abu-abu
    //     }

    //     // Pastikan nilai penghuni aktif tidak null
    //     $penghuni = (int) ($penghuniAktif ?? $room->penghuni ?? 0);
    //     $kapasitas = max((int) ($room->kapasitas ?? 1), 1); // minimal 1 biar tidak error

    //     return match (true) {
    //         $penghuni >= $kapasitas => 'room-full',
    //         $penghuni > 0 => 'room-partial',
    //         default => 'room-empty'
    //     };
    // }

    public static function getStatusClass($room, $penghuniAktif = null)
    {
        if ($room->status === 'nonaktif') {
            return 'room-nonaktif';
        }

        $kapasitas = $room->kapasitas ?? 1;
        if ($penghuniAktif === null) {
            $penghuniAktif = PendaftaranProgramCamp::where('room_id', $room->id)->count();
        }

        return match (true) {
            $penghuniAktif >= $kapasitas => 'room-full',
            $penghuniAktif > 0 => 'room-partial',
            default => 'room-empty'
        };
    }


    public static function getStatusText($room, $penghuniAktif = null)
    {
        if ($room->status === 'nonaktif') {
            return 'Tidak Aktif / Dalam Perbaikan';
        }

        $penghuni = (int) ($penghuniAktif ?? $room->penghuni ?? 0);
        $kapasitas = max((int) ($room->kapasitas ?? 1), 1);

        return match (true) {
            $penghuni >= $kapasitas => 'Penuh',
            $penghuni > 0 => 'Sebagian Terisi',
            default => 'Tersedia'
        };
    }






    public static function warna($room)
    {
        $penghuni = $room->penghuni ?? 0;
        $nomor = $room->nomor_kamar;

        // BARACK
        if (in_array($nomor, ['A-12A', 'A-35'])) {
            return match (true) {
                $penghuni === 0 => '#22c55e',
                $penghuni === 1 => '#a0522d',
                $penghuni === 2 => '#800080',
                $penghuni === 3 => '#ffa500',
                $penghuni === 4 => '#3b82f6',
                $penghuni >= 5 => '#ef4444',
                default => '#d1d5db'
            };
        }

        // VVIP / VIP
        return match ($penghuni) {
            0 => '#22c55e',
            1 => '#facc15',
            default => '#ef4444'
        };
    }



    public static function warnaClass($room)
    {
        $penghuni = $room->penghuni ?? 0;
        $nomor = $room->nomor_kamar;

        if (in_array($nomor, ['A-12A', 'A-35'])) {
            return match (true) {
                $penghuni === 0 => 'bg-green',
                $penghuni === 1 => 'bg-yellow',
                $penghuni >= 2 => 'bg-red',
                default => ''
            };
        }

        return match ($penghuni) {
            0 => 'bg-green',
            1 => 'bg-yellow',
            default => 'bg-red'
        };
    }
}
