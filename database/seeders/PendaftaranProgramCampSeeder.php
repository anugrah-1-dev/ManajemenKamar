<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendaftaranProgramCamp;
use App\Models\ProgramCamp;
use App\Models\Period;
use Illuminate\Support\Str;

class PendaftaranProgramCampSeeder extends Seeder
{
    public function run(): void
    {
        $programs = ProgramCamp::pluck('id')->toArray();
        $periods = Period::pluck('id')->toArray();

        foreach (range(1, 5) as $i) {
            PendaftaranProgramCamp::create([
                'nama_lengkap' => 'Peserta ' . $i,
                'email' => "peserta{$i}@example.com",
                'no_hp' => '08123' . rand(100000, 999999),
                'asal_kota' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan'][array_rand([1, 2, 3, 4])],
                'program_camp_id' => $programs[array_rand($programs)],
                'period_id' => $periods[array_rand($periods)],
                'durasi_paket' => ['perhari', '1 minggu', '2 minggu', '1 bulan'][array_rand([1, 2, 3, 4])],
                'nama_kamar' => 'Kamar ' . rand(1, 10),
                'bukti_pembayaran' => null, // belum diunggah
                'status' => 'pending',
            ]);
        }
    }
}
