<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOffline;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProgramOfflineSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Public Speaking', 'TOEFL Preparation', 'IELTS Preparation', 'Grammar Focus'];
        $locations = ['Pare, Kediri', 'Surabaya', 'Jakarta', 'Bandung'];
        $languages = ['Inggris', 'Jerman', 'Mandarin', 'Arab'];
        $features = [
            'Asrama, Modul, Sertifikat',
            'Asrama, Modul, Try Out',
            'Modul, Sertifikat, Konsultasi',
            'Asrama, Sertifikat, Study Tour'
        ];

        for ($i = 1; $i <= 10; $i++) {
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addWeeks(rand(1, 4));
            $namaProgram = 'Program Offline ' . $i;

            ProgramOffline::create([
                'nama'             => $namaProgram,
                'program_bahasa'   => $languages[array_rand($languages)], // ✅ wajib
                'slug'             => Str::slug($namaProgram) . '-' . Str::random(5), // biar unik
                'lama_program'     => rand(1, 6) . ' Minggu',
                'kategori'         => $categories[array_rand($categories)],
                'harga'            => rand(1000000, 3000000),
                'features_program' => $features[array_rand($features)],
                'lokasi'           => $locations[array_rand($locations)],
                'jadwal_mulai'     => $startDate,
                'jadwal_selesai'   => $endDate,
                'kuota'            => rand(10, 40),
                'is_active'        => 1,
                'thumbnail'        => "https://placehold.co/600x400/31343C/EEE?text=Program+Offline+$i",
                'created_at'       => Carbon::now()->subMonths(rand(0, 11)),
                'updated_at'       => now(),
            ]);
        }
    }
}
