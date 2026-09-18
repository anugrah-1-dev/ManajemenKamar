<?php
// database/seeders/ProgramOnlineSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramOnline; // Pastikan model ini mengarah ke tabel 'program_online'
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProgramOnlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Array contoh untuk program bahasa
        $languages = ['Inggris', 'Jerman', 'Mandarin', 'Arab'];

        for ($i = 1; $i <= 10; $i++) {
            $namaProgram = 'Program Online ' . $i;
            ProgramOnline::create([
                'nama' => $namaProgram,
                // Menambahkan kolom 'program_bahasa' yang wajib diisi
                'program_bahasa' => $languages[array_rand($languages)],
                'slug' => Str::slug($namaProgram),
                'lama_program' => rand(2, 12) . ' Minggu',
                'kategori' => 'General',
                'harga' => rand(500000, 2000000),
                'features_program' => 'Fitur A, Fitur B, Fitur C',
                'is_active' => 1,
                'thumbnail' => 'https://placehold.co/600x400/EEE/31343C?text=Program+' . $i,
                'created_at' => Carbon::now()->subMonths(rand(0, 11)),
                'updated_at' => now(),
            ]);
        }
    }
}
