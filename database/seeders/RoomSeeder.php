<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $rooms = [];

        // KAMAR VVIP (program_camp_id = 1)
        // VVIP Putri
        foreach (range(19, 23) as $num) {
            $rooms[] = $this->makeRoom(1, 'A', $num, 'putri', 'vvip', 3, $now);
        }

        // VVIP Putra
        foreach (range(24, 28) as $num) {
            $rooms[] = $this->makeRoom(1, 'A', $num, 'putra', 'vvip', 3, $now);
        }

        // KAMAR VIP (program_camp_id = 2)
        // A-01 s/d A-18 (Putri)
        foreach (range(1, 18) as $num) {
            $rooms[] = $this->makeRoom(2, 'A', $num, 'putri', 'vip', 4, $now);
        }

        // A-29 s/d A-46 (Putra) KECUALI A-35 DAN A-24 s/d A-28 (sudah dipakai di VVIP)
        foreach (range(29, 46) as $num) {
            if ($num == 35 || ($num >= 24 && $num <= 28)) continue;
            $rooms[] = $this->makeRoom(2, 'A', $num, 'putra', 'vip', 4, $now);
        }

        // B-01 s/d B-25 (Putri)
        foreach (range(1, 25) as $num) {
            $rooms[] = $this->makeRoom(2, 'B', $num, 'putri', 'vip', 4, $now);
        }

        // B-26 s/d B-50 (Putra)
        foreach (range(26, 50) as $num) {
            $rooms[] = $this->makeRoom(2, 'B', $num, 'putra', 'vip', 4, $now);
        }

        // C-01 s/d C-25 (Putri)
        foreach (range(1, 25) as $num) {
            $rooms[] = $this->makeRoom(2, 'C', $num, 'putri', 'vip', 4, $now);
        }

        // C-26 s/d C-50 (Putra)
        foreach (range(26, 50) as $num) {
            $rooms[] = $this->makeRoom(2, 'C', $num, 'putra', 'vip', 4, $now);
        }

        // KAMAR BARACK (program_camp_id = 3)
        $rooms[] = ['program_camp_id' => 3, 'nomor_kamar' => 'A-12A', 'gender' => 'putri', 'kategori' => 'barack', 'kapasitas' => 3, 'created_at' => $now, 'updated_at' => $now];
        $rooms[] = ['program_camp_id' => 3, 'nomor_kamar' => 'A-35',  'gender' => 'putra', 'kategori' => 'barack', 'kapasitas' => 4, 'created_at' => $now, 'updated_at' => $now];

        DB::table('rooms')->upsert($rooms, ['nomor_kamar'], ['program_camp_id', 'gender', 'kategori', 'kapasitas', 'updated_at']);
    }

    private function makeRoom($program_camp_id, $block, $num, $gender, $kategori, $kapasitas, $now)
    {
        $nomor_kamar = $block . '-' . str_pad($num, 2, '0', STR_PAD_LEFT);
        return [
            'program_camp_id' => $program_camp_id,
            'nomor_kamar'     => $nomor_kamar,
            'gender'          => strtolower($gender),
            'kategori'        => strtolower($kategori),
            'kapasitas'       => $kapasitas,
            'created_at'      => $now,
            'updated_at'      => $now,
        ];
    }
}
