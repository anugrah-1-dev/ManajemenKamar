<?php
// database/seeders/PendaftaranProgramOnlineSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendaftaranProgramOnline;
use Illuminate\Support\Str;
use App\Models\ProgramOnline;
use App\Models\Period;

class PendaftaranProgramOnlineSeeder extends Seeder
{
    public function run(): void
    {

        $programIds = ProgramOnline::pluck('id')->toArray();
        $periodIds = Period::pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {
            PendaftaranProgramOnline::create([
                'trx_id' => 'TRX' . Str::upper(Str::random(8)),
                'nama_lengkap' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'no_hp' => '08' . rand(1111111111, 9999999999),
                'asal_kota' => fake()->city(),
                'program_id' => fake()->randomElement($programIds),
                'period_id' => fake()->randomElement($periodIds),
                'bukti_pembayaran' => 'bukti_pembayaran_dummy.jpg',
                'status' => fake()->randomElement(['pending', 'diterima', 'ditolak']),
            ]);
        }
    }   
}
